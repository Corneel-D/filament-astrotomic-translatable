<?php

namespace CorneelD\FilamentAstrotomicTranslatable\Fields;

use Closure;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Tabs;

class TranslatableTabs extends Tabs
{
    /**
     * @param  array<Component> | Closure  $components
     */
    public function schema(array | Closure $components): static
    {
        $tabs = array_map(function ($locale) use ($components) {
            return TranslatableTab::make($locale)
                ->schema($components);
        }, app('translatable.locales')->all());

        return parent::schema($tabs);
    }

    /**
     * @param  array<Field>  $fields
     */
    // public function translatableSchema(array | Closure $components): static
    // {
    //     $tabs = array_map(function ($locale) use ($components) {
    //         $localizedFields = array_map(function (Field $field) use ($locale) {
    //             $localizedField = clone $field;

    //             $localizedField->name("{$locale}.{$field->getName()}");
    //             $localizedField->statePath("{$locale}.{$field->getName()}");
    //             $localizedField->label("{$field->getName()} ({$locale})");

    //             return $localizedField;
    //         }, $components);

    //         $this->contained();

    //         return TranslatableTab::make($locale)
    //             ->schema($localizedFields);
    //     }, app('translatable.locales')->all());

    //     $this->childComponents($tabs);

    //     return $this;
    // }
}
