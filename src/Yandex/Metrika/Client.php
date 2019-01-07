<?php

namespace Ffcms\Yandex\Metrika;


use Ffcms\Yandex\Metrika\Network\MetrikaHeaders;
use Ffcms\Yandex\Metrika\Network\Request;

/**
 * Class Client. Yandex metrika statistics client for ffcms
 * @package Ffcms\Yandex\Metrika
 */
class Client
{
    private $headers;

    /**
     * Client constructor. Initialize client with connection properties
     * @param string $token
     * @param int $counterId
     */
    public function __construct(string $token, int $counterId)
    {
        $this->headers = new MetrikaHeaders($token, $counterId);
    }

    public function getCountersList()
    {
        $request = new Request($this->headers, [], Request::API_COUNTERS);
        $query = $request->getResponse();
    }
}