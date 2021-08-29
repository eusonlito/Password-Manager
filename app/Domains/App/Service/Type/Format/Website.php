<?php declare(strict_types=1);

namespace App\Domains\App\Service\Type\Format;

use App\Domains\App\Service\Icon\Download as IconDownload;
use App\Domains\App\Service\Type\TypeAbstract;

class Website extends TypeAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'website';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('app-type.website');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return $this->iconDownload() ?: '/build/images/app-type-website.png';
    }

    /**
     * @return ?string
     */
    public function iconDownload(): ?string
    {
        if (empty($this->payload['url'])) {
            return null;
        }

        return (new IconDownload($this->payload['url']))->get();
    }

    /**
     * @return string
     */
    public function payload(): string
    {
        return $this->encrypt([
            'url' => $this->url(),
            'user' => ($this->payload['user'] ?? ''),
            'password' => ($this->payload['password'] ?? ''),
            'recovery' => ($this->payload['recovery'] ?? ''),
            'notes' => ($this->payload['notes'] ?? ''),
        ]);
    }

    /**
     * @return string
     */
    public function url(): string
    {
        $url = $this->payload['url'] ?? '';

        if (empty($url)) {
            return '';
        }

        if (str_contains($url, '://') === false) {
            $url = 'http://'.$url;
        }

        return $url;
    }
}
