<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Domains\User\Model\User as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\User\Model\User
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\User\Model\User
     */
    public function authApi(): Model
    {
        return $this->actionHandle(AuthApi::class, $this->validate()->authApi());
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function authCertificate(): Model
    {
        return $this->actionHandle(AuthCertificate::class);
    }

    /**
     * @return bool
     */
    public function authCountry(): bool
    {
        return $this->actionHandle(AuthCountry::class);
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function authCredentials(): Model
    {
        return $this->actionHandle(AuthCredentials::class, $this->validate()->authCredentials());
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function authModel(): Model
    {
        return $this->actionHandle(AuthModel::class);
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function authTFA(): Model
    {
        return $this->actionHandle(AuthTFA::class, $this->validate()->authTFA());
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function create(): Model
    {
        return $this->actionHandleTransaction(Create::class, $this->validate()->create());
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $this->actionHandle(Logout::class);
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function profile(): Model
    {
        return $this->actionHandle(Profile::class, $this->validate()->profile());
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function profileCertificate(): Model
    {
        return $this->actionHandle(ProfileCertificate::class);
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function profileTFA(): Model
    {
        return $this->actionHandle(ProfileTFA::class, $this->validate()->profileTFA());
    }

    /**
     * @return bool
     */
    public function sessionTFA(): bool
    {
        return $this->actionHandle(SessionTFA::class);
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function updateBoolean(): Model
    {
        return $this->actionHandle(UpdateBoolean::class, $this->validate()->updateBoolean());
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function updateSimple(): Model
    {
        return $this->actionHandle(UpdateSimple::class, $this->validate()->updateSimple());
    }

    /**
     * @return void
     */
    public function updateTeam(): void
    {
        $this->actionHandle(UpdateTeam::class, $this->validate()->updateTeam());
    }
}
