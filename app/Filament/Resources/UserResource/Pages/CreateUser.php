<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $user = static::getModel()::create($data);

        // Assign role based on user_type if no roles were selected
        if (empty($data['roles'])) {
            $user->assignRole($data['user_type']);
        }

        return $user;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'User created successfully';
    }
}
