<?php
    namespace App\Providers;


    use App\Services\TweetService;
    use Illuminate\Support\ServiceProvider;

    class TweetServiceProvider extends ServiceProvider
    {

        public function boot() : void
        {
            $this->app->singleton(TweetService::class, function () {
                return new TweetService();
            });
        }
    }
