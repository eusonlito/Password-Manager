<?php declare(strict_types=1);

namespace App\Domains\Icon\Action;

use App\Exceptions\ValidatorException;

class Delete extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->check();
        $this->delete();
        $this->log();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkApps();
    }

    /**
     * @return void
     */
    protected function checkApps(): void
    {
        if ($this->row->appsCount()) {
            throw new ValidatorException(__('icon-delete.error.apps'));
        }
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        $this->row->delete();
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'icon',
            'action' => 'delete',
            'payload' => $this->row->only('name'),
            'user_from_id' => $this->auth->id,
        ])->create();
    }
}
