<?php declare(strict_types=1);

namespace App\Services\Network\Whois\Service;

use Exception;

class WhoisXmlApi extends ServiceAbstract
{
    /**
     * @return bool
     */
    public function available(): bool
    {
        return ($this->config['enabled'] ?? false)
            && ($this->config['host'] ?? false)
            && ($this->config['key'] ?? false);
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->response($this->request());
    }

    /**
     * @return ?array
     */
    protected function request(): ?array
    {
        return $this->curl($this->config['host'].'/whoishost/WhoisService')
            ->setQuery($this->requestQuery())
            ->setLog()
            ->setJson()
            ->send()
            ->getBody('array');
    }

    /**
     * @return array
     */
    protected function requestQuery(): array
    {
        return [
            'apiKey' => $this->config['key'],
            'domainName' => $this->host,
            'ignoreRawTexts' => 1,
            'outputFormat' => 'JSON',
        ];
    }

    /**
     * @param ?array $response
     *
     * @return array
     */
    protected function response(?array $response): array
    {
        if ($response === null) {
            throw new Exception(sprintf('No whois available to domain %s.', $this->host));
        }

        return [
            'createdDate' => $this->date($response['WhoisRecord']['audit']['createdDate'] ?? null),
            'updatedDate' => $this->date($response['WhoisRecord']['audit']['updatedDate'] ?? null),
            'expiresDate' => $this->date($response['WhoisRecord']['audit']['expiresDate'] ?? null, true),
        ];
    }
}
