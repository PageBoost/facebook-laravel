<?php
namespace PageBoost\FacebookLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelFacebook extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'facebook-laravel';
    }
}
