<?php

namespace Gentor\Freshsales;

use Gentor\Freshsales\Api\Accounts;
use Gentor\Freshsales\Api\Client;
use Gentor\Freshsales\Api\Config;
use Gentor\Freshsales\Api\Contacts;
use Gentor\Freshsales\Api\Deals;
use Gentor\Freshsales\Api\Leads;
use Gentor\Freshsales\Api\Search;

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
        $this->client = new Client($config);
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