<?php declare(strict_types=1);

namespace App\Services\Mail;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;

class Logger
{
    /**
     * @return void
     */
    public static function listen(): void
    {
        if (config('logging.channels.mail.enabled') !== true) {
            return;
        }

        Event::listen(MessageSending::class, static fn ($event) => static::store($event));
    }

    /**
     * @param \Illuminate\Mail\Events\MessageSending $event
     *
     * @return void
     */
    protected static function store(MessageSending $event): void
    {
        $file = storage_path('logs/mails/'.date('Y-m-d/H-i-s').'-'.uniqid().'.log');
        $dir = dirname($file);

        clearstatcache(true, $dir);

        if (is_dir($dir) === false) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($file, (string)$event->message);
    }
}
