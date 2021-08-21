<?php declare(strict_types=1);

namespace App\Domains\Shared\Validate;

abstract class ValidateFactoryAbstract
{
    /**
     * @param array $data
     *
     * @return self
     */
    public final function __construct(protected array $data)
    {
    }

    /**
     * @param string $class
     *
     * @return array
     */
    final protected function handle(string $class): array
    {
        return (new $class($this->data))->handle();
    }
}
