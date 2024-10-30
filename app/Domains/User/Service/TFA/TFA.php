<?php declare(strict_types=1);

namespace App\Domains\User\Service\TFA;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use PragmaRX\Google2FAQRCode\Google2FA;
use PragmaRX\Google2FAQRCode\QRCode\Bacon;

class TFA
{
    /**
     * @return \PragmaRX\Google2FAQRCode\Google2FA
     */
    protected static function google2FA(): Google2FA
    {
        return new Google2FA(new Bacon(new SvgImageBackEnd()));
    }

    /**
     * @return string
     */
    public static function generateSecretKey(): string
    {
        return static::google2FA()->generateSecretKey();
    }

    /**
     * @param string $email
     * @param string $secret
     *
     * @return string
     */
    public static function getQRCodeInline(string $email, string $secret): string
    {
        $svg = static::google2FA()->getQRCodeInline(config('app.name'), $email, $secret, 260);

        if (str_starts_with($svg, 'data:') === false) {
            $svg = 'data:image/svg+xml;base64,'.base64_encode($svg);
        }

        return $svg;
    }

    /**
     * @param string $secret
     * @param string $code
     *
     * @return bool
     */
    public static function verifyKey(string $secret, string $code): bool
    {
        return static::google2FA()->verifyKey($secret, $code);
    }
}
