<?php
    namespace App\Services;

    use App\Models\Tweet;
    use Illuminate\Support\Carbon;

    class TweetService
    {
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
