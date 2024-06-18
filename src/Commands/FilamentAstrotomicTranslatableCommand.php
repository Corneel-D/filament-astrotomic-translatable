<?php

namespace CorneelD\FilamentAstrotomicTranslatable\Commands;

use Illuminate\Console\Command;

class FilamentAstrotomicTranslatableCommand extends Command
{
    public $signature = 'filament-astrotomic-translatable';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
