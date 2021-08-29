<?php declare(strict_types=1);

namespace App\Services\Network\Whois\Service;

use Exception;

class Server extends ServiceAbstract
{
    /**
     * @var ?string
     */
    protected ?string $server;

    /**
     * @param array $config
     *
     * @return void
     */
    protected function config(array $config): void
    {
        $this->config = $config;
        $this->server = $config['servers'][$this->ltd()] ?? null;
    }

    /**
     * @return string
     */
    protected function ltd(): string
    {
        return strtolower(array_reverse(explode('.', $this->host))[0]);
    }

    /**
     * @return bool
     */
    public function available(): bool
    {
        return ($this->config['enabled'] ?? false)
            && (bool)$this->server;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $response = $this->request($this->server);

        if (isset($response['whois-host'])) {
            $response = $this->request($response['whois-host']);
        }

        return $this->response($response);
    }

    /**
     * @param string $server
     *
     * @return array
     */
    protected function request(string $server): array
    {
        return $this->requestResponse($server, $this->requestOutput($server));
    }

    /**
     * @param string $server
     *
     * @return string
     */
    protected function requestOutput(string $server): string
    {
        $fp = fsockopen($server, 43, $errno, $errstr, 10);

        if (empty($fp)) {
            throw new Exception(sprintf('Can not connect to host %s: %s', $server, $errstr));
        }

        fputs($fp, $this->host."\r\n");

        $output = '';

        while (!feof($fp)) {
            $output .= fgets($fp);
        }

        fclose($fp);

        return $output;
    }

    /**
     * @param string $server
     * @param string $output
     *
     * @return array
     */
    protected function requestResponse(string $server, string $output): array
    {
        if (str_contains(strtolower($output), 'error') || str_contains(strtolower($output), 'not allocated')) {
            throw new Exception(sprintf('Server %s returns error: %s', $server, $output));
        }

        $response = [];

        foreach (explode("\n", $output) as $line) {
            $line = trim($line);

            if (preg_match('/^[A-Za-z\s]+:/', $line) === 0) {
                continue;
            }

            [$key, $value] = explode(':', $line, 2);

            $response[str_slug($key)] = trim($value);
        }

        return $response;
    }

    /**
     * @param array $response
     *
     * @return array
     */
    protected function response(array $response): array
    {
        if (empty($response)) {
            throw new Exception(sprintf('No whois available to domain %s.', $this->host));
        }

        return [
            'createdDate' => $this->date($response['creation-date'] ?? null),
            'updatedDate' => $this->date($response['updated-date'] ?? null),
            'expiresDate' => $this->date($this->responseExpiresDate($response), true),
        ];
    }

    /**
     * @param array $response
     *
     * @return ?string
     */
    protected function responseExpiresDate(array $response): ?string
    {
        return $response['registry-expiry-date']
            ?? $response['expiry-date']
            ?? $response['expiration-date']
            ?? $response['registrar-registration-expiration-date']
            ?? null;
    }
}
