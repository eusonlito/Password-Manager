<?php declare(strict_types=1);

namespace App\Domains\Shared\Schedule;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;

abstract class ScheduleAbstract
{
    /**
     * @var \Illuminate\Console\Scheduling\Schedule
     */
    protected Schedule $schedule;

    /**
     * @return void
     */
    abstract public function handle(): void;

    /**
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    final public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * @param string $command
     * @param string $log
     * @param array $arguments = []
     *
     * @return \Illuminate\Console\Scheduling\Event
     */
    final protected function command(string $command, string $log, array $arguments = []): Event
    {
        return $this->schedule->command($command, $arguments)->runInBackground()->appendOutputTo($this->log($log));
    }

    /**
     * @param string $name
     *
     * @return string
     */
    final protected function log(string $name): string
    {
        return $this->mkdir(storage_path('logs/schedule/'.str_slug($name).'.log'));
    }

    /**
     * @param string $path
     *
     * @return string
     */
    final protected function mkdir(string $path): string
    {
        $dir = dirname($path);

        clearstatcache(true, $dir);

        if (is_dir($dir) === false) {
            mkdir($dir, 0755, true);
        }

        return $path;
    }
}
