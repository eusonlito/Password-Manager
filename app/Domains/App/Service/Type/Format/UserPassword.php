<?php declare(strict_types=1);

namespace App\Domains\App\Service\Type\Format;

use App\Domains\App\Service\Type\TypeAbstract;

class UserPassword extends TypeAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'user-password';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('app-type.user-password');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return '/build/images/app-type-user-password.png';
    }

    /**
     * @return string
     */
    public function payload(): string
    {
        return $this->encrypt([
            'user' => ($this->payload['user'] ?? ''),
            'password' => ($this->payload['password'] ?? ''),
            'notes' => ($this->payload['notes'] ?? ''),
        ]);
    }
}
