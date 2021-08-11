<?php declare(strict_types=1);

namespace App\Domains\App\Action;

use App\Exceptions\NotAllowedException;

class Delete extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->check();
        $this->save();
        $this->log();
    }

    protected function check(): void
    {
        if ($this->row->canDelete($this->auth) === false) {
            throw new NotAllowedException(__('app-delete.error.not-allowed'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->delete();
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'app',
            'action' => 'delete',
            'payload' => $this->row->toArray(),
            'app_id' => $this->row->id,
            'user_from_id' => $this->auth->id,
        ])->create();
    }
}
