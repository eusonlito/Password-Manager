<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Hash;
use App\Domains\Team\Model\Team as TeamModel;
use App\Domains\User\Model\User as Model;
use App\Exceptions\ValidatorException;

class UpdateSimple extends ActionAbstract
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
        if ($this->data['email']) {
            $this->data['email'] = strtolower($this->data['email']);
        }
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkEmail();
        $this->checkCertificate();
    }

    /**
     * @return void
     */
    protected function checkEmail(): void
    {
        if ($this->data['email'] && Model::byIdNot($this->row->id)->byEmail($this->data['email'])->count()) {
            throw new ValidatorException(__('user-update.error.email-exists'));
        }
    }

    /**
     * @return void
     */
    protected function checkCertificate(): void
    {
        if ($this->data['certificate'] && Model::byIdNot($this->row->id)->byCertificate($this->data['certificate'])->count()) {
            throw new ValidatorException(__('user-update.error.certificate-exists'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        if ($this->data['name']) {
            $this->row->name = $this->data['name'];
        }

        if ($this->data['email']) {
            $this->row->email = $this->data['email'];
        }

        if ($this->data['certificate']) {
            $this->row->certificate = $this->data['certificate'];
        }

        if ($this->data['password']) {
            $this->row->password = Hash::make($this->data['password']);
        }

        if ($this->data['password_enabled'] !== null) {
            $this->row->password_enabled = $this->data['password_enabled'];
        }

        if ($this->data['tfa_enabled'] !== null) {
            $this->row->tfa_enabled = $this->data['tfa_enabled'];
        }

        if ($this->data['readonly'] !== null) {
            $this->row->readonly = $this->data['readonly'];
        }

        if ($this->data['admin'] !== null) {
            $this->row->admin = $this->data['admin'];
        }

        if ($this->data['enabled'] !== null) {
            $this->row->enabled = $this->data['enabled'];
        }

        if ($this->data['teams']) {
            $this->row->teams()->sync(TeamModel::byIds($this->data['teams'])->pluck('id')->toArray());
        }

        $this->row->save();
    }
}
