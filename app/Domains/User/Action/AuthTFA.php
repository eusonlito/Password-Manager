<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Exceptions\AuthenticationException;
use App\Domains\User\Model\User as Model;
use App\Domains\User\Service\TFA\TFA;

class AuthTFA extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->check();
        $this->session();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkIp();
        $this->checkCode();
    }

    /**
     * @return void
     */
    protected function checkIp(): void
    {
        $this->factory('IpLock')->action()->check();
    }

    /**
     * @return void
     */
    protected function checkCode(): void
    {
        if (TFA::verifyKey($this->row->tfa_secret, $this->data['code']) === false) {
            $this->fail();
        }
    }

    /**
     * @throws \App\Exceptions\AuthenticationException
     *
     * @return void
     */
    protected function fail(): void
    {
        $this->factory('UserSession')->action(['auth' => $this->row->email])->fail();

        throw new AuthenticationException(__('user-auth-credentials.error.auth-fail-tfa'));
    }

    /**
     * @return void
     */
    protected function session(): void
    {
        $this->request->session()->put('tfa:id', $this->row->id.'|'.$this->request->ip().'|'.time());
    }
}
