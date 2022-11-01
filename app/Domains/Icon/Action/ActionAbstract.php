<?php declare(strict_types=1);

namespace App\Domains\Icon\Action;

use App\Domains\Icon\Model\Icon as Model;
use App\Domains\Shared\Action\ActionAbstract as ActionAbstractShared;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\Icon\Model\Icon
     */
    protected ?Model $row;
}
