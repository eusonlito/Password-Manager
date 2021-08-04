<?php declare(strict_types=1);

namespace App\Domains\Translation\Service;

use App\Exceptions\UnexpectedValueException;

class Translate extends ServiceAbstract
{
    /**
     * @const string
     */
    protected const LANG = 'es';

    /**
     * @const string
     */
    protected const ENDPOINT = 'https://api.cognitive.microsofttranslator.com/translate?api-version=3.0&from=:from&to=:to';

    /**
     * @var string
     */
    protected string $lang = '';

    /**
     * @var string
     */
    protected string $base = 'resources/lang';

    /**
     * @param string $lang
     *
     * @return self
     */
    public function __construct(string $lang)
    {
        if ($lang === static::LANG) {
            throw new UnexpectedValueException(sprintf('Language must be different than reference language %s', $lang));
        }

        if (empty(config('services.azure.key'))) {
            throw new UnexpectedValueException('You must set a Microsoft Azure key');
        }

        $this->lang = $lang;
        $this->base = base_path($this->base);
    }

    /**
     * @return void
     */
    public function write(): void
    {
        foreach ($this->files() as $file) {
            $this->translate($file);
        }
    }

    /**
     * @return array
     */
    protected function files(): array
    {
        return glob($this->base.'/'.static::LANG.'/*.php');
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function file(string $name): string
    {
        return $this->base.'/'.$this->lang.'/'.$name;
    }

    /**
     * @param string $reference
     *
     * @return void
     */
    protected function translate(string $reference): void
    {
        $file = $this->file(basename($reference));
        $current = array_dot(is_file($file) ? (require $file) : []);
        $empty = array_filter($current, static fn ($value) => empty($value));
        $strings = array_intersect_key(array_dot(require $reference), $empty);

        if (empty($strings)) {
            return;
        }

        $translated = array_merge($current, array_combine(array_keys($strings), $this->request($strings)));

        $this->writeFile($file, $this->undot($translated));
    }

    /**
     * @param array $strings
     *
     * @return array
     */
    protected function request(array $strings): array
    {
        $response = file_get_contents($this->requestEndpoint(), false, stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => $this->requestHeader(),
                'content' => $this->requestContent($strings),
            ],
        ]));

        return array_map(static fn ($value) => $value->translations[0]->text, json_decode($response));
    }

    /**
     * @return string
     */
    protected function requestEndpoint(): string
    {
        return str_replace([':from', ':to'], [static::LANG, $this->lang], static::ENDPOINT);
    }

    /**
     * @return string
     */
    protected function requestHeader(): string
    {
        return ''
            .'Content-type: application/json'."\r\n"
            .'Ocp-Apim-Subscription-Key: '.config('services.azure.key')."\r\n";
    }

    /**
     * @param array $strings
     *
     * @return string
     */
    protected function requestContent(array $strings): string
    {
        return json_encode(array_map(static fn ($value) => ['Text' => $value], array_values($strings)));
    }
}
