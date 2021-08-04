<?php declare(strict_types=1);

namespace App\Domains\Team\Validate;

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
    public function updateApp(): array
    {
        return $this->handle(UpdateApp::class);
    }

    /**
     * @return array
     */
    public function updateBoolean(): array
    {
        return $this->handle(UpdateBoolean::class);
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
    public function updateUser(): array
    {
        return $this->handle(UpdateUser::class);
    }
}
