<?php

namespace CorneelD\FilamentAstrotomicTranslatable\Resources\Pages\Record\Concerns;

use CorneelD\FilamentAstrotomicTranslatable\Resources\Pages\Concerns\BaseTranslatable;
use CorneelD\FilamentAstrotomicTranslatable\Resources\Pages\Concerns\HasTranslatableFormWithExistingRecordData;

trait ViewTranslatable
{
    use BaseTranslatable;
    use HasTranslatableFormWithExistingRecordData;
}
