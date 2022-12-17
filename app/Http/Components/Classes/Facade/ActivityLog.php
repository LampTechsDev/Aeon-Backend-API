<?php

namespace App\Http\Components\Classes\Facade;

use App\Http\Components\Classes\ActivityLog as Activity;
use Illuminate\Support\Facades\Facade;

class ActivityLog extends Facade{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @method  save($request, $message)
     * @method  model($model)
     * @method  user($user)
     */
    protected static function getFacadeAccessor()
    {
        return Activity::class;
    }
}