<?php declare(strict_types=1);

namespace App\Domains\App\ControllerApi;

use Exception;
use App\Domains\App\Model\App as Model;
use App\Domains\Shared\Controller\ControllerAbstract as ControllerAbstractShared;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnexpectedValueException;

abstract class ControllerAbstract extends ControllerAbstractShared
{
    /**
     * @var ?\App\Domains\App\Model\App
     */
    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return void
     */
    protected function row(int $id): void
    {
        $this->row = Model::byId($id)
            ->byUserAllowed($this->auth)
            ->whereArchived(false)
            ->byType('website')
            ->firstOr(static function () {
                throw new NotFoundException(__('app-api.error.not-found'));
            });

        try {
            $this->row->payload();
        } catch (Exception $e) {
            throw new UnexpectedValueException(__('app-api.error.decrypt'));
        }
    }
}
