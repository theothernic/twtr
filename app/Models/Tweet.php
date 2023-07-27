<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Concerns\HasUlids;
    use Illuminate\Database\Eloquent\Model;

    class Tweet extends Model
    {
        use HasUlids;

        protected $keyType = 'string';

        protected $fillable = [
            'snowflake_id',
            'body',
            'lang',
            'source',
            'favorited',
            'retweeted',
            'truncated',
            'created_at'
        ];
    }
