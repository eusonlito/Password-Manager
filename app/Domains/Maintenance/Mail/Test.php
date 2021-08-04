<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Mail;

use App\Domains\Shared\Mail\MailAbstract;

class Test extends MailAbstract
{
    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public $view = 'mail.layout';

    /**
     * @param string $email
     *
     * @return self
     */
    public function __construct(string $email)
    {
        $this->to($email);

        $this->subject = 'Email Test';
        $this->email = $email;
    }
}
