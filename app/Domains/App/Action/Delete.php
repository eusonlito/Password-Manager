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
        $this->delete();
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
    protected function delete(): void
    {
        $this->deleteRelations();
        $this->deleteRow();
    }

    /**
     * @return void
     */
    protected function deleteRelations(): void
    {
        $this->row->files()
            ->withApp()
            ->get()
            ->each(fn ($file) => $this->factory('File', $file)->action()->delete());
    }

    /**
     * @return void
     */
    protected function deleteRow(): void
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
            'payload' => $this->row->only('id', 'name', 'created_at'),
            'app_id' => $this->row->id,
            'user_from_id' => $this->auth->id,
        ])->create();
    }
}
