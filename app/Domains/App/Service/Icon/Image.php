<?php declare(strict_types=1);

namespace App\Domains\App\Service\Icon;

use Imagick;

class Image
{
    /**
     * @param string $path
     * @param string $contents
     *
     * @return void
     */
    public static function save(string $path, string $contents)
    {
        $image = static::imageOpen($contents);

        unset($contents);

        static::imageTrim($image);
        static::imageScale($image);
        static::imageSave($image, $path);

        unset($image);
    }

    /**
     * @param string $contents
     *
     * @return \Imagick
     */
    protected static function imageOpen(string $contents): Imagick
    {
        $image = new Imagick();
        $image->readImageBlob($contents);
        $image->stripImage();

        return $image;
    }

    /**
     * @param \Imagick $image
     *
     * @return void
     */
    protected static function imageTrim(Imagick $image): void
    {
        $fuzz = 0.15 * $image->getQuantumRange()['quantumRangeLong'];
        $size = intval(1 / 100 * min($image->getImageWidth(), $image->getImageHeight()));

        $image->floodFillPaintImage('rgb(255, 0, 255)', $fuzz, 'rgb(255, 255, 255)', 0, 0, false);
        $image->borderImage('rgb(255, 0, 255)', $size, $size);
        $image->transparentPaintImage('rgb(255, 0, 255)', 0, $fuzz, false);
        $image->despeckleimage();

        $image->trimImage($fuzz);
        $image->setImagePage(0, 0, 0, 0);
    }

    /**
     * @param \Imagick $image
     *
     * @return void
     */
    protected static function imageScale(Imagick $image): void
    {
        if ($image->getImageWidth() > $image->getImageHeight()) {
            $width = 512;
            $height = 0;
        } else {
            $width = 0;
            $height = 512;
        }

        $image->resizeImage($width, $height, Imagick::FILTER_CATROM, 1);
        $image->setImagePage(0, 0, 0, 0);
    }

    /**
     * @param \Imagick $image
     * @param string $path
     *
     * @return void
     */
    protected static function imageSave(Imagick $image, string $path): void
    {
        $dir = dirname($path);

        clearstatcache(true, $dir);

        if (is_dir($dir) === false) {
            mkdir($dir, 0o755, true);
        }

        file_put_contents($path, $image);
    }
}
