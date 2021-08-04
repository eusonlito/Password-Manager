<?php declare(strict_types=1);

namespace App\Domains\Error\Action;

use Throwable;
use Illuminate\Support\Facades\Log;

class Exception extends ActionAbstract
{
    /**
     * @var \Throwable
     */
    protected Throwable $e;

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    public function handle(Throwable $e): void
    {
        $this->e = $e;

        $this->log();
        $this->sentry();
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        Log::error($this->e);
    }

    /**
     * @return void
     */
    protected function sentry(): void
    {
        if (app()->bound('sentry')) {
            app('sentry')->captureException($this->e);
        }
    }
}
