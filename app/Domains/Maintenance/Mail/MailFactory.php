<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Mail;

use App\Domains\Shared\Mail\MailFactoryAbstract;

class MailFactory extends MailFactoryAbstract
{
    /**
     * @param string $email
     *
     * @return void
     */
    public function testQueue(string $email): void
    {
        $this->queue(new Test($email));
    }

    /**
     * @param string $email
     *
     * @return void
     */
    public function testSend(string $email): void
    {
        $this->send(new Test($email));
    }
}
