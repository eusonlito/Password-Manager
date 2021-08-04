<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class AuthCertificate extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        if ($response = $this->actionPost('authCertificate')) {
            return $response;
        }

        return redirect()->route('user.auth.credentials');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authCertificate(): RedirectResponse
    {
        $this->action()->authCertificate();

        return redirect()->route('dashboard.index');
    }
}
