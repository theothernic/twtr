<?php

namespace App\Console\Commands;

use App\Exceptions\Import\TweetImportException;
use App\Services\TweetService;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use JetBrains\PhpStorm\NoReturn;
use JsonMachine\Items;

class ImportTweetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:tweets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import tweet data required for running the application.';

    private TweetService $tweetService;
    public function __construct(TweetService $tweetService)
    {
        parent::__construct();

        $this->tweetService = $tweetService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->alert('Tweet Data Import');
        $path = config('import.path');

        if (!$this->importFolderIsAvailable($path))
        {
            $error = 'Data import folder %s does not exist. Double-check your configuration.';
            $this->crashOut(sprintf($error, $path));
        }


        $this->info(sprintf('Storage path: %s', $path));

        // Clear cache.
        $this->info('Clearing application cache.');
        Artisan::call('cache:clear');


        $files = $this->enumerateImportFiles($path);

        if (empty($files))
            $this->crashOut('No files available for import.');

        $this->line('Starting import process.');

        try {
            $results = $this->handleDataImport($files);
            $this->line(sprintf('Completed imports: %s', count($results['completed'])));
            $this->line(sprintf('Existing imports: %s', count($results['existing'])));
            $this->line(sprintf('Broken imports: %s', count($results['broken'])));
        }
        catch (TweetImportException $e)
        {
            $this->crashOut($e->getMessage());
        }

    }

    private function importFolderIsAvailable(string $path = '') : bool
    {
        if (!File::exists($path))
            return false;

        return true;
    }

    private function enumerateImportFiles(string $path = '') : array
    {
        return File::allFiles($path);
    }

    /**
     * @param array $files
     * @return void
     * @throws TweetImportException
     * @throws \JsonMachine\Exception\InvalidArgumentException
     */
    private function handleDataImport(array $files = []) : array
    {
        $twCounts = [
            'existing' => [],
            'completed' => [],
            'broken' => []
        ];

        foreach ($files as $file) {
            try
            {
                $this->warn('Preparing to load tweets. (This may take a bit.)');
                $tweets = Items::fromFile($file->getRealPath());

                foreach ($tweets as $tw)
                {
                    try {
                        $this->comment(sprintf('Loaded tweet %s.', $tw->tweet->id_str));

                        $this->comment('Checking if tweet already exists.');

                        if ($this->tweetService->tweetWithIdExists($tw->tweet->id_str))
                        {
                            $this->warn('Tweet already exists, skipping.');
                            $twCounts['existing'][$tw->tweet->id_str] = $tw->tweet->id_str;
                            continue;
                        }


                        // hydrate and persist!
                        $this->comment('Creating Tweet model and persisting the data.');
                        if ($this->tweetService->createTweetModelFromData($tw->tweet)->save()) {
                            $twCounts['completed'][$tw->tweet->id_str] = $tw->tweet->id_str;
                            $this->info(sprintf('>> Imported tweet %s.', $tw->tweet->id_str));
                        }
                    }

                    catch (QueryException $e)
                    {
                        $twCounts['broken'][$tw->tweet->id_str] = $tw->tweet->id_str;
                        $this->warn('Encountered a persistence issue.');
                        continue;
                    }
                }

                return $twCounts;
            }

            catch (\InvalidArgumentException $e)
            {
                throw new TweetImportException($e->getCode(), $e->getMessage());
            }

        }
    }

    #[NoReturn]
    private function crashOut(string $message = '') : void
    {
        $this->error($message);
        exit(127);
    }
}
