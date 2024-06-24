<?php

namespace CorneelD\FilamentAstrotomicTranslatable\Fields;

use Astrotomic\Translatable\Contracts\Translatable;
use Closure;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Model;

class TranslatableTab extends Tab
{
    public function getLocale(): ?string
    {
        return $this->evaluate($this->id);
    }

    /**
     * @param  array<Component> | Closure  $components
     */
    public function schema(array | Closure $components): static
    {
        $localizedComponents = function (Component $component) use ($components) {
            $this->evaluate($components);

            $model = $component->getModelInstance();
            if (! $model instanceof Translatable) {
                return $components;
            }

            $localizedComponents = array_map(function ($component) use ($model) {
                if (! $component instanceof Field
                    || ! $model->isTranslationAttribute($component->getName())
                ) {
                    return $component;
                }

                $locale = $this->getLocale();

                $localizedComponent = clone $component;

                $localizedComponent->name("{$locale}.{$component->getName()}");
                $localizedComponent->statePath("{$locale}.{$component->getName()}");
                $localizedComponent->label("{$component->getLabel()} ({$locale})");

                return $localizedComponent;
            }, $components);

            return $localizedComponents;
        };

        $this->childComponents($localizedComponents);

        return $this;
    }
}
