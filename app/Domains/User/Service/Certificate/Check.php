<?php declare(strict_types=1);

namespace App\Domains\User\Service\Certificate;

class Check
{
    /**
     * @param array $server
     *
     * @return ?string
     */
    public static function fromServer(array $server): ?string
    {
        return ($dn = static::dn($server)) ? static::fromDN($dn) : null;
    }

    /**
     * @param string $dn
     *
     * @return ?string
     */
    public static function fromDN(string $dn): ?string
    {
        if ($certificate = static::fromFormat($dn)) {
            return strtoupper($certificate);
        }

        return null;
    }

    /**
     * @param string $dn
     *
     * @return ?string
     */
    protected static function fromFormat(string $dn): ?string
    {
        return static::formatFNMTOld($dn)
            ?: static::formatFNMT($dn)
            ?: static::formatDNIe($dn)
            ?: null;
    }

    /**
     * @param string $dn
     *
     * @return ?string
     */
    protected static function formatFNMT(string $dn): ?string
    {
        return preg_match('#/serialNumber=([0-9a-z]+)#i', $dn, $code) ? $code[1] : null;
    }

    /**
     * @param string $dn
     *
     * @return ?string
     */
    protected static function formatFNMTOld(string $dn): ?string
    {
        return preg_match('#,serialNumber=([a-z]+\-)?([0-9a-z]+)#i', $dn, $code) ? $code[2] : null;
    }

    /**
     * @param string $dn
     *
     * @return ?string
     */
    protected static function formatDNIe(string $dn): ?string
    {
        return preg_match('#(NIF|CIF) ([a-z]{0,2}[0-9]{7,8}[a-z]?)#i', $dn, $code) ? $code[2] : null;
    }

    /**
     * @param string $certificate
     *
     * @return bool
     */
    public static function validate(string $certificate): bool
    {
        return (bool)preg_match('/^[0-9a-zA-Z]{9,12}$/', $certificate);
    }

    /**
     * @param array $server
     *
     * @return ?string
     */
    protected static function dn(array $server): ?string
    {
        return $server['SSL_CLIENT_S_DN'] ?? $server['REDIRECT_SSL_CLIENT_S_DN'] ?? null;
    }
}
