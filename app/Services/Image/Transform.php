<?php declare(strict_types=1);

namespace App\Services\Image;

use Packer;

class Transform
{
    /**
     * @param string $image
     * @param string $transform
     *
     * @return string
     */
    public static function image(string $image, string $transform = ''): string
    {
        if (empty($transform)) {
            return asset($image);
        }

        return (string)Packer::img($image, static::transform($transform));
    }

    /**
     * @param string $transform
     *
     * @return string
     */
    protected static function transform(string $transform): string
    {
        if (strstr($transform, 'resizeCrop') && (substr_count($transform, ',') === 2)) {
            $transform .= ',CROP_ENTROPY';
        }

        return $transform;
    }
}
