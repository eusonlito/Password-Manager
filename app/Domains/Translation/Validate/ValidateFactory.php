<?php declare(strict_types=1);

namespace App\Domains\Translation\Validate;

use App\Domains\Shared\Validate\ValidateFactoryAbstract;

class ValidateFactory extends ValidateFactoryAbstract
{
    /**
     * @return array
     */
    public function fixed(): array
    {
        return $this->handle(Fixed::class);
    }

    /**
     * @return array
     */
    public function only(): array
    {
        return $this->handle(Only::class);
    }

    /**
     * @return array
     */
    public function translate(): array
    {
        return $this->handle(Translate::class);
    }
}
