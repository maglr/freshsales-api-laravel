Freshsales API
==========

Wrapper on the REST Freshsales API for Laravel

Installation
------------

Installation using composer:

```
composer require maglr/freshsales-api-laravel
```

Configuration
-------------

Change your default settings in `app/config/freshsales.php`:

```php
return [
    'domain' => env('FRESHSALES_DOMAIN'),
    'api_key' => env('FRESHSALES_APIKEY'),
    'enable_rate_limit' => env('FRESHSALES_ENABLE_RATE_LIMIT'),
];
```

Usage
-----

* [Leads](https://www.freshsales.io/api/#leads)

```php
Freshsales::leads()->create();
Freshsales::leads()->get();
Freshsales::leads()->convert();
Freshsales::leads()->list();
Freshsales::leads()->update();
Freshsales::leads()->assignOwner();
Freshsales::leads()->clone();
Freshsales::leads()->delete();
Freshsales::leads()->forget();
Freshsales::leads()->bulkDelete();
Freshsales::leads()->fields();
Freshsales::leads()->activities();
Freshsales::leads()->filters();
Freshsales::leads()->filter();
Freshsales::leads()->lookup();
```

* [Contacts](https://www.freshsales.io/api/#contacts)

```php
Freshsales::contacts()->create();
Freshsales::contacts()->get();
Freshsales::contacts()->list();
Freshsales::contacts()->update();
Freshsales::contacts()->assignOwner();
Freshsales::contacts()->clone();
Freshsales::contacts()->delete();
Freshsales::contacts()->forget();
Freshsales::contacts()->bulkDelete();
Freshsales::contacts()->fields();
Freshsales::contacts()->activities();
Freshsales::contacts()->filters();
Freshsales::contacts()->filter();
Freshsales::contacts()->lookup();
```

* [Accounts](https://www.freshsales.io/api/#accounts)

```php
Freshsales::accounts()->create();
Freshsales::accounts()->get();
Freshsales::accounts()->list();
Freshsales::accounts()->update();
Freshsales::accounts()->clone();
Freshsales::accounts()->delete();
Freshsales::accounts()->forget();
Freshsales::accounts()->bulkDelete();
Freshsales::accounts()->fields();
Freshsales::accounts()->filters();
Freshsales::accounts()->filter();
Freshsales::accounts()->lookup();
```

* [Deals](https://www.freshsales.io/api/#deals)

```php
Freshsales::deals()->create();
Freshsales::deals()->get();
Freshsales::deals()->list();
Freshsales::deals()->update();
Freshsales::deals()->clone();
Freshsales::deals()->delete();
Freshsales::deals()->forget();
Freshsales::deals()->bulkDelete();
Freshsales::deals()->fields();
Freshsales::deals()->filters();
Freshsales::deals()->filter();
Freshsales::deals()->lookup();
```

* [Search](https://www.freshsales.io/api/#search)

```php
Freshsales::search()->query();
Freshsales::search()->lookup();
```

* [Configuration](https://www.freshsales.io/api/#admin_configuration)

```php
Freshsales::config()->owners();
Freshsales::config()->territories();
Freshsales::config()->deal_stages();
Freshsales::config()->currencies();
Freshsales::config()->deal_reasons();
Freshsales::config()->deal_types();
Freshsales::config()->lead_sources();
Freshsales::config()->industry_types();
Freshsales::config()->business_types();
Freshsales::config()->campaigns();
Freshsales::config()->deal_payment_statuses();
Freshsales::config()->deal_products();
Freshsales::config()->deal_pipelines();
Freshsales::config()->contact_statuses();
Freshsales::config()->sales_activity_types();
Freshsales::config()->sales_activity_outcomes();
Freshsales::config()->sales_activity_entity_types();
Freshsales::config()->get($api);
```

* Client - Inspired from [ianfortier/Basic-Freshsales-API](https://github.com/ianfortier/Basic-Freshsales-API)

```php
Freshsales::client()->request();
Freshsales::client()->isRateLimitEnabled();
Freshsales::client()->enableRateLimit();
Freshsales::client()->disableRateLimit();
Freshsales::client()->getApiCallLimits();
```

Documentation
-------------

[Freshsales API Docs](https://www.freshsales.io/api/)
