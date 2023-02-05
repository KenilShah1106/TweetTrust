<?php

namespace App\Http\Controllers\Frontend;

use App\DTO\Replies\RepliesDTO;
use App\DTO\Tweets\TweetDTO;
use App\Http\Controllers\Controller;
use App\Models\Replies;
use App\Models\Tweet;

class FrontendRepliesController extends Controller
{
    public function edit(Tweet $tweet, Replies $answer)
    {
        $tweetDTO = new TweetDTO(...$tweet->toArray());
        $tweet = $tweetDTO;
        $answerDTO = new RepliesDTO(...$answer->toArray());
        $answer = $answerDTO;
        return view('frontend.replies.edit', compact(['tweet','answer']));
    }
}
