<?php

namespace CorneelD\FilamentAstrotomicTranslatable;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentAstrotomicTranslatablePlugin implements Plugin
{
    protected array $defaultActiveLocales = [];

    public function getId(): string
    {
        return 'filament-astrotomic-translatable';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function getDefaultActiveLocales(): array
    {
        return $this->defaultActiveLocales;
    }

    public function setDefaultActiveLocales(array $defaultActiveLocales): static
    {
        $this->defaultActiveLocales = $defaultActiveLocales;

        return $this;
    }
}
