<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Domains\User\Model\User as Model;
use App\Exceptions\ValidatorException;

class UpdateBoolean extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->data();
        $this->check();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->data['value'] = !$this->row->{$this->data['column']};
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkStatus();
    }

    /**
     * @return void
     */
    protected function checkStatus(): void
    {
        if ($this->row->id !== $this->auth->id) {
            return;
        }

        if (($this->data['column'] === 'readonly') && $this->data['value']) {
            throw new ValidatorException(__('user-update-boolean.error.readonly-own'));
        }

        if (($this->data['column'] === 'admin') && empty($this->data['value'])) {
            throw new ValidatorException(__('user-update-boolean.error.admin-own'));
        }

        if (($this->data['column'] === 'enabled') && empty($this->data['value'])) {
            throw new ValidatorException(__('user-update-boolean.error.enabled-own'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->{$this->data['column']} = $this->data['value'];
        $this->row->save();
    }
}
