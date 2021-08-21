<?php declare(strict_types=1);

namespace App\Domains\Shared\Mail;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

abstract class MailFactoryAbstract
{
    /**
     * @param ?\Illuminate\Contracts\Auth\Authenticatable $auth = null
     *
     * @return self
     */
    public final function __construct(protected ?\Illuminate\Contracts\Auth\Authenticatable $auth = null)
    {
    }

    /**
     * @param \Illuminate\Mail\Mailable $mail
     *
     * @return void
     */
    final public function queue(Mailable $mail): void
    {
        Mail::queue($mail);
    }

    /**
     * @param \Illuminate\Mail\Mailable $mail
     *
     * @return void
     */
    final public function send(Mailable $mail): void
    {
        Mail::send($mail);
    }
}
