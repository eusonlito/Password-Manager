<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\AuthenticationException;
use App\Domains\User\Model\User as Model;
use App\Domains\UserSession\Model\UserSession as UserSessionModel;

class AuthApi extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->checkIp();
        $this->row();
        $this->checkSecret();
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
     * @return void
     */
    protected function checkSecret(): void
    {
        if (config('auth.api.secret_enabled') === false) {
            return;
        }

        if ($this->data['api_secret']) {
            $this->checkSecretCredential();
        } else {
            $this->checkSecretUnlocked();
        }
    }

    /**
     * @return void
     */
    protected function checkSecretCredential(): void
    {
        if (Hash::check($this->data['api_secret'], $this->row->api_secret) === false) {
            $this->fail();
        }
    }

    /**
     * @return void
     */
    protected function checkSecretUnlocked(): void
    {
        UserSessionModel::byAuth($this->row->api_key)
            ->byUserId($this->row->id)
            ->byIp($this->request->ip())
            ->whereSuccess()
            ->firstOr(fn () => $this->checkSecretUnlockedFail());
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
     * @throws \App\Exceptions\AuthenticationException
     *
     * @return void
     */
    protected function checkSecretUnlockedFail(): void
    {
        $e = new AuthenticationException(__('user-auth-api.error.api-secret-required'));
        $e->setStatus('api_secret_required');

        throw $e;
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
        $this->factory('UserSession')->action(['auth' => $this->row->api_key])->success($this->row);
    }
}
