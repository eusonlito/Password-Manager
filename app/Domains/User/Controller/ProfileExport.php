<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\Response;
use App\Domains\User\Service\TFA\TFA;

class ProfileExport extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->rowAuth();

        if ($response = $this->actionPost('profileExport')) {
            return $response;
        }

        $this->requestMergeWithRow();

        $this->meta('title', __('user-profile-export.meta-title'));

        return $this->page('user.profile-export', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return [
            'row' => $this->row,
            'tfa_enabled' => ($enabled = $this->row->tfaAvailable()),
            'tfa_qr' => ($enabled ? TFA::getQRCodeInline($this->row->email, $this->row->tfa_secret) : null),
        ];
    }

    /**
     * @return \Illuminate\Http\Response
     */
    protected function profileExport(): Response
    {
        return response()->make($this->action()->profileExport(), 200, [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'attachment; filename="password-manager-apps.zip"',
        ]);
    }
}
