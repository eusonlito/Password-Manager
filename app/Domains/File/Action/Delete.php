<?php declare(strict_types=1);

namespace App\Domains\File\Action;

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
        if ($this->row->app->canDelete($this->auth) === false) {
            throw new NotAllowedException(__('file-delete.error.not-allowed'));
        }
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        $this->deleteRow();
        $this->deleteFile();
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
    protected function deleteFile(): void
    {
        $this->row->fileDelete();
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'file',
            'action' => 'delete',
            'payload' => $this->row->only('id', 'name', 'created_at'),
            'app_id' => $this->row->app->id,
            'file_id' => $this->row->id,
            'user_from_id' => $this->auth->id,
        ])->create();
    }
}
