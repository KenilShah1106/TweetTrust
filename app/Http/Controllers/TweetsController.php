<?php

namespace App\Http\Controllers;

use App\DTO\Tweets\TweetDTO;
use App\Http\Requests\Tweets\CreateTweetRequest;
use App\Http\Requests\Tweets\UpdateTweetRequest;
use App\Models\Replies;
use App\Models\Tweet;
use App\Notifications\Tweets\NewTweetAdded;
use App\Services\TweetService;
use Exception;

class TweetsController extends Controller
{
    public function __construct(private TweetService $tweetService)
    {
        $this->middleware('can:performAuthorActions,tweet')->except('store');
    }
    public function store(CreateTweetRequest $request)
    {
        try {
            $tweet = $this->tweetService->store(new TweetDTO(
                body: $request->body,
                user_id: auth()->id(),
                tags: $request->tags,
            ));
            /** Send Notifications */
            $userMsg = "You tweet has been successfully posted!";
            auth()->user()->notify(new NewTweetAdded($tweet, $userMsg));

            return redirect(route('frontend.tweets.index'));
        } catch(Exception $e) {
            session()->flash('error', 'Some unexpected error' . $e);
            return redirect()->back();
        }
    }

    public function update(UpdateTweetRequest $request, Tweet $tweet)
    {
        try {
            $this->tweetService->update(new TweetDTO(
                body: $request->body,
                tags: $request->tags,
            ), $tweet);
            return redirect(route('frontend.tweets.show', $tweet->id));
        } catch(Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Tweet $tweet)
    {
        $tweet->delete();
        return redirect(route('frontend.tweets.index'));
    }
    public function markAsBestReplies(Tweet $tweet, Replies $answer)
    {
        try {
            $this->tweetService->markAsBestReplies($tweet, $answer);
            return redirect()->back();
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}
