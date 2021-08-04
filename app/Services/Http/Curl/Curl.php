<?php declare(strict_types=1);

namespace App\Services\Http\Curl;

use CurlHandle;
use Throwable;
use Illuminate\Support\Facades\Log as LogVendor;

class Curl
{
    /**
     * @var \CurlHandle
     */
    protected CurlHandle $curl;

    /**
     * @var int
     */
    protected int $timeout = 30;

    /**
     * @var string
     */
    protected string $url = '';

    /**
     * @var string
     */
    protected string $method = 'GET';

    /**
     * @var array
     */
    protected array $headers = [];

    /**
     * @var array
     */
    protected array $query = [];

    /**
     * @var bool
     */
    protected bool $cachePost = false;

    /**
     * @var \App\Services\Http\Curl\Cache
     */
    protected Cache $cache;

    /**
     * @var mixed
     */
    protected $body;

    /**
     * @var bool
     */
    protected bool $isJson = false;

    /**
     * @var bool
     */
    protected bool $exception = true;

    /**
     * @var bool
     */
    protected bool $log = false;

    /**
     * @var string|bool
     */
    protected $response = '';

    /**
     * @var array
     */
    protected array $info = [];

    /**
     * @return self
     */
    public function __construct()
    {
        $this->initCurl();
        $this->initCache();
    }

