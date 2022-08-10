<?php declare(strict_types=1);

namespace App\Domains\App\Service\Type\Format;

use App\Domains\App\Service\Type\TypeAbstract;

class Email extends TypeAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'email';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('app-type.email');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return '/build/images/app-type-email.png';
    }

    /**
     * @return string
     */
    public function payload(): string
    {
        return $this->encrypt([
            'username' => ($this->payload['username'] ?? ''),
            'password' => ($this->payload['password'] ?? ''),
            'notes' => ($this->payload['notes'] ?? ''),
        ]);
    }
}
