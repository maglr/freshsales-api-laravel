<?php

namespace Gentor\Freshsales\Api;

/**
 * Class Config
 *
 * @method mixed owners()
 * @method mixed territories()
 * @method mixed deal_stages()
 * @method mixed currencies()
 * @method mixed deal_reasons()
 * @method mixed deal_types()
 * @method mixed lead_sources()
 * @method mixed industry_types()
 * @method mixed business_types()
 * @method mixed campaigns()
 * @method mixed deal_payment_statuses()
 * @method mixed deal_products()
 * @method mixed deal_pipelines()
 * @method mixed contact_statuses()
 * @method mixed sales_activity_types()
 * @method mixed sales_activity_outcomes()
 * @method mixed sales_activity_entity_types()
 *
 * @package Gentor\Freshsales\Api
 */
class Config
{
    /**
     * @var string
     */
    protected $endPoint = '/api/selector/';

    /**
     * @var Client
     */
    protected $client;

    /**
     * Config constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return $this->get($method);
    }

    /**
     * @param string $api
     * @return mixed
     */
    public function get(string $api)
    {
        return $this->client->request('get', $this->endPoint . $api);
    }
}