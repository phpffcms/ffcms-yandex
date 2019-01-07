<?php

namespace Ffcms\Yandex\Metrika\Network;


use Ffcms\Yandex\Network\Request as NativeRequest;
use Ffcms\Yandex\Metrika\Network\MetrikaHeaders;

/**
 * Class Request. Request client for yandex metrika with special features
 * @package Ffcms\Yandex\Metrika\Network
 */
class Request extends NativeRequest
{
    const API_BASE = 'https://api-metrika.yandex.net/';
    const API_STAT = 'stat/v1/data';
    const API_COUNTERS = 'management/v1/counters';

    /** @var array */
    private $params;
    /** @var MetrikaHeaders */
    private $headers;
    private $type;

    /**
     * Request constructor.
     * @param \Ffcms\Yandex\Metrika\Network\MetrikaHeaders $headers
     * @param array $params
     * @param string $type
     */
    public function __construct(MetrikaHeaders $headers, array $params, string $type = self::API_STAT)
    {
        $this->headers = $headers;
        $this->params = $params;
        $this->type = $type;

        $this->params['id'] = $headers->getCounterId();
    }

    /**
     * Make get request based on passed params on construct
     * @return string|null
     */
    public function getResponse(): ?string
    {
        $url = static::API_BASE . $this->type . '?' . http_build_query($this->params);
        $headers = ['Authorization: OAuth ' . $this->headers->getToken()];

        var_dump($headers);
        return null;

        return self::get($url, $headers);
    }
}