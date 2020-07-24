<?php

namespace Gentor\Freshsales\Api;

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
            'q' => $query,
            'include' => implode(',', $include),
            'per_page' => $perPage,
        ];

        return $this->client->request('get', '/api/search', $options);
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
            'q' => $query,
            'f' => $field,
            'entities' => implode(',', $entities),
        ];

        return $this->client->request('get', '/api/lookup', $options);
    }
}