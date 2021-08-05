<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Auth;
use App\Exceptions\AuthenticationException;
use App\Domains\User\Model\User as Model;

class AuthApi extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->checkIp();
        $this->row();
        $this->login();
        $this->auth();
        $this->success();

        return $this->row;
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
    protected function row(): void
    {
        $this->row = Model::byApiKey($this->data['api_key'])->enabled()->firstOr(fn () => $this->fail());
    }

    /**
     * @throws \App\Exceptions\AuthenticationException
     *
     * @return void
     */
    protected function fail(): void
    {
        $this->factory('UserSession')->action(['auth' => $this->data['api_key']])->fail();

        throw new AuthenticationException(__('user-auth-api.error.auth-fail'));
    }

    /**
     * @return void
     */
    protected function login(): void
    {
        Auth::login($this->row);
    }

    /**
     * @return void
     */
    protected function auth(): void
    {
        $this->row = $this->auth = Auth::user();
    }

    /**
     * @return void
     */
    protected function success(): void
    {
        $this->factory('UserSession')->action()->success($this->row);
    }
}
