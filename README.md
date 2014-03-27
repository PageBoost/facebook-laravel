Facebook PHP SDK for Laravel 4.1
============================

Facebook PHP SDK wrapper package with Facebook Connect support through Laravel Session.

Most Facebook wrapper packages for Laravel just bootstrap the Facebook class from SDK which use PHP native session and cookies. Native PHP session is ok, but not usable in load balanced applications.

Moreover Laravel works only with encrypted cookies which increase application security. You can change your session provider to Redis, memcached or whatever and this will not break your Facebook Login integration!

___

## Installation

Begin by installing this package through Composer.

```js
{
    "require": {
        "PageBoost/facebook-laravel": "dev-master"
    }
}
```

Open  `app/config/app.php` and add following Service Provider and Facade

```php
// Provider
'providers' => array(
    'PageBoost\FacebookLaravel\FacebookServiceProvider',
)
// Facade
'aliases' => array(
    'FB' => 'PageBoost\FacebookLaravel\Facades\LaravelFacebook',
)
```

## Configuration

- Publish package configs `php artisan config:publish pageboost/facebook-laravel`
- Customize `config.php` with your information

Setting details are.

- `appId`: Your facebook app id.
- `secret`: Your facebook app secret.
- `laravelDebug`: Indicates if api calls and internal `BaseFacebook` errors should be logged in `laravel.log`
- `allowSignedRequest`: Indicates if signed_request is allowed in query parameters.
- `fileUpload`: Indicates if the CURL based @ syntax for file uploads is enabled.
- `trustForwarded`: // Indicates if we trust HTTP_X_FORWARDED_* headers.

## License

[View the license](https://github.com/PageBoost/facebook-laravel/blob/master/LICENSE) for this repo.