<?php

namespace App\Console\Commands;

use App\Models\Job;
use App\Models\JobAlert;
use App\Notifications\JobAlertNotification;
use Illuminate\Console\Command;

class SendJobAlerts extends Command
{
    protected $signature = 'job-alerts:send {--frequency=daily}';
    protected $description = 'Send job alerts to users';

    public function handle(): int
    {
        $frequency = $this->option('frequency');
        $alerts = JobAlert::active()->where('frequency', $frequency)->with('user')->get();

        $this->info("Processing {$alerts->count()} alerts...");

        foreach ($alerts as $alert) {
            $jobs = $this->findMatchingJobs($alert);

            if ($jobs->isNotEmpty()) {
                $alert->user->notify(new JobAlertNotification($alert, $jobs));
                $alert->update(['last_sent_at' => now()]);
                $this->line("Sent alert to {$alert->user->email}: {$jobs->count()} jobs");
            }
        }

        $this->info('Job alerts sent successfully.');
        return 0;
    }

    protected function findMatchingJobs(JobAlert $alert)
    {
        $query = Job::active()->where('created_at', '>', $alert->last_sent_at ?? now()->subDay());

        if ($alert->keywords) {
            $query->where(fn($q) => $q->where('title', 'like', "%{$alert->keywords}%")
                ->orWhere('description', 'like', "%{$alert->keywords}%"));
        }

        if ($alert->category_id) $query->where('category_id', $alert->category_id);
        if ($alert->location) $query->where(fn($q) => $q->where('city', 'like', "%{$alert->location}%")
            ->orWhere('country', 'like', "%{$alert->location}%"));
        if ($alert->job_type_id) $query->where('job_type_id', $alert->job_type_id);
        if ($alert->employment_type_id) $query->where('employment_type_id', $alert->employment_type_id);
        if ($alert->min_salary) $query->where('max_salary', '>=', $alert->min_salary);

        return $query->limit(10)->get();
    }
}