    /**
     * @return self
     */
    protected function initCurl()
    {
        $this->curl = curl_init();

        $this->setOption(CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        $this->setOption(CURLOPT_TIMEOUT, $this->timeout);
        $this->setOption(CURLOPT_MAXREDIRS, 5);
        $this->setOption(CURLOPT_FOLLOWLOCATION, true);
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $this->setOption(CURLOPT_SSL_VERIFYHOST, false);
        $this->setOption(CURLOPT_COOKIESESSION, false);
        $this->setOption(CURLOPT_FORBID_REUSE, true);
        $this->setOption(CURLOPT_FRESH_CONNECT, true);

        $this->setHeader('User-Agent', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.96 Safari/537.36');
        $this->setHeader('Connection', 'close');

        return $this;
    }

    /**
     * @return self
     */
    protected function initCache()
    {
        $this->cache = new Cache();

        return $this;
    }

    /**
     * @param int $option
     * @param mixed $value
     *
     * @return self
     */
    public function setOption(int $option, $value): self
    {
        curl_setopt($this->curl, $option, $value);

        return $this;
    }

    /**
     * @param string $method
     *
     * @return self
     */
    public function setMethod(string $method): self
    {
        $this->method = strtoupper($method);

        $this->setOption(CURLOPT_CUSTOMREQUEST, $this->method);

        return $this;
    }

    /**
     * @param string $url
     *
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param array $query
     *
     * @return self
     */
    public function setQuery(array $query): self
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @param mixed $body
     *
     * @return self
     */
    public function setBody($body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @param array $headers
     *
     * @return self
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return self
     */
    public function setHeader(string $key, $value): self
    {
        $this->headers[$key] = $value;

        return $this;
    }

    /**
     * @param callable $function
     *
     * @return self
     */
    public function setHeaderFunction(callable $function): self
    {
        $this->setOption(CURLOPT_HEADERFUNCTION, $function);

        return $this;
    }

    /**
     * @param ?string $token
     * @param bool $bearer = true
     *
     * @return self
     */
    public function setAuthorization(?string $token, bool $bearer = true): self
    {
        if ($token) {
            $this->setHeader('Authorization', ($bearer ? 'Bearer ' : '').$token);
        }

        return $this;
    }

    /**
     * @param string $user
     * @param string $password
     *
     * @return self
     */
    public function setUserPassword(string $user, string $password): self
    {
        $this->setOption(CURLOPT_USERPWD, $user.':'.$password);

        return $this;
    }

    /**
     * @return self
     */
    public function setJson(): self
    {
        $this->isJson = true;

        $this->setHeader('Accept', 'application/json');
        $this->setHeader('Content-Type', 'application/json');

        return $this;
    }

    /**
     * @param int $timeout
     *
     * @return self
     */
    public function setTimeOut(int $timeout): self
    {
        $this->setOption(CURLOPT_TIMEOUT, $this->timeout = $timeout);

        return $this;
    }

    /**
     * @return self
     */
    public function setStream(): self
    {
        $this->setHeader('Content-Type', 'application/octet-stream');

        $this->setOption(CURLOPT_WRITEFUNCTION, function ($curl, $string) {
            echo $string;

            return strlen($string);
        });

        return $this;
    }

    /**
     * @param resource $fp
     * @param ?int $size = null
     *
     * @return self
     */
    public function setFile($fp, ?int $size = null): self
    {
        $this->setOption(CURLOPT_UPLOAD, true);
        $this->setOption(CURLOPT_INFILE, $fp);
        $this->setOption(CURLOPT_BINARYTRANSFER, true);

        if ($size !== null) {
            $this->setOption(CURLOPT_INFILESIZE, $size);
        }

        return $this;
    }

    /**
     * @param bool $exception = true
     *
     * @return self
     */
    public function setException(bool $exception = true): self
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * @param int $ttl
     *
     * @return self
     */
    public function setCache(int $ttl): self
    {
        $this->cache->setTTL($ttl);

        return $this;
    }

    /**
     * @param bool $cache = true
     *
     * @return self
     */
    public function setCachePost(bool $cache = true): self
    {
        $this->cachePost = $cache;

        return $this;
    }

    /**
     * @param bool $log = true
     *
     * @return self
     */
    public function setLog(bool $log = true): self
    {
        $this->log = $log;

        return $this;
    }

    /**
     * @return self
     */
    public function writeHeaders(): self
    {
        $this->headers = array_filter($this->headers);

        if (empty($this->headers)) {
            return $this;
        }

        $this->setOption(CURLOPT_HTTPHEADER, array_map(static function (string $key, $value): string {
            return $key.': '.(is_array($value) ? json_encode($value) : $value);
        }, array_keys($this->headers), $this->headers));

        return $this;
    }

    /**
     * @return self
     */
    public function send(): self
    {
        $this->response = $this->cacheGet() ?: $this->sendExec();

        curl_close($this->curl);

        if ($this->sendSuccess()) {
            $this->success();
        } else {
            $this->error();
        }

        return $this;
    }

    /**
     * @return ?string
     */
    public function sendExec(): ?string
    {
        $this->writeHeaders();

        $this->sendUrl();
        $this->sendPost();

        $response = curl_exec($this->curl);

        $this->info = curl_getinfo($this->curl);

        return is_string($response) ? $response : null;
    }

    /**
     * @return bool
     */
    public function sendSuccess(): bool
    {
        return empty($this->info) || (($this->info['http_code'] >= 200) && ($this->info['http_code'] <= 299));
    }

    /**
     * @param string $key = ''
     *
     * @return mixed
     */
    public function info(string $key = '')
    {
        return $key ? $this->info[$key] : $this->info;
    }

    /**
     * @param ?string $format = null
     *
     * @return mixed
     */
    public function getBody(?string $format = null)
    {
        if ($this->response === false) {
            return null;
        }

        if ($this->isJson && ($format === null)) {
            $format = 'object';
        }

        switch ($format) {
            case 'array':
                return json_decode($this->response, true);

            case 'object':
                return json_decode($this->response);

            default:
                return $this->response;
        }
    }

    /**
     * @return self
     */
    protected function sendUrl(): self
    {
        $this->setOption(CURLOPT_URL, $this->sendUrlString());

        return $this;
    }

    /**
     * @return string
     */
    protected function sendUrlString(): string
    {
        if (empty($this->query)) {
            return $this->url;
        }

        return $this->url .= (strpos($this->url, '?') ? '&' : '?').http_build_query($this->query, '', '&');
    }

    /**
     * @return self
     */
    protected function sendPost(): self
    {
        if (in_array($this->method, ['POST', 'PUT']) === false) {
            return $this;
        }

        if ($this->body === false) {
            return $this;
        }

        if ($this->body && $this->isJson) {
            $body = json_encode($this->body, JSON_PARTIAL_OUTPUT_ON_ERROR);
        } elseif ($this->body === null) {
            $body = 'null';
        } else {
            $body = $this->body;
        }

        $this->setOption(CURLOPT_POSTFIELDS, $body);

        return $this;
    }

    /**
     * @return bool
     */
    protected function cacheEnabled(): bool
    {
        return (($this->method === 'GET') || $this->cachePost)
            && $this->cache->getEnabled();
    }

    /**
     * @return ?string
     */
    protected function cacheGet(): ?string
    {
        if ($this->cacheEnabled() === false) {
            return null;
        }

        $this->cache->setData(get_object_vars($this));

        return $this->cache->get();
    }

    /**
     * @return void
     */
    protected function cacheSet(): void
    {
        if ($this->cacheSetEnabled()) {
            $this->cache->set($this->response);
        }
    }

    /**
     * @return bool
     */
    protected function cacheSetEnabled(): bool
    {
        return $this->cacheEnabled()
            && is_string($this->response)
            && ($this->cache->exists() === false);
    }

    /**
     * @return void
     */
    protected function success(): void
    {
        $this->log();
        $this->cacheSet();
    }

    /**
     * @throws \App\Services\Http\Curl\CurlException
     *
     * @return void
     */
    protected function error(): void
    {
        $this->log('error', $e = $this->exception());

        if (app()->bound('sentry')) {
            app('sentry')->captureException($e);
        }

        if ($this->exception) {
            throw $e;
        }
    }

    /**
     * @return \App\Services\Http\Curl\CurlException
     */
    protected function exception(): CurlException
    {
        $message = $this->exceptionMessage((string)$this->response);
        $code = $this->exceptionCode((string)$this->response, $this->info['http_code']);

        return new CurlException($message, $code);
    }

    /**
     * @param string $message
     *
     * @return string
     */
    protected function exceptionMessage(string $message): string
    {
        if (strpos($message, '{') !== 0) {
            return $message;
        }

        if (empty($json = json_decode($message, true))) {
            return $message;
        }

        return $json['message'] ?? $json['msg'] ?? $message;
    }

    /**
     * @param string $message
     * @param int $code
     *
     * @return int
     */
    protected function exceptionCode(string $message, int $code): int
    {
        if ($code !== 400) {
            return $code;
        }

        if ($this->isAuthException($message)) {
            return 401;
        }

        return $code;
    }

    /**
     * @param string $message
     *
     * @return bool
     */
    protected function isAuthException(string $message): bool
    {
        return (strpos($message, 'invalid_grant') !== false)
            || (strpos($message, 'invalid_request') !== false)
            || (strpos($message, 'unsupported_grant_type') !== false)
            || (strpos($message, 'unauthorized_client') !== false);
    }

    /**
     * @param string $status = 'success'
     * @param ?\Throwable $e = null
     *
     * @return void
     */
    protected function log(string $status = 'success', ?Throwable $e = null): void
    {
        $this->logFile($status);

        if ($e) {
            LogVendor::error($e);
        }
    }

    /**
     * @param string $status
     *
     * @return void
     */
    protected function logFile(string $status): void
    {
        if ($this->log !== true) {
            return;
        }

        $data = get_object_vars($this);

        unset($data['curl']);

        if ($this->isJson && $data['response']) {
            $data['response'] = json_decode($data['response']);
        }

        Log::write($this->url, $status, $data);
    }
}
