<?php declare(strict_types=1);

namespace App\Services\Html;

use App\Services\Image\Transform as ImageTransform;

class Html
{
    /**
     * @var array
     */
    protected static array $asset = [];

    /**
     * @var array
     */
    protected static array $query;

    /**
     * @param string $path
     * @param bool $inline = false
     *
     * @return string
     */
    public static function asset(string $path, bool $inline = false): string
    {
        if (isset(static::$asset[$path])) {
            return static::$asset[$path];
        }

        $file = public_path($path);

        if (is_file($file) === false) {
            return static::$asset[$path] = $inline ? '' : asset($path);
        }

        if ($inline) {
            return static::$asset[$path] = file_get_contents($file);
        }

        return static::$asset[$path] = asset($path).'?'.filemtime($file);
    }

    /**
     * @param string $image
     * @param string $transform = ''
     *
     * @return string
     */
    public static function image(string $image, string $transform = ''): string
    {
        return ImageTransform::image($image, $transform);
    }

    /**
     * @param array $query
     *
     * @return string
     */
    public static function query(array $query): string
    {
        return helper()->query($query);
    }

    /**
     * @param ?float $value
     * @param int $decimals = 4
     *
     * @return string
     */
    public static function number(?float $value, int $decimals = 4): string
    {
        return helper()->number($value, $decimals);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function color(string $string): string
    {
        if (preg_match('/^#[a-zA-Z0-9]{6}$/', $string)) {
            return $string;
        }

        $string = preg_replace('/[a-z]/', '', md5($string));
        $i = 0;

        do {
            $color = (int)substr($string, $i++, 3);
        } while ($color && (($color < 10) || ($color > 230)));

        return 'hsl('.$color.', 74.2%, 80%);';
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function backgroundColor(string $string): string
    {
        return 'background-color: '.static::color($string);
    }

    /**
     * @param string $name
     * @param string $class = ''
     *
     * @return string
     */
    public static function icon(string $name, string $class = ''): string
    {
        return '<svg class="feather '.$class.'"><use xlink:href="'.static::asset('build/images/feather-sprite.svg').'#'.$name.'" /></svg>';
    }

    /**
     * @param ?bool $status
     * @param ?string $text = null
     *
     * @return string
     */
    public static function status(?bool $status, ?string $text = null): string
    {
        if ($status === null) {
            return '-';
        }

        if ($status) {
            $theme = 'text-theme-10';
            $icon = 'check-square';
        } else {
            $theme = 'text-theme-24';
            $icon = 'square';
        }

        return '<span class="'.$theme.'">'.($text ?: static::icon($icon, 'w-4 h-4 mr-2')).'</span>';
    }

    /**
     * @param ?string $status
     *
     * @return string
     */
    public static function statusString(?string $status): string
    {
        return $status ? static::status($status === 'SUCCESS') : '-';
    }

    /**
     * @param ?int $status
     *
     * @return string
     */
    public static function statusNumber(?int $status): string
    {
        return $status ? static::status($status === 200, (string)$status) : '-';
    }

    /**
     * @param ?string $text
     *
     * @return string
     */
    public static function hidden(?string $text): string
    {
        return $text ? substr(str_repeat('*', max(strlen($text), 10)), 0, 15) : '';
    }

    /**
     * @param string|array|object|null $json
     *
     * @return string
     */
    public static function jsonPretty(string|array|object|null $json): string
    {
        if ($json === null) {
            return '-';
        }

        if (is_string($json)) {
            $json = json_decode($json);
        } elseif (is_object($json)) {
            $json = json_decode(json_encode($json), true);
        }

        if (empty($json)) {
            return '-';
        }

        $tags = [];

        foreach ($json as $key => $value) {
            $tags[] = '<div class="text-xs p-1.5 bg-indigo-200 text-indigo-800 rounded-lg">'
                .'<span class="font-medium">'.preg_replace('/[\W_]/', ' ', (string)$key).':</span>'
                .' '.(string)$value.'</div>';
        }

        return '<div class="flex justify-center space-x-2">'.implode(' ', $tags).'</div>';
    }
}
