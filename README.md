# Work with module prom_ua

**1.**
```php
composer require softce/statistic
```


**2.**
```php
//in console write

composer update softce/statistic
```


**3.**
```php
//in service provider config/app

'providers' => [
    ... ,
    Softce\Statistic\StatisticServiceProvider::class,
]


// in console 
php artisan config:cache
```


**4.**
```php
//for show page price ua, in code add next row

{{ route('admin.statistic') }}

```

# For delete module

```php
//delete next row

1.
//in app.php
Softce\Statistic\StatisticServiceProvider::class,

2.
//in console
composer remove softce/statistic

3.
// delete -> bootstrap/config/cache.php

4.
//in console
php artisan config:cache

5.
//delete row in admin_menus table -> where name 'Статистика товаров'
```

