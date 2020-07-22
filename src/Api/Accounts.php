<?php

namespace Gentor\Freshsales\Api;

/**
 * Class Accounts
 * @package Gentor\Freshsales\Api
 */
class Accounts extends Entity
{
    /**
     * @var string
     */
    protected $entityType = 'sales_account';

    /**
     * @var string
     */
    protected $endPoint = '/api/sales_accounts/';
}