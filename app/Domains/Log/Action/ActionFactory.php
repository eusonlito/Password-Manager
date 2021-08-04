<?php declare(strict_types=1);

namespace App\Domains\Log\Action;

use App\Domains\Log\Model\Log as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Log\Model\Log
     */
    protected ?Model $row;

    /**
     * @return void
     */
    public function create(): void
    {
        $this->actionHandle(Create::class, $this->validate()->create());
    }
}
