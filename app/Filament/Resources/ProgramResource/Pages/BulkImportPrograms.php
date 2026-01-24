<?php

namespace App\Filament\Resources\ProgramResource\Pages;

use App\Filament\Resources\ProgramResource;
use App\Models\Country;
use App\Models\Degree;
use App\Models\Program;
use App\Models\Subject;
use App\Models\University;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BulkImportPrograms extends Page
{
    protected static string $resource = ProgramResource::class;

    protected static string $view = 'filament.resources.program-resource.pages.bulk-import-programs';

    protected static ?string $title = 'Bulk Import Programs';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Upload CSV File')
                    ->description('Download the sample CSV template, fill it with your program data, and upload it here.')
                    ->schema([
                        FileUpload::make('csv_file')
                            ->label('CSV File')
                            ->acceptedFileTypes(['text/csv', 'text/plain', 'application/vnd.ms-excel'])
                            ->required()
                            ->helperText('Required columns: title, university_name, country_name, degree_name, subject_name, language, tuition_fee, duration, study_mode, intake, program_url, is_featured, description'),
                    ]),
            ])
            ->statePath('data');
    }

    public function import(): void
    {
        $data = $this->form->getState();

        if (!isset($data['csv_file'])) {
            Notification::make()
                ->title('No file uploaded')
                ->danger()
                ->send();
            return;
        }

        $filePath = Storage::path($data['csv_file']);

        if (!file_exists($filePath)) {
            Notification::make()
                ->title('File not found')
                ->danger()
                ->send();
            return;
        }

        $imported = 0;
        $errors = [];

        try {
            DB::beginTransaction();

            $handle = fopen($filePath, 'r');
            $header = fgetcsv($handle);

            if (!$header) {
                throw new \Exception('CSV file is empty or invalid');
            }

            // Validate headers
            $requiredHeaders = ['title', 'university_name', 'country_name', 'degree_name', 'subject_name'];
            $missingHeaders = array_diff($requiredHeaders, $header);

            if (!empty($missingHeaders)) {
                throw new \Exception('Missing required columns: ' . implode(', ', $missingHeaders));
            }

            $headerMap = array_flip($header);

            while (($row = fgetcsv($handle)) !== false) {
                try {
                    // Skip empty rows
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    $title = $row[$headerMap['title']] ?? null;
                    if (empty($title)) {
                        $errors[] = "Row skipped: Missing title";
                        continue;
                    }

                    // Find or create university
                    $universityName = $row[$headerMap['university_name']] ?? null;
                    $countryName = $row[$headerMap['country_name']] ?? null;

                    if (empty($universityName) || empty($countryName)) {
                        $errors[] = "Row '$title' skipped: Missing university or country";
                        continue;
                    }

                    $country = Country::firstOrCreate(
                        ['name' => $countryName],
                        ['code' => strtoupper(substr($countryName, 0, 2))]
                    );

                    $university = University::firstOrCreate(
                        ['name' => $universityName, 'country_id' => $country->id],
                        ['website' => $row[$headerMap['university_website'] ?? -1] ?? null]
                    );

                    // Find or create degree
                    $degreeName = $row[$headerMap['degree_name']] ?? null;
                    if (empty($degreeName)) {
                        $errors[] = "Row '$title' skipped: Missing degree";
                        continue;
                    }
                    $degree = Degree::firstOrCreate(['name' => $degreeName]);

                    // Find or create subject
                    $subjectName = $row[$headerMap['subject_name']] ?? null;
                    if (empty($subjectName)) {
                        $errors[] = "Row '$title' skipped: Missing subject";
                        continue;
                    }
                    $subject = Subject::firstOrCreate(
                        ['name' => $subjectName],
                        ['category' => $row[$headerMap['subject_category'] ?? -1] ?? null]
                    );

                    // Create program
                    $slug = Str::slug($title . ' ' . $university->name);
                    $slugBase = $slug;
                    $counter = 1;

                    while (Program::where('slug', $slug)->exists()) {
                        $slug = $slugBase . '-' . $counter;
                        $counter++;
                    }

                    Program::create([
                        'title' => $title,
                        'slug' => $slug,
                        'university_id' => $university->id,
                        'country_id' => $country->id,
                        'degree_id' => $degree->id,
                        'subject_id' => $subject->id,
                        'language' => $row[$headerMap['language'] ?? -1] ?? 'English',
                        'tuition_fee' => !empty($row[$headerMap['tuition_fee'] ?? -1]) ? (float)$row[$headerMap['tuition_fee'] ?? -1] : null,
                        'currency' => $row[$headerMap['currency'] ?? -1] ?? 'EUR',
                        'duration' => $row[$headerMap['duration'] ?? -1] ?? null,
                        'intake' => $row[$headerMap['intake'] ?? -1] ?? null,
                        'study_mode' => $row[$headerMap['study_mode'] ?? -1] ?? 'On-campus',
                        'application_deadline' => !empty($row[$headerMap['application_deadline'] ?? -1]) ? $row[$headerMap['application_deadline'] ?? -1] : null,
                        'program_url' => $row[$headerMap['program_url'] ?? -1] ?? null,
                        'is_featured' => isset($headerMap['is_featured']) && in_array(strtolower($row[$headerMap['is_featured']] ?? ''), ['1', 'true', 'yes']),
                        'description' => $row[$headerMap['description'] ?? -1] ?? null,
                        'created_by' => auth()->id(),
                    ]);

                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Row error: " . $e->getMessage();
                }
            }

            fclose($handle);
            DB::commit();

            // Delete uploaded file
            Storage::delete($data['csv_file']);

            $message = "Successfully imported {$imported} programs.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " rows had errors.";
            }

            Notification::make()
                ->title('Import Complete')
                ->body($message)
                ->success()
                ->send();

            if (!empty($errors)) {
                Notification::make()
                    ->title('Import Errors')
                    ->body(implode("\n", array_slice($errors, 0, 5)))
                    ->warning()
                    ->send();
            }

            $this->redirect(ProgramResource::getUrl('index'));

        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($handle) && is_resource($handle)) {
                fclose($handle);
            }

            Notification::make()
                ->title('Import Failed')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function downloadTemplate(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $csv = "title,university_name,university_website,country_name,degree_name,subject_name,subject_category,language,tuition_fee,currency,duration,study_mode,intake,application_deadline,program_url,is_featured,description\n";
        $csv .= "Master of Computer Science,Technical University of Denmark,,Denmark,Master,Computer Science,Engineering,English,15000,EUR,2 years,On-campus,September 2025,2025-03-01,https://example.com/apply,yes,A comprehensive program in computer science.\n";
        $csv .= "Bachelor of Business Administration,Copenhagen Business School,,Denmark,Bachelor,Business Administration,Business,English,12000,EUR,3 years,Hybrid,September 2025,2025-04-01,https://example.com/apply,no,Learn the fundamentals of business management.\n";

        $fileName = 'programs_import_template_' . now()->format('Y-m-d') . '.csv';
        $tempFile = tmpfile();
        $tempFilePath = stream_get_meta_data($tempFile)['uri'];
        fwrite($tempFile, $csv);

        return response()->download($tempFilePath, $fileName, [
            'Content-Type' => 'text/csv',
        ])->deleteFileAfterSend(true);
    }
}
