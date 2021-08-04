<?php declare(strict_types=1);

namespace App\Domains\Shared\Mail;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

abstract class MailFactoryAbstract
{
    /**
     * @var ?\Illuminate\Contracts\Auth\Authenticatable
     */
    protected ?Authenticatable $auth;

    /**
     * @param ?\Illuminate\Contracts\Auth\Authenticatable $auth = null
     *
     * @return self
     */
    final public function __construct(?Authenticatable $auth = null)
    {
        $this->auth = $auth;
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
