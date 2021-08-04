<?php declare(strict_types=1);

namespace App\Services\Network\Whois\Service;

use Exception;

class Dinahosting extends ServiceAbstract
{
    /**
     * @return bool
     */
    public function available(): bool
    {
        return ($this->config['enabled'] ?? false)
            && ($this->config['host'] ?? false)
            && ($this->config['user'] ?? false)
            && ($this->config['password'] ?? false);
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
        return $this->curl($this->config['host'].'/special/api.php')
            ->setMethod('POST')
            ->setUserPassword($this->config['user'], $this->config['password'])
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
            'command' => 'Domain_GetInfoDomain',
            'responseType' => 'json',
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
        if (($response === null) || ($response['responseCode'] !== 1000)) {
            throw new Exception(sprintf('No whois available to domain %s.', $this->host));
        }

        return [
            'createdDate' => $this->date($response['data']['domain_crDate'] ?? null),
            'updatedDate' => null,
            'expiresDate' => $this->date($response['data']['domain_exDate'] ?? null, true),
        ];
    }
}
