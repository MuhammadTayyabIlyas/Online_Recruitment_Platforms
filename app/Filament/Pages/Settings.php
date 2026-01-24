<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Actions\Action;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-vertical';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'General Settings';

    protected static string $view = 'filament.pages.settings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General Application Settings')
                    ->description('Manage global application settings here.')
                    ->schema([
                        Placeholder::make('instructions')
                            ->content('This is a placeholder for general settings. You can add various form fields here to manage application-wide configurations.'),
                    ]),
            ]);
    }

    public function submitSettings(): void
    {
        // Logic to save settings would go here.
        // For now, it's just a placeholder.
        
        \Filament\Notifications\Notification::make()
            ->title('Settings saved successfully!')
            ->success()
            ->send();
    }

    public function clearCache(): void
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('optimize:clear');
            \Filament\Notifications\Notification::make()
                ->title('Cache cleared successfully')
                ->success()
                ->send();
        } catch (\Exception $e) {
            \Filament\Notifications\Notification::make()
                ->title('Failed to clear cache')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }

    public function optimizeApp(): void
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('optimize');
            \Filament\Notifications\Notification::make()
                ->title('Application optimized successfully')
                ->success()
                ->send();
        } catch (\Exception $e) {
            \Filament\Notifications\Notification::make()
                ->title('Failed to optimize application')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Changes')
                ->submit('submitSettings'),
        ];
    }
}
