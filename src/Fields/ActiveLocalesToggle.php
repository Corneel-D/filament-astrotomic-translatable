<?php

namespace CorneelD\FilamentAstrotomicTranslatable\Fields;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Toggle;

class ActiveLocalesToggle extends Fieldset
{
    private array $defaultActiveLocales = [];

    protected function setUp(): void
    {
        $this->defaultActiveLocales = $this->getDefaultActiveLocales();

        parent::setUp();
        $this->columnSpan('full');

        $locales = app('translatable.locales')->all();
        $this->columns(count($locales) > 3 ? 1 : count($locales));

        $this->label(trans('filament-astrotomic-translatable::fields.active_locales.label'));

        // TODO way to configure default active locales

        $localeToggles = array_map(function ($locale) {
            return Toggle::make($locale)
                ->onColor('success')
                ->statePath("{$locale}.active")
                ->default($this->localeIsActive($locale));
        }, $locales);

        $this->schema($localeToggles);
    }

    protected function localeIsActive(string $locale): bool
    {
        if (empty($this->defaultActiveLocales)) {
            return true;
        }

        return in_array($locale, $this->defaultActiveLocales);
    }

    protected function getDefaultActiveLocales(): array
    {
        /** @var \CorneelD\FilamentAstrotomicTranslatable\FilamentAstrotomicTranslatablePlugin $plugin */
        $plugin = filament('filament-astrotomic-translatable');

        return $plugin->getDefaultActiveLocales();
    }
}
