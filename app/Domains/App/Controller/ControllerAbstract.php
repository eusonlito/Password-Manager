<?php declare(strict_types=1);

namespace App\Domains\App\Controller;

use Exception;
use Illuminate\Support\Collection;
use App\Domains\App\Model\App as Model;
use App\Domains\Shared\Controller\ControllerWebAbstract;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnexpectedValueException;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\App\Model\App
     */
    protected ?Model $row;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $list;

    /**
     * @param int $id
     *
     * @return void
     */
    protected function row(int $id): void
    {
        $this->row = Model::byId($id)->byUserAllowed($this->auth)->firstOr(static function () {
            throw new NotFoundException(__('app.error.not-found'));
        });

        try {
            $this->row->payload();
        } catch (Exception $e) {
            throw new UnexpectedValueException(__('app.error.decrypt'));
        }
    }

    /**
     * @return void
     */
    protected function list(): void
    {
        $this->list = Model::byUserAllowed($this->auth)
            ->filter($this->request->input())
            ->list()
            ->get();

        if ($this->list->isEmpty()) {
            return;
        }

        try {
            $this->list->first()->payload();
        } catch (Exception $e) {
            throw new UnexpectedValueException(__('app.error.decrypt'));
        }
    }
}
