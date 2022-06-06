<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Hash;
use App\Domains\User\Model\User as Model;
use App\Exceptions\ValidatorException;

class Update extends ActionAbstract
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
        $this->data['name'] = trim($this->data['name']);
        $this->data['email'] = strtolower($this->data['email']);
        $this->data['certificate'] = $this->data['certificate'] ?: null;

        if (config('auth.certificate.enabled') === false) {
            $this->data['password_enabled'] = true;
        }
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkEmail();
        $this->checkPassword();
        $this->checkCertificate();
        $this->checkStatus();
    }

    /**
     * @return void
     */
    protected function checkEmail(): void
    {
        if (Model::byIdNot($this->row->id)->byEmail($this->data['email'])->count()) {
            throw new ValidatorException(__('user-update.error.email-exists'));
        }
    }

    /**
     * @return void
     */
    protected function checkPassword(): void
    {
        if (config('auth.certificate.enabled') === false) {
            return;
        }

        if (empty($this->data['certificate']) && empty($this->data['password_enabled'])) {
            throw new ValidatorException(__('user-update.error.certificate-password-empty'));
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
    protected function checkStatus(): void
    {
        if ($this->row->id !== $this->auth->id) {
            return;
        }

        if ($this->data['readonly']) {
            throw new ValidatorException(__('user-update.error.readonly-own'));
        }

        if (empty($this->data['admin'])) {
            throw new ValidatorException(__('user-update.error.admin-own'));
        }

        if (empty($this->data['enabled'])) {
            throw new ValidatorException(__('user-update.error.enabled-own'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->email = $this->data['email'];
        $this->row->certificate = $this->data['certificate'];
        $this->row->password_enabled = $this->data['password_enabled'];
        $this->row->readonly = $this->data['readonly'];
        $this->row->admin = $this->data['admin'];
        $this->row->enabled = $this->data['enabled'];

        if ($this->data['password']) {
            $this->row->password = Hash::make($this->data['password']);
        }

        $this->row->save();
    }
}
