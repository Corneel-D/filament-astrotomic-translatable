<?php

namespace CorneelD\FilamentAstrotomicTranslatable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CorneelD\FilamentAstrotomicTranslatable\FilamentAstrotomicTranslatable
 */
class FilamentAstrotomicTranslatable extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \CorneelD\FilamentAstrotomicTranslatable\FilamentAstrotomicTranslatable::class;
    }
}
