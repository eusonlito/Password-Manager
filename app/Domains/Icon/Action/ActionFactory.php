<?php declare(strict_types=1);

namespace App\Domains\Icon\Action;

use App\Domains\Icon\Model\Icon as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Icon\Model\Icon
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\Icon\Model\Icon
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
     * @return \App\Domains\Icon\Model\Icon
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }
}
