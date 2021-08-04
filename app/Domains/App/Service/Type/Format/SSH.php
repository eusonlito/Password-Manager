<?php declare(strict_types=1);

namespace App\Domains\App\Service\Type\Format;

use App\Domains\App\Service\Type\TypeAbstract;

class SSH extends TypeAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'ssh';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('app-type.ssh');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return '/build/images/app-type-ssh.png';
    }

    /**
     * @return string
     */
    public function payload(): string
    {
        return $this->encrypt([
            'password' => ($this->payload['password'] ?? ''),
            'public' => ($this->payload['public'] ?? ''),
            'private' => ($this->payload['private'] ?? ''),
            'notes' => ($this->payload['notes'] ?? ''),
        ]);
    }
}
