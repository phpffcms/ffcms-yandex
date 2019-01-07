<?php

namespace Ffcms\Yandex\Metrika\Network;


/**
 * Class MetrikaHeaders. Header holder instance
 * @package Metrika\Network
 */
class MetrikaHeaders
{
    private $token;
    private $counterId;

    /**
     * MetrikaHeaders constructor.
     * @param string $token
     * @param int $counterId
     */
    public function __construct(string $token, int $counterId)
    {
        $this->token = $token;
        $this->counterId = $counterId;
    }

    /**
     * Make headers like factory
     * @param string $token
     * @param int $counterId
     * @return MetrikaHeaders
     */
    public static function factory(string $token, int $counterId)
    {
        return new self($token, $counterId);
    }

    /**
     * Get oauth token
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get counter id
     * @return int
     */
    public function getCounterId()
    {
        return $this->counterId;
    }
}