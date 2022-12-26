<?php declare(strict_types=1);

namespace App\Domains\Team\Action;

use App\Domains\Team\Model\Team as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Team\Model\Team
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\Team\Model\Team
     */
    public function create(): Model
    {
        return $this->actionHandle(Create::class, $this->validate()->create());
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        $this->actionHandle(Delete::class);
    }

    /**
     * @return void
     */
    public function updateApp(): void
    {
        $this->actionHandle(UpdateApp::class, $this->validate()->updateApp());
    }

    /**
     * @return \App\Domains\Team\Model\Team
     */
    public function updateBoolean(): Model
    {
        return $this->actionHandle(UpdateBoolean::class, $this->validate()->updateBoolean());
    }

    /**
     * @return \App\Domains\Team\Model\Team
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }

    /**
     * @return void
     */
    public function updateUser(): void
    {
        $this->actionHandle(UpdateUser::class, $this->validate()->updateUser());
    }
}
