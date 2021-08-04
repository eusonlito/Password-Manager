<?php declare(strict_types=1);

namespace App\Domains\Shared\Validate;

abstract class ValidateFactoryAbstract
{
    /**
     * @var array
     */
    protected array $data;

    /**
     * @param array $data
     *
     * @return self
     */
    final public function __construct(array $data)
    {
        $this->data = $data;
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
