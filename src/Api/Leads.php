<?php

namespace Gentor\Freshsales\Api;

/**
 * Class Leads
 * @package Gentor\Freshsales\Api
 */
class Leads extends Contacts
{
    /**
     * @var string
     */
    protected $entityType = 'lead';

    /**
     * @var string
     */
    protected $endPoint = '/api/leads/';

    /**
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function convert($id, array $attributes)
    {
        return $this->client->request(
            'post',
            $this->endPoint . $id . '/convert',
            [$this->entityType => $attributes]
        );
    }
}