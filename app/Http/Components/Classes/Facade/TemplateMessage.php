<?php

namespace App\Http\Components\Classes\Facade;

use App\Http\Components\Classes\TemplateMessage as Message;
use Illuminate\Support\Facades\Facade;

class TemplateMessage extends Facade{

    /**
     * Impalment Facade 
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor()
    {
        return Message::class;
    }
}