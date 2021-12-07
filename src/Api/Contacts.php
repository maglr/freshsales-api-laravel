<?php

namespace Gentor\Freshsales\Api;

/**
 * Class Contacts
 * @package Gentor\Freshsales\Api
 */
class Contacts extends Entity
{
    /**
     * @var string
     */
    protected $entityType = 'contact';

    /**
     * @var string
     */
    protected $endPoint = '/api/contacts/';

    /**
     * @param $ids
     * @param int $ownerId
     * @return mixed
     */
    public function assignOwner($ids, int $ownerId)
    {
        $response = $this->client->request('post', $this->endPoint . 'bulk_assign_owner', [
            'json' => [
                'selected_ids' => (array)$ids,
                'owner_id' => $ownerId,
            ],
        ]);

        return json_decode($response->getBody());
    }

    /**
     * @param $id
     * @param array $params
     * @return mixed
     */
    public function activities($id, array $params = [])
    {
        $options = [];
        if (!empty($params)) {
            $options = [
                'query' => $params
            ];
        }

        $response = $this->client->request('get', $this->endPoint . $id . '/activities', $options);

        return json_decode($response->getBody());
    }
}
