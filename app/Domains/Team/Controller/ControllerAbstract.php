<?php declare(strict_types=1);

namespace App\Domains\Team\Controller;

use App\Domains\Team\Model\Team as Model;
use App\Domains\Shared\Controller\ControllerWebAbstract;
use App\Exceptions\NotFoundException;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\Team\Model\Team
     */
    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return void
     */
    protected function row(int $id): void
    {
        $this->row = Model::byId($id)->firstOr(static function () {
            throw new NotFoundException(__('team.error.not-found'));
        });
    }
}
