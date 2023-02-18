<?php declare(strict_types=1);

namespace App\Domains\App\Action;

use App\Exceptions\NotAllowedException;

class Update extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function check(): void
    {
        if ($this->row->canEdit($this->auth) === false) {
            throw new NotAllowedException(__('app-update.error.not-allowed'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->type = $this->data['type'];
        $this->row->name = $this->data['name'];
        $this->row->payload = $this->data['payload'];
        $this->row->updated_at = date('Y-m-d H:i:s');

        $this->saveOwner();

        $this->row->save();
    }

    /**
     * @return void
     */
    protected function saveOwner(): void
    {
        if ($this->row->user_id !== $this->auth->id) {
            return;
        }

        $this->row->shared = $this->data['shared'];
        $this->row->editable = $this->data['editable'];
        $this->row->archived = $this->data['archived'];
    }
}
