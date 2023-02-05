<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tweet;
use App\Models\Tag;
use App\Services\TweetService;

class FrontendTweetsController extends Controller
{
    private $tweetService;
    public function __construct()
    {
        $this->middleware('can:performAuthorActions,tweet')->only('edit');
        $this->tweetService = new TweetService();
    }
    public function index()
    {
        $tweets = $this->tweetService->index();
        return view('frontend.tweets.index', compact(['tweets']));
    }

    public function show(int $id)
    {
        $tweet = $this->tweetService->show($id);
        return view('frontend.tweets.show', compact(['tweet']));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('frontend.tweets.create', compact(['tags']));
    }

    public function edit(Tweet $tweet)
    {
        $tags = Tag::all();
        return view('frontend.tweets.edit', compact(['tweet', 'tags']));
    }

}
