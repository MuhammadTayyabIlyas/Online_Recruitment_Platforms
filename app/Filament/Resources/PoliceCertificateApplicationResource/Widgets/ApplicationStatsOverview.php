<?php

namespace App\Filament\Resources\PoliceCertificateApplicationResource\Widgets;

use App\Models\PoliceCertificateApplication;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ApplicationStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalApplications = PoliceCertificateApplication::count();
        $pendingReview = PoliceCertificateApplication::where('status', 'submitted')->count();
        $paymentPending = PoliceCertificateApplication::where('status', 'payment_pending')->count();
        $processing = PoliceCertificateApplication::where('status', 'processing')->count();
        $completed = PoliceCertificateApplication::where('status', 'completed')->count();

        $thisMonthTotal = PoliceCertificateApplication::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonthTotal = PoliceCertificateApplication::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $percentChange = $lastMonthTotal > 0
            ? round((($thisMonthTotal - $lastMonthTotal) / $lastMonthTotal) * 100)
            : ($thisMonthTotal > 0 ? 100 : 0);

        return [
            Stat::make('Total Applications', $totalApplications)
                ->description($thisMonthTotal . ' this month')
                ->descriptionIcon($percentChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($percentChange >= 0 ? 'success' : 'danger')
                ->chart([7, 3, 4, 5, 6, 3, 5, 8]),

            Stat::make('Pending Review', $pendingReview)
                ->description('Awaiting initial review')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Payment Pending', $paymentPending)
                ->description('Receipt uploaded, needs verification')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('info'),

            Stat::make('In Processing', $processing)
                ->description('Being processed')
                ->descriptionIcon('heroicon-m-cog-6-tooth')
                ->color('primary'),

            Stat::make('Completed', $completed)
                ->description(round(($completed / max($totalApplications, 1)) * 100) . '% completion rate')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}
