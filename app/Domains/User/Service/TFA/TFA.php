<?php declare(strict_types=1);

namespace App\Domains\User\Service\TFA;

use PragmaRX\Google2FAQRCode\Google2FA;

class TFA
{
    /**
     * @return \PragmaRX\Google2FAQRCode\Google2FA
     */
    protected static function google2FA(): Google2FA
    {
        return new Google2FA();
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
        return static::google2FA()->getQRCodeInline(config('app.name'), $email, $secret, 260);
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
