<?php

namespace App\Console\Commands;

use App\Notifications\DailyReportNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\Timezone;
use App\Models\User;
use Carbon\Carbon;

class SendDailyEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily emails to users at 5 PM in their local timezone';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $utcNow = Carbon::now('UTC');
        // $this->info('Current UTC time: ' . $utcNow->toDateTimeString());
        $utcHour = $utcNow->hour;
        $utcMinute = $utcNow->minute;

        $matchingTimezones = Timezone::whereRaw("
            ((? + offset_hours + FLOOR(offset_minutes / 60)) % 24) = 17
            AND ((? + offset_minutes) % 60) = 0
        ", [$utcHour, $utcMinute])->get();

        if ($matchingTimezones->isEmpty()) {
            $this->info('No matching timezones found for 5:00 PM.');
            return;
        }

        $this->info('Timezones where it is currently 5:00 PM:');
        foreach ($matchingTimezones as $tz) {
            $this->line(" - {$tz->name} (UTC {$tz->offset_hours}:{$tz->offset_minutes})");
        }
        $tzIds = $matchingTimezones->pluck('id')->toArray();
        $users = User::whereIn('timezone_id', $tzIds)->get();

        foreach ($users as $user) {
            $this->info('Sending email to: ' . $user->email);
            $code = Str::random(10);
            $user->notify(new DailyReportNotification($code));
        }
    }
}
