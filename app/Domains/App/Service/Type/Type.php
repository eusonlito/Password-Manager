<?php declare(strict_types=1);

namespace App\Domains\App\Service\Type;

use App\Exceptions\UnexpectedValueException;

class Type
{
    /**
     * @const
     */
    protected const FORMATS = ['card', 'email', 'idrive', 'phone', 'ssh', 'server', 'text', 'website', 'wifi'];

    /**
     * @return array
     */
    public function titles(): array
    {
        return [
            'card' => __('app-type.card'),
            'email' => __('app-type.email'),
            'idrive' => __('app-type.idrive'),
            'phone' => __('app-type.phone'),
            'ssh' => __('app-type.ssh'),
            'server' => __('app-type.server'),
            'text' => __('app-type.text'),
            'website' => __('app-type.website'),
            'wifi' => __('app-type.wifi'),
        ];
    }

    /**
     * @param ?string $code
     *
     * @return ?string
     */
    public function selected(?string $code): ?string
    {
        return in_array($code, static::FORMATS) ? $code : null;
    }

    /**
     * @param string $code
     * @param array $payload
     *
     * @return \App\Domains\App\Service\Type\TypeAbstract
     */
    public function factory(string $code, array $payload): TypeAbstract
    {
        return $this->new($this->class($code), $payload);
    }

    /**
     * @param string $code
     *
     * @return string
     */
    protected function class(string $code): string
    {
        return match ($code) {
            'card' => $this->classFormat('Card'),
            'email' => $this->classFormat('Email'),
            'idrive' => $this->classFormat('Idrive'),
            'phone' => $this->classFormat('Phone'),
            'ssh' => $this->classFormat('SSH'),
            'server' => $this->classFormat('Server'),
            'text' => $this->classFormat('Text'),
            'website' => $this->classFormat('Website'),
            'wifi' => $this->classFormat('Wifi'),
            default => throw new UnexpectedValueException(__('app-type.error.invalid')),
        };
    }

    /**
     * @param string $class
     *
     * @return string
     */
    protected function classFormat(string $class): string
    {
        return __NAMESPACE__.'\\Format\\'.$class;
    }

    /**
     * @param string $class
     * @param array $payload
     *
     * @return \App\Domains\App\Service\Type\TypeAbstract
     */
    protected function new(string $class, array $payload): TypeAbstract
    {
        return new $class($payload);
    }
}
