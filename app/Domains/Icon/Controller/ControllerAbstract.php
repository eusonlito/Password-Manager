<?php declare(strict_types=1);

namespace App\Domains\Icon\Controller;

use App\Domains\Icon\Model\Icon as Model;
use App\Domains\Shared\Controller\ControllerWebAbstract;
use App\Exceptions\NotFoundException;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\Icon\Model\Icon
     */
    protected ?Model $row;

    /**
     * @param string $name
     *
     * @return void
     */
    protected function row(string $name): void
    {
        $this->row = Model::byName($name)
            ?: throw new NotFoundException(__('icon.error.not-found'));
    }
}
