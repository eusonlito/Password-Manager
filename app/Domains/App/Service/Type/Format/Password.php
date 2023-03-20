<?php declare(strict_types=1);

namespace App\Domains\App\Service\Type\Format;

use App\Domains\App\Service\Type\TypeAbstract;

class Password extends TypeAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'password';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('app-type.password');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return '/build/images/app-type-password.png';
    }

    /**
     * @return string
     */
    public function payload(): string
    {
        return $this->encrypt([
            'password' => ($this->payload['password'] ?? ''),
            'notes' => ($this->payload['notes'] ?? ''),
        ]);
    }
}
