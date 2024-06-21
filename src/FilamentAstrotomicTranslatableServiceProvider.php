<?php

namespace CorneelD\FilamentAstrotomicTranslatable;

use CorneelD\FilamentAstrotomicTranslatable\Commands\FilamentAstrotomicTranslatableCommand;
use CorneelD\FilamentAstrotomicTranslatable\Testing\TestsFilamentAstrotomicTranslatable;
use Filament\Forms\Components\Field;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentAstrotomicTranslatableServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-astrotomic-translatable';

    public static string $viewNamespace = 'filament-astrotomic-translatable';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('corneel-d/filament-astrotomic-translatable');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/filament-astrotomic-translatable/{$file->getFilename()}"),
                ], 'filament-astrotomic-translatable-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsFilamentAstrotomicTranslatable());

        Field::macro('translatable', function () {
            /** @var Field $this */

            $this->translatable = true;

            return $this;
        });

        Blueprint::macro('defaultTranslationsTableFields', function (string $tableNameSingular, bool $softDeletes = true, $withActive = true) {
            /** @var Blueprint $this */
            $this->id();
            $this->foreignId("{$tableNameSingular}_id")->constrained()->cascadeOnDelete();

            $this->string('locale', 7)->index();
            if ($withActive) {
                $this->boolean('active')->default(true);
            }

            $this->unique(["{$tableNameSingular}_id", 'locale'], "{$tableNameSingular}_id_locale_unique");

            $this->timestamps();
            if ($softDeletes) {
                $this->softDeletes();
            }
        });
    }

    protected function getAssetPackageName(): ?string
    {
        return 'corneel-d/filament-astrotomic-translatable';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('filament-astrotomic-translatable', __DIR__ . '/../resources/dist/components/filament-astrotomic-translatable.js'),
            Css::make('filament-astrotomic-translatable-styles', __DIR__ . '/../resources/dist/filament-astrotomic-translatable.css'),
            Js::make('filament-astrotomic-translatable-scripts', __DIR__ . '/../resources/dist/filament-astrotomic-translatable.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            FilamentAstrotomicTranslatableCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [];
    }
}
