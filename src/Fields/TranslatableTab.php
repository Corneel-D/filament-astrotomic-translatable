<?php

namespace CorneelD\FilamentAstrotomicTranslatable\Fields;

use Closure;
use Filament\Forms\Components\Tabs\Tab;

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
        $components = $this->evaluate($components);

        $localizedComponents = array_map(function ($component) {
            if (!property_exists($component, 'translatable') || !$component->translatable) {
                return $component;
            }

            $locale = $this->getLocale();

            $localizedComponent = clone $component;

            $localizedComponent->name("{$locale}.{$component->getName()}");
            $localizedComponent->statePath("{$locale}.{$component->getName()}");
            $localizedComponent->label("{$component->getLabel()} ({$locale})");

            return $localizedComponent;
        }, $components);

        $this->childComponents($localizedComponents);

        return $this;
    }
}
