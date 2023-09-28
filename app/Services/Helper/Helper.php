<?php declare(strict_types=1);

namespace App\Services\Helper;

use Exception;
use App\Exceptions\NotFoundException;

class Helper
{
    /**
     * @param string $dir
     * @param bool $file = false
     *
     * @return string
     */
    public function mkdir(string $dir, bool $file = false): string
    {
        if ($file) {
            $dir = dirname($dir);
        }

        clearstatcache(true, $dir);

        if (is_dir($dir)) {
            return $dir;
        }

        try {
            mkdir($dir, 0o755, true);
        } catch (Exception $e) {
            report($e);
        }

        return $dir;
    }

    /**
     * @param int $length
     * @param bool $safe = false
     * @param bool $lower = false
     *
     * @return string
     */
    public function uniqidReal(int $length, bool $safe = false, bool $lower = false): string
    {
        if ($safe) {
            $string = '23456789bcdfghjkmnpqrstwxyzBCDFGHJKMNPQRSTWXYZ';
        } else {
            $string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        if ($lower) {
            $string = strtolower($string);
        }

        return substr(str_shuffle(str_repeat($string, rand((int)($length / 2), $length))), 0, $length);
    }

    /**
     * @param string $string
     * @param int $prefix = 0
     * @param int $suffix = 0
     *
     * @return string
     */
    public function slug(string $string, int $prefix = 0, int $suffix = 0): string
    {
        if ($prefix) {
            $string = $this->uniqidReal($prefix, true).'-'.$string;
        }

        if ($suffix) {
            $string .= '-'.$this->uniqidReal($suffix, true);
        }

        return str_slug($string);
    }

    /**
     * @param ?string $string
     *
     * @return string
     */
    public function searchLike(?string $string): string
    {
        $string = preg_replace('/\s+/', '%', trim(preg_replace('/[^\p{L}0-9]/u', ' ', (string)$string)));

        return $string ? ('%'.$string.'%') : '';
    }

    /**
     * @param mixed $value
     *
     * @return ?string
     */
    public function jsonEncode($value): ?string
    {
        if ($value === null) {
            return null;
        }

        return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function stringEncode(string $string): string
    {
        return base64_encode(implode('\x', array_map('bin2hex', preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY))));
    }

    /**
     * @param array $array
     * @param array $keys
     *
     * @return array
     */
    public function arrayKeysWhitelist(array $array, array $keys): array
    {
        return array_intersect_key($array, array_flip($keys));
    }

    /**
     * @param array $array
     * @param array $keys
     *
     * @return array
     */
    public function arrayKeysBlacklist(array $array, array $keys): array
    {
        return array_diff_key($array, array_flip($keys));
    }

    /**
     * @param array $array
     * @param array $values
     *
     * @return array
     */
    public function arrayValuesWhitelist(array $array, array $values): array
    {
        return array_intersect($array, $values);
    }

    /**
     * @param array $array
     * @param array $values
     *
     * @return array
     */
    public function arrayValuesBlacklist(array $array, array $values): array
    {
        return array_diff($array, $values);
    }

    /**
     * @param array $array
     * @param ?callable $callback = null
     *
     * @return array
     */
    public function arrayFilterRecursive(array $array, ?callable $callback = null): array
    {
        $callback ??= static fn ($value) => (bool)$value;

        return array_filter(array_map(fn ($value) => is_array($value) ? $this->arrayFilterRecursive($value, $callback) : $value, $array), $callback);
    }

    /**
     * @param array $query
     *
     * @return string
     */
    public function query(array $query): string
    {
        static $request = null;

        return http_build_query($query + ($request ??= request()->query()));
    }

    /**
     * @param ?float $value
     * @param int $decimals = 2
     * @param ?string $default = '-'
     *
     * @return ?string
     */
    public function number(?float $value, int $decimals = 2, ?string $default = '-'): ?string
    {
        if ($value === null) {
            return $default;
        }

        return number_format($value, $decimals, ',', '.');
    }

    /**
     * @param ?string $date
     * @param ?string $default = '-'
     *
     * @return string
     */
    public function dateLocal(?string $date, ?string $default = '-'): ?string
    {
        if (empty($date)) {
            return $default;
        }

        $time = strtotime($date);

        if ($time === false) {
            return $default;
        }

        return date(str_contains($date, ' ') ? 'd/m/Y H:i' : 'd/m/Y', $time);
    }

    /**
     * @return string
     */
    public function uuid(): string
    {
        $data = random_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0F | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3F | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * @param string $date
     * @param ?string $default = null
     *
     * @return ?string
     */
    public function dateToDate(string $date, ?string $default = null): ?string
    {
        if (empty($date)) {
            return $default;
        }

        [$day, $time] = explode(' ', $date) + ['', ''];

        if (str_contains($day, ':')) {
            [$day, $time] = [$time, $day];
        }

        if (!preg_match('#^[0-9]{1,4}[/\-][0-9]{1,2}[/\-][0-9]{1,4}$#', $day)) {
            return $default;
        }

        if ($time) {
            if (substr_count($time, ':') === 1) {
                $time .= ':00';
            }

            if (!preg_match('#^[0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$#', $time)) {
                return $default;
            }
        }

        $day = preg_split('#[/\-]#', $day);

        if (strlen($day[0]) !== 4) {
            $day = array_reverse($day);
        }

        return trim(implode('-', $day).' '.$time);
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function urlDomain(string $url): string
    {
        if (str_starts_with($url, 'http') === false) {
            $url = 'http://'.$url;
        }

        $host = parse_url($url, PHP_URL_HOST);

        if (empty($host) || str_contains($host, ':') || (preg_match('/[a-z]/', $host) === 0)) {
            return '';
        }

        $host = array_reverse(explode('.', $host));

        if (count($host) === 1) {
            return $host[0];
        }

        array_shift($host);

        if (count($host) === 1) {
            return $host[0];
        }

        $current = '';

        while ($host) {
            $current = array_shift($host);

            if (strlen($current) > 3) {
                return $current;
            }
        }

        return $current;
    }

    /**
     * @param string $message = ''
     *
     * @throws \App\Exceptions\NotFoundException
     *
     * @return void
     */
    public function notFound(string $message = ''): void
    {
        throw new NotFoundException($message ?: __('common.error.not-found'));
    }
}
