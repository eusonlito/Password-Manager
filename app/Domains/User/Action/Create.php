<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Hash;
use App\Domains\Team\Model\Team as TeamModel;
use App\Domains\User\Model\User as Model;
use App\Domains\User\Service\TFA\TFA;
use App\Exceptions\ValidatorException;

class Create extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->data();
        $this->check();
        $this->save();
        $this->teams();

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
        $this->data['password_enabled'] ??= 1;
        $this->data['tfa_secret'] = TFA::generateSecretKey();
        $this->data['tfa_enabled'] = 0;
        $this->data['readonly'] ??= 0;
        $this->data['admin'] ??= 0;
        $this->data['enabled'] ??= 1;
        $this->data['teams'] = array_filter($this->data['teams']);

        if ($this->data['password']) {
            $this->data['password'] = Hash::make($this->data['password']);
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
        if (Model::byEmail($this->data['email'])->count()) {
            throw new ValidatorException(__('user-create.error.email-exists'));
        }
    }

    /**
     * @return void
     */
    protected function checkCertificate(): void
    {
        if ($this->data['certificate'] && Model::byCertificate($this->data['certificate'])->count()) {
            throw new ValidatorException(__('user-create.error.certificate-exists'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::create([
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'certificate' => $this->data['certificate'],
            'password' => $this->data['password'],
            'password_enabled' => $this->data['password_enabled'],
            'tfa_secret' => $this->data['tfa_secret'],
            'tfa_enabled' => $this->data['tfa_enabled'],
            'admin' => $this->data['admin'],
            'readonly' => $this->data['readonly'],
            'enabled' => $this->data['enabled'],
        ]);
    }

    /**
     * @return void
     */
    protected function teams(): void
    {
        if ($this->data['teams']) {
            $q = TeamModel::byIds($this->data['teams']);
        } else {
            $q = TeamModel::whereDefault();
        }

        $this->row->teams()->sync($q->pluck('id')->toArray());
    }
}
