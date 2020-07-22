<?php

namespace Gentor\Freshsales;

use Illuminate\Support\Facades\Facade;

/**
 * Class Freshsales
 *
 * @package Gentor\Freshsales
 * @see \Gentor\Freshsales\FreshsalesService
 */
class Freshsales extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'freshsales';
    }
}
