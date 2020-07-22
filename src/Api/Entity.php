<?php

namespace Gentor\Freshsales\Api;

use GuzzleHttp\Client;

/**
 * Class Entity
 * @package Gentor\Freshsales\Api
 */
abstract class Entity
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $entityType;

    /**
     * @var string
     */
    protected $endPoint;

    /**
     * Entity constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $attributes
     * @param array $customFields
     * @return mixed
     */
    public function create(array $attributes, array $customFields = [])
    {
        if (!empty($customFields)) {
            $attributes['custom_field'] = $this->prefixCustomFields($customFields);
        }

        $response = $this->client->post($this->endPoint, [
            'json' => [$this->entityType => $attributes],
        ]);

        return json_decode($response->getBody());
    }

    /**
     * @param $id
     * @param array $attributes
     * @param array $customFields
     * @return mixed
     */
    public function update($id, array $attributes, array $customFields = [])
    {
        if (!empty($customFields)) {
            $attributes['custom_field'] = $this->prefixCustomFields($customFields);
        }

        $response = $this->client->put($this->endPoint . $id, [
            'json' => [$this->entityType => $attributes],
        ]);

        return json_decode($response->getBody());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $response = $this->client->delete($this->endPoint . $id);

        return json_decode($response->getBody());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function forget($id)
    {
        $response = $this->client->delete($this->endPoint . $id . '/forget');

        return json_decode($response->getBody());
    }

    /**
     * @param array $ids
     * @param array $params
     * @return mixed
     */
    public function bulkDelete(array $ids, array $params = [])
    {
        $options = [
            'json' => ['selected_ids' => $ids],
        ];

        if (!empty($params)) {
            $options['json'] = array_merge($options['json'], $params);
        }

        $response = $this->client->post($this->endPoint . 'bulk_destroy', $options);

        return json_decode($response->getBody());
    }

    /**
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function clone($id, array $attributes = [])
    {
        $options = [];
        if (!empty($attributes)) {
            $options = [
                'json' => [$this->entityType => $attributes],
            ];
        }

        $response = $this->client->post($this->endPoint . $id . '/clone', $options);

        return json_decode($response->getBody());
    }

    /**
     * @param $id
     * @param array $include
     * @return mixed
     */
    public function get($id, array $include = [])
    {
        $options = [];
        if (!empty($include)) {
            $options = [
                'query' => [
                    'include' => implode(',', $include),
                ],
            ];
        }

        $response = $this->client->get($this->endPoint . $id, $options);

        return json_decode($response->getBody());
    }

    /**
     * @param $viewId
     * @param array $params
     * @return mixed
     */
    public function list($viewId, array $params = [])
    {
        $options = [];
        if (!empty($params)) {
            $options = [
                'query' => $params
            ];
        }

        $response = $this->client->get($this->endPoint . 'view/' . $viewId, $options);

        return json_decode($response->getBody());
    }

    /**
     * @param string $attribute
     * @param string $operator
     * @param $value
     * @param int $limit
     * @return mixed
     */
    public function filter(string $attribute, string $operator, $value, int $limit = 10)
    {
        $options = [
            'json' => [
                'filter_rule' => [
                    [
                        'attribute' => $this->entityType . '_' . $attribute . '.' . $attribute,
                        'operator' => $operator,
                        'value' => $value,
                    ]
                ],
                'per_page' => $limit,
            ],
        ];

        $uri = '/api/filtered_search/' . $this->entityType;
        $response = $this->client->post($uri, $options);

        return json_decode($response->getBody());
    }

    /**
     * @param string $query
     * @param string $field
     * @return mixed
     */
    public function lookup(string $query, string $field)
    {
        $search = new Search($this->client);

        return $search->lookup($query, $field, [$this->entityType]);
    }

    /**
     * @return mixed
     */
    public function filters()
    {
        $response = $this->client->get($this->endPoint . 'filters');

        return json_decode($response->getBody());
    }

    /**
     * @param bool $includeGroup
     * @return mixed
     */
    public function fields($includeGroup = false)
    {
        $options = [];
        if ($includeGroup) {
            $options = [
                'query' => ['include' => 'field_group']
            ];
        }

        $uri = str_replace('/api/', '/api/settings/', $this->endPoint) . 'fields';

        $response = $this->client->get($uri, $options);

        return json_decode($response->getBody());
    }

    /**
     * @param array $customFields
     * @return array
     */
    protected function prefixCustomFields(array $customFields)
    {
        $fields = [];
        foreach ($customFields as $field => $value) {
            $fields['cf_' . $field] = $value;
        }

        return $fields;
    }
}