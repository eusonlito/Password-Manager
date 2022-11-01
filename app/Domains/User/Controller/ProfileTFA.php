<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\User\Service\TFA\TFA;

class ProfileTFA extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        $this->rowAuth();

        if ($this->row->tfaAvailable() === false) {
            return redirect()->back();
        }

        if ($response = $this->actionPost('profileTFA')) {
            return $response;
        }

        $this->requestMergeWithRow();

        $this->meta('title', __('user-profile-tfa.meta-title'));

        return $this->page('user.profile-tfa', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return [
            'row' => $this->row,
            'tfa_enabled' => true,
            'tfa_qr' => TFA::getQRCodeInline($this->row->email, $this->row->tfa_secret),
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function profileTFA(): RedirectResponse
    {
        $this->action()->profileTFA();

        $this->sessionMessage('success', __('user-profile-tfa.success'));

        return redirect()->route('user.profile.tfa');
    }
}
