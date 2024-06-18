<?php

namespace CorneelD\FilamentAstrotomicTranslatable\Resources\Pages\Concerns;

trait HasTranslatableFormWithExistingRecordData
{
    protected function fillForm(): void
    {
        $this->callHook('beforeFill');

        $attributes = $this->getRecordAttributesWithTranslations();

        $data = $this->mutateFormDataBeforeFill($attributes);

        $this->form->fill($data);

        $this->callHook('afterFill');
    }

    protected function getRecordAttributesWithTranslations(): array
    {
        $record = $this->getRecord();

        if (method_exists($record, 'getTranslationsArray')) {
            return array_merge(
                $record->attributesToArray(),
                $record->getTranslationsArray()
            );
        }

        return $record->attributesToArray();
    }
}
