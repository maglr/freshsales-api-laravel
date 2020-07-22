<?php

namespace Gentor\Freshsales\Api;

/**
 * Class Deals
 * @package Gentor\Freshsales\Api
 */
class Deals extends Entity
{
    /**
     * @var string
     */
    protected $entityType = 'deal';

    /**
     * @var string
     */
    protected $endPoint = '/api/deals/';
}