<?php declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as KernelVendor;
use App\Domains\Maintenance\Schedule\Manager as MaintenanceScheduleManager;
use App\Services\Filesystem\Directory;

class Kernel extends KernelVendor
{
    /**
     * @return void
     */
    protected function commands()
    {
        foreach (glob(app_path('Domains/*/Command')) as $dir) {
            $this->load($dir);
        }
    }

    /**
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $this->scheduleQueue($schedule);
        $this->scheduleCachePrune($schedule);

        (new MaintenanceScheduleManager($schedule))->handle();
    }

    /**
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function scheduleQueue(Schedule $schedule): void
    {
        $schedule->command('queue:work', ['--tries' => 3, '--stop-when-empty'])
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo($this->scheduleQueueLog())
            ->everyMinute();
    }

    /**
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function scheduleCachePrune(Schedule $schedule): void
    {
        $schedule->command('cache:prune-stale-tags')->hourly();
    }

    /**
     * @return string
     */
    protected function scheduleQueueLog(): string
    {
        $file = storage_path(sprintf('logs/artisan/%s-%s-queue-work.log', date('Y-m-d/H-i-s'), uniqid()));

        Directory::create($file, true);

        return $file;
    }
}
