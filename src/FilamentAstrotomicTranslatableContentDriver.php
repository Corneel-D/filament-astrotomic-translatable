<?php

namespace CorneelD\FilamentAstrotomicTranslatable;

use Filament\Support\Contracts\TranslatableContentDriver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FilamentAstrotomicTranslatableContentDriver implements TranslatableContentDriver
{
    public function __construct(protected string $activeLocale)
    {
        //
    }

    public function isAttributeTranslatable(string $model, string $attribute): bool
    {
        $model = app($model);

        if (! property_exists($model, 'isTranslationAttribute')) {
            return false;
        }

        return $model->isTranslationAttribute($attribute);
    }

    /**
     * @return array<string, mixed>
     */
    public function getRecordAttributesToArray(Model $record): array
    {
        $recordData = $record->attributesToArray();

        if (! method_exists($record, 'getTranslationsArray')) {
            return $recordData;
        }
        $translatedData = $record->getTranslationsArray();

        return array_merge($recordData, $translatedData);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function makeRecord(string $model, array $data): Model
    {
        $record = new $model();

        $record->fill($data);

        return $record;
    }

    public function setRecordLocale(Model $record): Model
    {
        if (! method_exists($record, 'setLocale')) {
            return $record;
        }

        return $record->setLocale($this->activeLocale);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateRecord(Model $record, array $data): Model
    {
        $record->fill($data);

        return $record;
    }

    public function applySearchConstraintToQuery(Builder $query, string $column, string $search, string $whereClause, ?bool $isCaseInsensitivityForced = null): Builder
    {
        if ($isCaseInsensitivityForced) {
            $column = DB::raw("LOWER({$column})");
            $search = strtolower($search);
        }

        return $query->{$whereClause . 'TranslationLike'}($column, "%{$search}%", $this->activeLocale);
    }
}
