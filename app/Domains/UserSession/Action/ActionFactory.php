<?php declare(strict_types=1);

namespace App\Domains\UserSession\Action;

use App\Domains\User\Model\User as UserModel;
use App\Domains\UserSession\Model\UserSession as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\UserSession\Model\UserSession
     */
    protected ?Model $row;

    /**
     * @return void
     */
    public function fail(): void
    {
        $this->actionHandleTransaction(Fail::class, $this->validate()->fail());
    }

    /**
     * @param \App\Domains\User\Model\User $user
     *
     * @return void
     */
    public function success(UserModel $user): void
    {
        $this->actionHandleTransaction(Success::class, [], $user);
    }
}
