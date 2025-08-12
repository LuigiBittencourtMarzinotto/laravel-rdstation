<?php

namespace LuigiBittencourtMarzinotto\RDStation\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LuigiBittencourtMarzinotto\RDStation\RDStation
 */
class RDStation extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \LuigiBittencourtMarzinotto\RDStation\RDStation::class;
    }
}
