<?php declare(strict_types=1);

namespace App\Domains\Tag\Action;

use App\Domains\Tag\Model\Tag as Model;
use App\Domains\Shared\Action\ActionAbstract as ActionAbstractShared;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\Tag\Model\Tag
     */
    protected ?Model $row;
}
