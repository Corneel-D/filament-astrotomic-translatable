<?php

namespace CorneelD\FilamentAstrotomicTranslatable\Resources\Concerns;

use Astrotomic\Translatable\Translatable as TranslatableModel;
use Exception;

trait Translatable
{
    public static function getDefaultTranslatableLocale(): string
    {
        return config('translatable.locale') ?: app()->getLocale();
    }

    public static function getTranslatableAttributes(): array
    {
        $model = static::getModel();

        if (! method_exists($model, 'getTranslatableAttributes')) {
            throw new Exception("Model [{$model}] must use trait [" . TranslatableModel::class . '].');
        }

        $attributes = app($model)->translatedAttributes;

        if (! count($attributes)) {
            throw new Exception("Model [{$model}] must have [\$translatedAttributes] properties defined.");
        }

        return $attributes;
    }

    public static function getTranslatableLocales(): array
    {
        return app('translatable.locales')->all();
    }
}
