<?php declare(strict_types=1);

namespace App\Domains\App\Service\Type\Format;

use App\Domains\App\Service\Type\TypeAbstract;

class Server extends TypeAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'server';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('app-type.server');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return '/build/images/app-type-server.png';
    }

    /**
     * @return string
     */
    public function payload(): string
    {
        return $this->encrypt([
            'host' => ($this->payload['host'] ?? ''),
            'port' => ($this->payload['port'] ?? ''),
            'user' => ($this->payload['user'] ?? ''),
            'password' => ($this->payload['password'] ?? ''),
            'notes' => ($this->payload['notes'] ?? ''),
        ]);
    }
}
