<?php

namespace CorneelD\FilamentAstrotomicTranslatable\Fields;

use Closure;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Support\Concerns\CanBeContained;
use Filament\Support\Concerns\HasExtraAlpineAttributes;

class TranslatableField extends Component
{
    use CanBeContained;
    use HasExtraAlpineAttributes;

    /**
     * @var view-string
     */
    protected string $view = 'filament-astrotomic-translatable::localization-tabs';

    protected int | Closure $activeTab = 1;

    public static function make(?Field $field = null): static
    {
        $static = app(static::class);
        $static->configure();

        if ($field !== null) {
            $static->field($field);
        }

        return $static;
    }

    public function field(Field $field): static
    {
        $this->fields([$field]);

        return $this;
    }

    /**
     * @param  array<Field>  $fields
     * @return static
     */
    protected function fields(array $fields): static
    {
        $tabs = array_map(function ($locale) use ($fields) {
            $localizedFields = array_map(function (Field $field) use ($locale) {
                $localizedField = clone $field;

                $localizedField->name("{$field->getName()} ({$locale})");
                $localizedField->statePath("{$locale}.{$field->getName()}");

                return $localizedField;
            }, $fields);

            return Tab::make($locale)
                ->schema($localizedFields);
        }, app('translatable.locales')->all());

        $this->childComponents($tabs);

        return $this;
    }

    public function activeTab(int | Closure $activeTab): static
    {
        $this->activeTab = $activeTab;

        return $this;
    }

    public function getActiveTab(): int
    {
        return $this->evaluate($this->activeTab);
    }
}
