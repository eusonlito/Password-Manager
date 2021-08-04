<?php declare(strict_types=1);

namespace App\Domains\Log\Validate;

use App\Domains\Shared\Validate\ValidateFactoryAbstract;

class ValidateFactory extends ValidateFactoryAbstract
{
    /**
     * @return array
     */
    public function create(): array
    {
        return $this->handle(Create::class);
    }
}
