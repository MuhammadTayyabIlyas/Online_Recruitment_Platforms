<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class UserRegistrationChart extends ChartWidget
{
    protected static ?string $heading = 'User Registrations';

    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = '60s';

    protected int | string | array $columnSpan = 'full';

    public ?string $filter = '30';

    protected function getFilters(): ?array
    {
        return [
            '7' => 'Last 7 days',
            '30' => 'Last 30 days',
            '90' => 'Last 90 days',
            '365' => 'Last year',
        ];
    }

    protected function getData(): array
    {
        $days = (int) $this->filter;

        $data = User::selectRaw('DATE(created_at) as date, user_type, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date', 'user_type')
            ->orderBy('date')
            ->get();

        $dates = collect();
        for ($i = $days - 1; $i >= 0; $i--) {
            $dates->push(now()->subDays($i)->format('Y-m-d'));
        }

        $jobSeekerData = [];
        $employerData = [];
        $adminData = [];
        $labels = [];

        foreach ($dates as $date) {
            $labels[] = \Carbon\Carbon::parse($date)->format('M d');

            $jobSeekerData[] = $data->where('date', $date)
                ->where('user_type', 'job_seeker')
                ->first()?->count ?? 0;

            $employerData[] = $data->where('date', $date)
                ->where('user_type', 'employer')
                ->first()?->count ?? 0;

            $adminData[] = $data->where('date', $date)
                ->where('user_type', 'admin')
                ->first()?->count ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Job Seekers',
                    'data' => $jobSeekerData,
                    'borderColor' => '#10B981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                ],
                [
                    'label' => 'Employers',
                    'data' => $employerData,
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
                [
                    'label' => 'Admins',
                    'data' => $adminData,
                    'borderColor' => '#8B5CF6',
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
