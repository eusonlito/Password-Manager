<?php declare(strict_types=1);

namespace App\Domains\Log\Action;

use App\Domains\Log\Model\Log as Model;
use App\Domains\Shared\Action\ActionAbstract as ActionAbstractShared;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\Log\Model\Log
     */
    protected ?Model $row;
}
