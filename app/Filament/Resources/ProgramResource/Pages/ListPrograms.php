<?php

namespace App\Filament\Resources\ProgramResource\Pages;

use App\Filament\Resources\ProgramResource;
use App\Models\Country;
use App\Models\Degree;
use App\Models\Program;
use App\Models\Subject;
use App\Models\University;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ListPrograms extends ListRecords
{
    protected static string $resource = ProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('import')
                ->label('Import CSV')
                ->icon('heroicon-o-arrow-up-tray')
                ->form([
                    FileUpload::make('attachment')
                        ->label('Upload CSV File')
                        ->acceptedFileTypes(['text/csv', 'text/plain', 'application/csv'])
                        ->disk('local')
                        ->directory('imports')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $path = Storage::disk('local')->path($data['attachment']);
                    
                    if (!file_exists($path)) {
                        Notification::make()->title('File not found')->danger()->send();
                        return;
                    }

                    $handle = fopen($path, 'r');
                    $header = fgetcsv($handle); // Skip header

                    $count = 0;
                    
                    while (($row = fgetcsv($handle)) !== false) {
                        // Expected Format:
                        // Title, University, Country, Degree, Subject, Tuition, Currency, Language, Study Mode, Duration, Intake, Program URL, Application Deadline, Featured (1/0), Description
                        if (count($row) < 5) continue;

                        $title = trim($row[0]);
                        $uniName = trim($row[1]);
                        $countryName = trim($row[2]);
                        $degreeName = trim($row[3]);
                        $subjectName = trim($row[4]);
                        $fee = $row[5] ?? null;
                        $currency = strtoupper($row[6] ?? 'EUR');
                        $language = $row[7] ?? 'English';
                        $studyMode = $row[8] ?? 'On-campus';
                        $duration = $row[9] ?? null;
                        $intake = $row[10] ?? null;
                        $programUrl = $row[11] ?? null;
                        $applicationDeadline = $row[12] ?? null;
                        $isFeatured = isset($row[13]) ? (bool) $row[13] : false;
                        $description = $row[14] ?? null;

                        $country = Country::firstOrCreate(
                            ['name' => $countryName],
                            ['code' => strtoupper(substr($countryName, 0, 3))]
                        );

                        $university = University::firstOrCreate(
                            ['name' => $uniName],
                            ['country_id' => $country->id]
                        );

                        $degree = Degree::firstOrCreate(['name' => $degreeName]);

                        $subject = Subject::firstOrCreate(['name' => $subjectName]);

                        Program::create([
                            'title' => $title,
                            'slug' => Str::slug($title . '-' . $uniName . '-' . Str::random(4)),
                            'university_id' => $university->id,
                            'country_id' => $country->id,
                            'degree_id' => $degree->id,
                            'subject_id' => $subject->id,
                            'tuition_fee' => $fee,
                            'currency' => $currency,
                            'language' => $language,
                            'study_mode' => $studyMode,
                            'duration' => $duration,
                            'intake' => $intake,
                            'program_url' => $programUrl,
                            'application_deadline' => $applicationDeadline ?: null,
                            'is_featured' => $isFeatured,
                            'description' => $description,
                        ]);

                        $count++;
                    }

                    fclose($handle);
                    Storage::disk('local')->delete($data['attachment']);

                    Notification::make()
                        ->title("Imported {$count} programs successfully")
                        ->success()
                        ->send();
                }),
        ];
    }
}
