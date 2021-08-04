<?php declare(strict_types=1);

namespace App\Domains\App\Service\Type\Format;

use App\Domains\App\Service\Type\TypeAbstract;

class Phone extends TypeAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'phone';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('app-type.phone');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return '/build/images/app-type-phone.png';
    }

    /**
     * @return string
     */
    public function payload(): string
    {
        return $this->encrypt([
            'number' => ($this->payload['number'] ?? ''),
            'sim' => ($this->payload['sim'] ?? ''),
            'pin' => ($this->payload['pin'] ?? ''),
            'puk' => ($this->payload['puk'] ?? ''),
            'unlock' => ($this->payload['unlock'] ?? ''),
            'notes' => ($this->payload['notes'] ?? ''),
        ]);
    }
}
