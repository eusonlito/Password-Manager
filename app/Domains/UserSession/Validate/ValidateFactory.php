<?php declare(strict_types=1);

namespace App\Domains\UserSession\Validate;

use App\Domains\Shared\Validate\ValidateFactoryAbstract;

class ValidateFactory extends ValidateFactoryAbstract
{
    /**
     * @return array
     */
    public function fail(): array
    {
        return $this->handle(Fail::class);
    }
}
