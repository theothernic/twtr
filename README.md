# Twtr

## What is this?
This was my way of hosting my old content when the old birdsite finally gags over.

## Requirements
* web server that can run PHP 8.1 (NGINX preferred.)
* Database server (mySQL used for testing)
* Your data archive.


## Download your twitter data.
First, you must request your data from the birdsite -- instructions _here_.

## Uploading your tweets?
After you have recieved your data archive:

1. Place your 'tweets.js' file in the [storage_dir]/tweetdata/imports.
2. Run the command `php artisan tweet:import`


---
07-2023. Nic Barr. <code@bearlovescode.com>


