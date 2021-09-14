<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Auth;
use App\Exceptions\AuthenticationException;
use App\Domains\User\Model\User as Model;
use App\Domains\User\Service\Certificate\Check as CertificateCheck;

class AuthCertificate extends ActionAbstract
{
    /**
     * @var ?string
     */
    protected ?string $certificate;

    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->checkIp();
        $this->certificate();
        $this->row();
        $this->login();
        $this->auth();
        $this->success();
        $this->session();

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
    protected function certificate(): void
    {
        $this->certificate = CertificateCheck::fromServer($this->request->server());

        if (empty($this->certificate)) {
            $this->fail();
        }
    }

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = Model::byCertificate($this->certificate)->enabled()->firstOr(fn () => $this->fail());
    }

    /**
     * @throws \App\Exceptions\AuthenticationException
     *
     * @return void
     */
    protected function fail(): void
    {
        $this->factory('UserSession')->action(['auth' => $this->certificate])->fail();

        throw new AuthenticationException(__('user-auth-certificate.error.auth-fail'));
    }

    /**
     * @return void
     */
    protected function login(): void
    {
        Auth::login($this->row, true);
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
        $this->factory('UserSession')->action(['auth' => $this->certificate])->success($this->row);
    }

    /**
     * @return void
     */
    protected function session(): void
    {
        $this->request->session()->forget('tfa:id');
    }
}
