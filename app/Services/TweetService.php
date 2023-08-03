<?php
    namespace App\Services;

    use App\Models\Tweet;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Cache;

    class TweetService
    {
        public function get(string $id = '') : Tweet|null
        {
            if (empty($id))
                return null;

            return Cache::remember(sprintf('Tweet__%s', $id), 60, function () use ($id) {
                Tweet::where('id', $id)->first();
            });
        }

        public function filter(array $filters = []) : Collection|null
        {
            return null;
        }


        public function getTotalTweets()
        {
            return Tweet::count();
        }

        public function getPaginatedTweets($page = 1) {
            $skip = ((int) config('data.pagination.items')) * (int) $page;
            $take = (int) config('data.pagination.items');


            return Tweet::orderBy('created_at', 'DESC')->skip($skip)->take($take)->get();
        }

        public function tweetWithIdExists(string $snowflake_id = '') : bool
        {
            return (Tweet::where('snowflake_id', $snowflake_id)->get()->count() > 0);
        }
        public function createTweetModelFromData(object $data) : Tweet
        {
            return new Tweet([
                'favorited' => $data->favorite_count,
                'retweeted' => $data->retweet_count,
                'truncated' => $data->truncated,
                'source' => $data->source,
                'lang' => $data->lang,
                'body' => $data->full_text,
                'snowflake_id' => $data->id_str,
                'created_at' => (new Carbon($data->created_at))
            ]);
        }
    }
