<?php declare(strict_types=1);

namespace App\Domains\App\Service\Type\Format;

use App\Domains\App\Service\Type\TypeAbstract;

class Idrive extends TypeAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'idrive';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('app-type.idrive');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return '/build/images/app-type-idrive.png';
    }

    /**
     * @return string
     */
    public function payload(): string
    {
        return $this->encrypt([
            'username' => ($this->payload['username'] ?? ''),
            'password' => ($this->payload['password'] ?? ''),
            'key' => ($this->payload['key'] ?? ''),
            'notes' => ($this->payload['notes'] ?? ''),
        ]);
    }
}
