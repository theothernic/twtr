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

### Run the migrations
At the command prompt, run `php artisan migrate --force`

### Upload your tweet data

1. From your archive's `data` folder, make a copy the `tweets.js` file and open the copy.
2. Edit your copied file so that there is no variable or assignment operator on the first line/
at the beginning of the file.
1. Place your copied `tweets.js` file in the [storage_dir]/tweetdata/imports.
2. Run the command `php artisan tweet:import`


---
07-2023. Nic Barr. <code@bearlovescode.com>


