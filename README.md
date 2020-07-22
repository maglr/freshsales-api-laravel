Freshsales API
==========

Wrapper on the REST Freshsales API for Laravel

Installation
------------

Installation using composer:

```
composer require gentor/freshsales-api-laravel
```

Configuration
-------------

Change your default settings in `app/config/freshsales.php`:

```php
return [
    'domain' => env('FRESHSALES_DOMAIN'),
    'api_key' => env('FRESHSALES_APIKEY'),
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

Documentation
-------------

[Freshsales API Docs](https://www.freshsales.io/api/)
