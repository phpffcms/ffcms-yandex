<?php

namespace Ffcms\Yandex\Network;


/**
 * Class Request. Networking smooth client
 * @package Network
 */
class Request
{
    /**
     * Make remote query
     * @param string $url
     * @param array|null $headers
     * @return string|null
     */
    public static function get(string $url, ?array $headers = null): ?string
    {
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        if ($headers) {
            curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handle);

        return $response;
    }
}