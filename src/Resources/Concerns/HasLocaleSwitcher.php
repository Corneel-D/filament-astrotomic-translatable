<?php

namespace CorneelD\FilamentAstrotomicTranslatable\Resources\Concerns;

use CorneelD\FilamentAstrotomicTranslatable\FilamentAstrotomicTranslatableContentDriver;
use Filament\Support\Contracts\TranslatableContentDriver;

trait HasLocaleSwitcher
{
    public ?string $activeLocale = null;

    /**
     * @return class-string<TranslatableContentDriver> | null
     */
    public function getFilamentTranslatableContentDriver(): ?string
    {
        return FilamentAstrotomicTranslatableContentDriver::class;
    }
}
