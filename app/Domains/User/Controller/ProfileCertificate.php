<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\RedirectResponse;

class ProfileCertificate extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(): RedirectResponse
    {
        $this->rowAuth();
        $this->actionCall('profileCertificate');

        return redirect()->route('user.profile');
    }

    /**
     * @return void
     */
    protected function profileCertificate(): void
    {
        $this->action()->profileCertificate();
        $this->sessionMessage('success', __('user-profile.certificate-success'));
    }
}
