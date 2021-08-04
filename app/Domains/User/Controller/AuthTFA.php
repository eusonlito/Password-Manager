<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class AuthTFA extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        $this->rowAuth();

        if (empty($this->row->tfa_enabled)) {
            return redirect()->route('dashboard.index');
        }

        if ($response = $this->actionPost('authTFA')) {
            return $response;
        }

        $this->meta('title', __('user-auth-tfa.meta-title'));

        return $this->page('user.auth-tfa');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authTFA(): RedirectResponse
    {
        $this->action()->authTFA();

        return redirect()->route('dashboard.index');
    }
}
