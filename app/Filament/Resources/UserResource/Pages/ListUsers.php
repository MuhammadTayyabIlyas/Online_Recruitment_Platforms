<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Users')
                ->badge(fn () => $this->getModel()::count()),

            'admins' => Tab::make('Admins')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('user_type', 'admin'))
                ->badge(fn () => $this->getModel()::where('user_type', 'admin')->count())
                ->badgeColor('danger'),

            'employers' => Tab::make('Employers')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('user_type', 'employer'))
                ->badge(fn () => $this->getModel()::where('user_type', 'employer')->count())
                ->badgeColor('primary'),

            'job_seekers' => Tab::make('Job Seekers')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('user_type', 'job_seeker'))
                ->badge(fn () => $this->getModel()::where('user_type', 'job_seeker')->count())
                ->badgeColor('success'),

            'active' => Tab::make('Active')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true))
                ->badge(fn () => $this->getModel()::where('is_active', true)->count())
                ->badgeColor('success'),

            'inactive' => Tab::make('Inactive')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', false))
                ->badge(fn () => $this->getModel()::where('is_active', false)->count())
                ->badgeColor('danger'),
        ];
    }
}
