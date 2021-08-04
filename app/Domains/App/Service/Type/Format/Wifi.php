<?php declare(strict_types=1);

namespace App\Domains\App\Service\Type\Format;

use App\Domains\App\Service\Type\TypeAbstract;

class Wifi extends TypeAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'wifi';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('app-type.wifi');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return '/build/images/app-type-wifi.png';
    }

    /**
     * @return string
     */
    public function payload(): string
    {
        return $this->encrypt([
            'name' => ($this->payload['name'] ?? ''),
            'password' => ($this->payload['password'] ?? ''),
            'notes' => ($this->payload['notes'] ?? ''),
        ]);
    }
}
