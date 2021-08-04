<?php declare(strict_types=1);

namespace App\Domains\Tag\Validate;

use App\Domains\Shared\Validate\ValidateFactoryAbstract;

class ValidateFactory extends ValidateFactoryAbstract
{
    /**
     * @return array
     */
    public function getOrCreate(): array
    {
        return $this->handle(GetOrCreate::class);
    }
}
