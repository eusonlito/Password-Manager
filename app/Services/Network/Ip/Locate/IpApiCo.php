<?php declare(strict_types=1);

namespace App\Services\Network\Ip\Locate;

use Exception;
use stdClass;

class IpApiCo extends LocateAbstract
{
    /**
     * @const string
     */
    protected const ENDPOINT = 'https://ipapi.co/%s/json/';

    /**
     * @param string $ip
     *
     * @return \stdClass
     */
    public function locate(string $ip): stdClass
    {
        return $this->response($this->request($ip), $ip);
    }

    /**
     * @param string $ip
     *
     * @return ?\stdClass
     */
    protected function request(string $ip): ?stdClass
    {
        return $this->curl(sprintf(static::ENDPOINT, $ip))
            ->setMethod('GET')
            ->send()
            ->getBody('object');
    }

    /**
     * @param ?\stdClass $response
     * @param string $ip
     *
     * @return \stdClass
     */
    protected function response(?stdClass $response, string $ip): stdClass
    {
        if ($response === null) {
            throw new Exception(sprintf('No Locate available to IP %s.', $ip));
        }

        return (object)[
            'ip' => ($response->ip ?? null),
            'city_name' => ($response->city ?? null),
            'region_name' => ($response->region ?? null),
            'region_code' => ($response->region_code ?? null),
            'country_name' => ($response->country_name ?? null),
            'country_code' => ($response->country_code ?? null),
            'latitude' => ($response->latitude ?? null),
            'longitude' => ($response->longitude ?? null),
            'asn' => ($response->asn ?? null),
            'org' => ($response->org ?? null),
        ];
    }
}
