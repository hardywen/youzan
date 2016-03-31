<?php

namespace Hardywen\Youzan\Facades;


use Illuminate\Support\Facades\Facade;

class Youzan extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'youzan';
    }

}