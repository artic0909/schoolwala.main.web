<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscribers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckExpiredSubscriptions extends Command
{
    protected $signature = 'subscriptions:check-expired';
    protected $description = 'Check and deactivate expired subscriptions';

    public function handle()
    {
        $this->info('Checking for expired subscriptions...');

        // Get all active subscriptions where expiry_date has passed
        // Use with() to eager load student relationship
        $expiredSubscriptions = Subscribers::with('student')
            ->where('status', 'active')
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<', Carbon::today())
            ->get();

        if ($expiredSubscriptions->isEmpty()) {
            $this->info('No expired subscriptions found.');
            return 0;
        }

        $count = 0;
        foreach ($expiredSubscriptions as $subscription) {
            $subscription->update(['status' => 'inactive']);
            $count++;

            // Safe way to get student name
            $studentName = $subscription->student ? $subscription->student->name : 'N/A';
            $this->line("Deactivated subscription ID: {$subscription->id} - Student: {$studentName}");
        }

        $this->info("Total {$count} subscriptions have been deactivated.");

        // Log the activity
        Log::info("Expired Subscriptions Check: {$count} subscriptions deactivated at " . now());

        return 0;
    }
}
