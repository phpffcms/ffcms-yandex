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

    /**
     * Get counter_id -> site_url
     * @return array|null
     */
    public function getCountersList(): ?array
    {
        $request = new Request($this->headers, [], Request::API_COUNTERS);
        $query = $request->getResponse();

        $response = json_decode($query);
        if (!$response) {
            return null;
        }

        $result = [];
        foreach ($response->counters as $counter) {
            $result[$counter->id] = $counter->site;
        }

        return $result;
    }

    /**
     * Get 30 day statistics - visits, views, bounceRate
     * @return array|null
     * @example https://api-metrika.yandex.net/stat/v1/data/bytime?metrics=ym:s:pageviews,ym:s:users,ym:s:bounceRate&id=44147844&group=day&date1=30daysAgo&date2=today
     */
    public function getVisits30days(): ?array
    {
        $request = new Request($this->headers, [
            'metrics' => 'ym:s:pageviews,ym:s:users,ym:s:bounceRate',
            'group' => 'day',
            'date1' => '30daysAgo',
            'date2' => 'today'
        ], Request::API_STAT . '/bytime');
        $query = $request->getResponse();

        $response = json_decode($query);
        if (!$response || !$response->data) {
            return null;
        }

        $result = [];
        // metrics: 0 = pageviews, 1 = users, 2 = bounce rate
        foreach ($response->data[0]->metrics[0] as $idx => $views) {
            $date = $response->time_intervals[$idx][0];
            $result[$date] = [
                'users' => (int)$response->data[0]->metrics[1][$idx],
                'views' => $views,
                'bounce' => (float)$response->data[0]->metrics[2][$idx]
            ];
        }

        return $result;
    }

    /**
     * Get 30 day summary visit sources (search engines, direct, links, etc)
     * @example https://api-metrika.yandex.net/stat/v1/data?metrics=ym:s:users&dimensions=ym:s:trafficSource&id=44147844&date1=30daysAgo&date2=today
     * @return array|null
     */
    public function getSourcesSummary30days(): ?array
    {
        $request = new Request($this->headers, [
            'metrics' => 'ym:s:users',
            'dimensions' => 'ym:s:trafficSource',
            'date1' => '30daysAgo',
            'date2' => 'today'
        ], Request::API_STAT);

        $query = $request->getResponse();
        $response = json_decode($query);
        if (!$response || !$response->data) {
            return null;
        }

        $result = [];
        foreach ($response->data as $data) {
            $result[$data->dimensions[0]->name] = (int)$data->metrics[0];
        }
        return $result;
    }
}