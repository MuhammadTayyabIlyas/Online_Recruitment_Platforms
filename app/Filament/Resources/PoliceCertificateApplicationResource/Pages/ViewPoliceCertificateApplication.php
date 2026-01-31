<?php

namespace App\Filament\Resources\PoliceCertificateApplicationResource\Pages;

use App\Filament\Resources\PoliceCertificateApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPoliceCertificateApplication extends ViewRecord
{
    protected static string $resource = PoliceCertificateApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            Actions\Action::make('verify_payment')
                ->label('Verify Payment')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => in_array($this->record->status, ['submitted', 'payment_pending']))
                ->action(function () {
                    $this->record->update([
                        'status' => 'payment_verified',
                        'payment_verified_at' => now(),
                        'payment_verified_by' => auth()->id(),
                    ]);
                    $this->refreshFormData(['status', 'payment_verified_at']);
                }),

            Actions\Action::make('start_processing')
                ->label('Start Processing')
                ->icon('heroicon-o-cog')
                ->color('primary')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status === 'payment_verified')
                ->action(function () {
                    $this->record->update(['status' => 'processing']);
                    $this->refreshFormData(['status']);
                }),

            Actions\Action::make('mark_completed')
                ->label('Mark Completed')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status === 'processing')
                ->action(function () {
                    $this->record->update(['status' => 'completed']);
                    $this->refreshFormData(['status']);
                }),

            Actions\Action::make('download_documents')
                ->label('Download Documents')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->url(fn () => route('admin.police-certificate.download-documents', $this->record))
                ->visible(fn () => $this->record->documents()->count() > 0),
        ];
    }
}
