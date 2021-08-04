<?php declare(strict_types=1);

namespace App\Domains\App\Service\Type\Format;

use App\Domains\App\Service\Type\TypeAbstract;

class Card extends TypeAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'card';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('app-type.card');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return '/build/images/app-type-card.png';
    }

    /**
     * @return string
     */
    public function payload(): string
    {
        return $this->encrypt([
            'holder' => ($this->payload['holder'] ?? ''),
            'number' => ($this->payload['number'] ?? ''),
            'pin' => ($this->payload['pin'] ?? ''),
            'cvc' => ($this->payload['cvc'] ?? ''),
            'expires' => ($this->payload['expires'] ?? ''),
            'notes' => ($this->payload['notes'] ?? ''),
        ]);
    }
}
