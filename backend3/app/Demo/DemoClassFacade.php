<?php
namespace App\Demo;

use Illuminate\Support\Facades\Facade;

class DemoClassFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'democlass';
    }
}
