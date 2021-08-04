<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Hash;
use App\Domains\User\Model\User as Model;
use App\Exceptions\ValidatorException;

class Profile extends ActionAbstract
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
        $this->data['api_key'] = $this->data['api_key'] ?: null;
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkEmail();
        $this->checkPassword();
        $this->checkCertificate();
        $this->checkApiKey();
    }

    /**
     * @return void
     */
    protected function checkEmail(): void
    {
        if (Model::byIdNot($this->row->id)->byEmail($this->data['email'])->count()) {
            throw new ValidatorException(__('user-profile.error.email-exists'));
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
            throw new ValidatorException(__('user-profile.error.certificate-password-empty'));
        }
    }

    /**
     * @return void
     */
    protected function checkCertificate(): void
    {
        if ($this->data['certificate'] && Model::byIdNot($this->row->id)->byCertificate($this->data['certificate'])->count()) {
            throw new ValidatorException(__('user-profile.error.certificate-exists'));
        }
    }

    /**
     * @return void
     */
    protected function checkApiKey(): void
    {
        if ($this->data['api_key'] && Model::byIdNot($this->row->id)->byApiKey($this->data['api_key'])->count()) {
            throw new ValidatorException(__('user-profile.error.api_key-exists'));
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
        $this->row->api_key = $this->data['api_key'];

        if ($this->data['password']) {
            $this->row->password = Hash::make($this->data['password']);
        }

        if (config('auth.tfa.enabled')) {
            $this->row->tfa_enabled = $this->data['tfa_enabled'];
        }

        $this->row->save();
    }
}
