<?php declare(strict_types=1);

namespace App\Domains\App\Service\Icon;

use Exception;
use App\Services\Image\Search as ImageSearch;
use App\Services\Http\Curl\Curl;

class Download
{
    /**
     * @var string
     */
    protected string $host;

    /**
     * @var string
     */
    protected string $www;

    /**
     * @var string
     */
    protected string $path;

    /**
     * @param string $url
     *
     * @return self
     */
    public function __construct(string $url)
    {
        $this->host($url);
        $this->www();
        $this->path();
    }

    /**
     * @return ?string
     */
    public function get(): ?string
    {
        return $this->host ? ($this->exists() ?: $this->download()) : null;
    }

    /**
     * @param string $url
     *
     * @return void
     */
    protected function host(string $url): void
    {
        $this->host = preg_replace('/[^a-z0-9_\-\.]/', '', parse_url($url, PHP_URL_HOST) ?: helper()->urlDomain($url));
    }

    /**
     * @return void
     */
    protected function www(): void
    {
        $this->www = '/storage/app/host/'.$this->host.'.png';
    }

    /**
     * @return void
     */
    protected function path(): void
    {
        $this->path = public_path($this->www);
    }

    /**
     * @return ?string
     */
    protected function exists(): ?string
    {
        return is_file($this->path) ? $this->www : null;
    }

    /**
     * @return ?string
     */
    protected function download(): ?string
    {
        $images = (new ImageSearch(preg_replace('/[^a-z0-9]/', ' ', $this->host).' logo'))->search();

        foreach ($images as $image) {
            if ($image = $this->downloadImage($image)) {
                return $image;
            }
        }

        return null;
    }

    /**
     * @param string $image
     *
     * @return ?string
     */
    protected function downloadImage(string $image): ?string
    {
        if (empty($contents = $this->downloadImageRequest($image))) {
            return null;
        }

        try {
            Image::save($this->path, $contents);
        } catch (Exception $e) {
            return null;
        }

        return $this->www;
    }

    /**
     * @param string $url
     *
     * @return ?string
     */
    protected function downloadImageRequest(string $url): ?string
    {
        return (new Curl())
            ->setUrl($url)
            ->setTimeOut(5)
            ->setException(false)
            ->send()
            ->getBody();
    }
}
