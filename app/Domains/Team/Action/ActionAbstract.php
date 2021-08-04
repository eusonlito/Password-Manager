<?php declare(strict_types=1);

namespace App\Domains\Team\Action;

use App\Domains\Shared\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\Team\Model\Team as Model;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\Team\Model\Team
     */
    protected ?Model $row;
}
