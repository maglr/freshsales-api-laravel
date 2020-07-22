<?php

namespace Gentor\Freshsales;

use Gentor\Freshsales\Api\Accounts;
use Gentor\Freshsales\Api\Config;
use Gentor\Freshsales\Api\Contacts;
use Gentor\Freshsales\Api\Deals;
use Gentor\Freshsales\Api\Leads;
use Gentor\Freshsales\Api\Search;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;

/**
 * Class FreshsalesService
 *
 * @package Gentor\Freshsales
 */
class FreshsalesService
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * FreshsalesService constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->client = new Client(
            [
                'base_uri' => "https://{$config['domain']}",
                'headers' => [
                    'Authorization' => "Token token=" . $config['api_key'],
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]
        );
    }

    /**
     * @param string $method
     * @param string $path
     * @param array|null $params
     * @param array $headers
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $method, string $path, array $params = null, array $headers = [])
    {
        $uri = $this->getBaseUri()->withPath($path);

        // Build the request parameters for Guzzle
        $guzzleParams = [];
        if ($params !== null) {
            $guzzleParams[strtoupper($method) === 'GET' ? 'query' : 'json'] = $params;
        }

        // Add custom headers
        if (!empty($headers)) {
            $guzzleParams['headers'] = $headers;
        }

        return json_decode($this->client->request($method, $uri, $guzzleParams)->getBody());
    }

    /**
     * @return \GuzzleHttp\Psr7\Uri
     */
    public function getBaseUri()
    {
        return new Uri($this->client->getConfig('base_uri'));
    }

    /**
     * @return \Gentor\Freshsales\Api\Leads
     */
    public function leads()
    {
        return new Leads($this->client);
    }

    /**
     * @return \Gentor\Freshsales\Api\Contacts
     */
    public function contacts()
    {
        return new Contacts($this->client);
    }

    /**
     * @return \Gentor\Freshsales\Api\Accounts
     */
    public function accounts()
    {
        return new Accounts($this->client);
    }

    /**
     * @return \Gentor\Freshsales\Api\Deals
     */
    public function deals()
    {
        return new Deals($this->client);
    }

    /**
     * @return \Gentor\Freshsales\Api\Search
     */
    public function search()
    {
        return new Search($this->client);
    }

    /**
     * @return \Gentor\Freshsales\Api\Config
     */
    public function config()
    {
        return new Config($this->client);
    }
}