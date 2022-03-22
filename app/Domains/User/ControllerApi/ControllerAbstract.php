<?php declare(strict_types=1);

namespace App\Domains\User\ControllerApi;

use App\Domains\Shared\Controller\ControllerAbstract as ControllerAbstractShared;
use App\Domains\User\Model\User as Model;
use App\Exceptions\NotFoundException;

abstract class ControllerAbstract extends ControllerAbstractShared
{
    /**
     * @var ?\App\Domains\User\Model\User
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
            throw new NotFoundException(__('user.error.not-found'));
        });
    }
}
