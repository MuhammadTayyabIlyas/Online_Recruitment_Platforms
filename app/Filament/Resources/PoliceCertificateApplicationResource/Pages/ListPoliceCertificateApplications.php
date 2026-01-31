<?php

namespace App\Filament\Resources\PoliceCertificateApplicationResource\Pages;

use App\Filament\Resources\PoliceCertificateApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPoliceCertificateApplications extends ListRecords
{
    protected static string $resource = PoliceCertificateApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Export')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PoliceCertificateApplicationResource\Widgets\ApplicationStatsOverview::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Applications')
                ->badge(fn () => $this->getModel()::count()),

            'pending' => Tab::make('Pending Review')
                ->badge(fn () => $this->getModel()::where('status', 'submitted')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'submitted')),

            'payment_pending' => Tab::make('Payment Pending')
                ->badge(fn () => $this->getModel()::where('status', 'payment_pending')->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'payment_pending')),

            'verified' => Tab::make('Payment Verified')
                ->badge(fn () => $this->getModel()::where('status', 'payment_verified')->count())
                ->badgeColor('primary')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'payment_verified')),

            'processing' => Tab::make('Processing')
                ->badge(fn () => $this->getModel()::where('status', 'processing')->count())
                ->badgeColor('purple')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'processing')),

            'completed' => Tab::make('Completed')
                ->badge(fn () => $this->getModel()::where('status', 'completed')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'completed')),
        ];
    }
}
