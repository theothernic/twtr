<?php
    namespace App\Http\Controllers;


    use App\Models\JsonResponseData;
    use App\Services\TweetService;
    use Illuminate\Http\Request;

    class TweetController
    {
        private TweetService $tweetService;

        public function __construct(TweetService $tweetService)
        {
            $this->tweetService = $tweetService;
        }

        public function getData(Request $request)
        {
            $pageNum = ($request->has('page')) ? (int) $request->get('page') : 1;
            $jsonResponse = new JsonResponseData();

            if ($records = $this->tweetService->getPaginatedTweets($pageNum))
            {
                $jsonResponse->total = $this->tweetService->getTotalTweets();
                $jsonResponse->success = true;
                $jsonResponse->data = $records;
                $jsonResponse->current = count($records);
                $jsonResponse->page = $pageNum;
            }

            return response()->json($jsonResponse);
        }

        public function single(string $id)
        {
            $jsonResponse = new JsonResponseData();

            if ($record = $this->tweetService->get($id))
            {
                $jsonResponse->total = 1;
                $jsonResponse->success = true;
                $jsonResponse->data = $record;
                $jsonResponse->current = 1;
                $jsonResponse->page = 1;
            }

            return response()->json($jsonResponse);
        }
        public function search(Request $request) {

        }
    }
