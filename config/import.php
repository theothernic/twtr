<?php
    return [
        'path' => storage_path('app/' . env('APP_TWEETDATA_IMPORT_PATH', 'tweetdata/import')),
        'archive' => storage_path('app/' . env('APP_TWEETDATA_ARCHIVE_PATH', 'tweetdata/archive'))
    ];
