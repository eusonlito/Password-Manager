<?php declare(strict_types=1);

namespace App\Domains\App\Validate;

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

    /**
     * @return array
     */
    public function export(): array
    {
        return $this->handle(Export::class);
    }

    /**
     * @return array
     */
    public function search(): array
    {
        return $this->handle(Search::class);
    }

    /**
     * @return array
     */
    public function searchUrl(): array
    {
        return $this->handle(SearchUrl::class);
    }

    /**
     * @return array
     */
    public function update(): array
    {
        return $this->handle(Update::class);
    }

    /**
     * @return array
     */
    public function viewKey(): array
    {
        return $this->handle(ViewKey::class);
    }
}
