<?php declare(strict_types=1);

namespace App\Domains\App\Service\Type\Format;

use App\Domains\App\Service\Type\TypeAbstract;

class Text extends TypeAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'text';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('app-type.text');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return '/build/images/app-type-text.png';
    }

    /**
     * @return string
     */
    public function payload(): string
    {
        return $this->encrypt([
            'text' => ($this->payload['text'] ?? ''),
        ]);
    }
}
