<?php

namespace Gentor\Freshsales\Api;

/**
 * Class Entity
 * @package Gentor\Freshsales\Api
 */
abstract class Entity
{
    /**
     * @var string
     */
    protected $entityType;

    /**
     * @var string
     */
    protected $endPoint;

    /**
     * @var Client
     */
    protected $client;
    
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

        return $this->client->request('post', $this->endPoint, [$this->entityType => $attributes]);
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

        return $this->client->request('put', $this->endPoint . $id, [$this->entityType => $attributes]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->client->request('delete', $this->endPoint . $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function forget($id)
    {
        return $this->client->request('delete', $this->endPoint . $id . '/forget');
    }

    /**
     * @param array $ids
     * @param array $params
     * @return mixed
     */
    public function bulkDelete(array $ids, array $params = [])
    {
        $options = ['selected_ids' => $ids];

        if (!empty($params)) {
            $options = array_merge($options, $params);
        }

        return $this->client->request('post', $this->endPoint . 'bulk_destroy', $options);
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
            $options = [$this->entityType => $attributes];
        }

        return $this->client->request('post', $this->endPoint . $id . '/clone', $options);
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
                'include' => implode(',', $include),
            ];
        }

        return $this->client->request('get', $this->endPoint . $id, $options);
    }

    /**
     * @param $viewId
     * @param array $params
     * @return mixed
     */
    public function list($viewId, array $params = [])
    {
        return $this->client->request('get', $this->endPoint . 'view/' . $viewId, $params);
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
            'filter_rule' => [
                [
                    'attribute' => $this->entityType . '_' . $attribute . '.' . $attribute,
                    'operator' => $operator,
                    'value' => $value,
                ]
            ],
            'per_page' => $limit,
        ];

        $uri = '/api/filtered_search/' . $this->entityType;

        return $this->client->request('post', $uri, $options);
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
        return $this->client->request('get', $this->endPoint . 'filters');
    }

    /**
     * @param bool $includeGroup
     * @return mixed
     */
    public function fields($includeGroup = false)
    {
        $options = [];
        if ($includeGroup) {
            $options = ['include' => 'field_group'];
        }

        $uri = str_replace('/api/', '/api/settings/', $this->endPoint) . 'fields';

        return $this->client->request('get', $uri, $options);
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