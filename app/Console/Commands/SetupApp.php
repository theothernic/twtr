<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SetupApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup-app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        try
        {
            $this->ensureImportPathExists();
        }

        catch (\Exception $e)
        {
            $this->error(sprintf('Error: (%s) %s', $e->getCode(), $e->getMessage() ));
            exit(($e->getCode() > 127) ? 127 : $e->getCode());
        }

    }

    private function ensureImportPathExists() : void
    {
        if (!File::exists(config('import.path')));
            File::makeDirectory(config('import.path'));
    }
}
