<?php

namespace Gentor\Freshsales\Api;

use GuzzleHttp\Client;

/**
 * Class Search
 * @package Gentor\Freshsales\Api
 */
class Search
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Search constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $query
     * @param array $include
     * @param int $perPage
     * @return mixed
     */
    public function query(string $query, array $include, int $perPage = 25)
    {
        $options = [
            'query' => [
                'q' => $query,
                'include' => implode(',', $include),
                'per_page' => $perPage,
            ],
        ];

        $response = $this->client->get('/api/search', $options);

        return json_decode($response->getBody());
    }

    /**
     * @param string $query
     * @param string $field
     * @param array $entities
     * @return mixed
     */
    public function lookup(string $query, string $field, array $entities)
    {
        $options = [
            'query' => [
                'q' => $query,
                'f' => $field,
                'entities' => implode(',', $entities),
            ],
        ];

        $response = $this->client->get('/api/lookup', $options);

        return json_decode($response->getBody());
    }
}