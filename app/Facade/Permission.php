<?php

namespace App\Facade;

use App\Http\Components\Classes\Permission as PermissionClass;
use Illuminate\Support\Facades\Facade;

class Permission extends Facade{

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return PermissionClass::class;
    }

}