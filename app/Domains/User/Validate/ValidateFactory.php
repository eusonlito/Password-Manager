<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateFactoryAbstract;

class ValidateFactory extends ValidateFactoryAbstract
{
    /**
     * @return array
     */
    public function authApi(): array
    {
        return $this->handle(AuthApi::class);
    }

    /**
     * @return array
     */
    public function authCredentials(): array
    {
        return $this->handle(AuthCredentials::class);
    }

    /**
     * @return array
     */
    public function authTFA(): array
    {
        return $this->handle(AuthTFA::class);
    }

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
    public function profile(): array
    {
        return $this->handle(Profile::class);
    }

    /**
     * @return array
     */
    public function profileTFA(): array
    {
        return $this->handle(ProfileTFA::class);
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
    public function updateBoolean(): array
    {
        return $this->handle(UpdateBoolean::class);
    }

    /**
     * @return array
     */
    public function updateSimple(): array
    {
        return $this->handle(UpdateSimple::class);
    }

    /**
     * @return array
     */
    public function updateTeam(): array
    {
        return $this->handle(UpdateTeam::class);
    }
}
