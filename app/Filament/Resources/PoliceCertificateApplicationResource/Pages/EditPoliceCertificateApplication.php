<?php

namespace App\Filament\Resources\PoliceCertificateApplicationResource\Pages;

use App\Filament\Resources\PoliceCertificateApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPoliceCertificateApplication extends EditRecord
{
    protected static string $resource = PoliceCertificateApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
