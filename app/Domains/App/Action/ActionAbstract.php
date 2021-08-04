<?php declare(strict_types=1);

namespace App\Domains\App\Action;

use App\Domains\App\Model\App as Model;
use App\Domains\Shared\Action\ActionAbstract as ActionAbstractShared;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\App\Model\App
     */
    protected ?Model $row;
}
