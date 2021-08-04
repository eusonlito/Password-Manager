<?php declare(strict_types=1);

namespace App\Services\Network\Whois\Service;

use Exception;

class DonDominio extends ServiceAbstract
{
    /**
     * @return bool
     */
    public function available(): bool
    {
        return ($this->config['enabled'] ?? false)
            && ($this->config['host'] ?? false)
            && ($this->config['user'] ?? false)
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
        return $this->curl($this->config['host'].'/domain/getinfo/')
            ->setMethod('POST')
            ->setBody($this->requestBody())
            ->setLog()
            ->send()
            ->getBody('array');
    }

    /**
     * @return array
     */
    protected function requestBody(): array
    {
        return [
            'apiuser' => $this->config['user'],
            'apipasswd' => $this->config['key'],
            'infoType' => 'status',
            'domain' => $this->host,
        ];
    }

    /**
     * @param ?array $response
     *
     * @return array
     */
    protected function response(?array $response): array
    {
        if (($response === null) || ($response['success'] === false)) {
            throw new Exception(sprintf('No whois available to domain %s.', $this->host));
        }

        return [
            'createdDate' => $this->date($response['responseData']['tsCreate'] ?? null),
            'updatedDate' => null,
            'expiresDate' => $this->date($response['responseData']['tsExpir'] ?? null, true),
        ];
    }
}
