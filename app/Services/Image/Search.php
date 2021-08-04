<?php declare(strict_types=1);

namespace App\Services\Image;

use App\Services\Http\Curl\Curl;

class Search
{
    /**
     * @var string
     */
    protected string $search;

    /**
     * @param string $search
     *
     * @return self
     */
    public function __construct(string $search)
    {
        $this->search = $search;
    }

    /**
     * @return array
     */
    public function search(): array
    {
        return $this->matches($this->curl());
    }

    /**
     * @return string
     */
    protected function curl(): string
    {
        return (new Curl())
            ->setUrl('https://www.google.com/search')
            ->setQuery($this->curlQuery())
            ->setLog(true)
            ->setCache(3600)
            ->setTimeout(10)
            ->send()
            ->getBody();
    }

    /**
     * @return array
     */
    protected function curlQuery(): array
    {
        return [
            'q' => $this->search,
            'as_st' => 'y',
            'tbm' => 'isch',
            'tbs' => 'iar:s,ift:png',
        ];
    }

    /**
     * @param string $html
     *
     * @return array
     */
    protected function matches(string $html): array
    {
        preg_match_all('/\[\\"([^\\"]+\.png)\",[0-9]+,[0-9]+\]/', $html, $matches);

        return $matches[1];
    }
}
