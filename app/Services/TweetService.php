<?php

namespace App\Services;

use App\DTO\Replies\RepliesDTO;
use App\DTO\Tweets\TweetDTO;
use App\Models\Replies;
use App\Models\Tweet;
use Exception;

class TweetService
{
    public function index()
    {
        $tweets = Tweet::with('author', 'replies', 'tags')->get()->sortByDesc('created_at');
        $tweetDTOs = [];

        foreach($tweets as $tweet) {
            $tagDTOs = [];
            foreach ($tweet->tags as $tag) {
                $tag->tweets = null;
                $tagDTOs[] = $tag->toDTO();
            }
            $tweet->tags = $tagDTOs;
            $tweet->replies = null;
            $tweetDTO = $tweet->toDTO();
            $tweetDTOs[] = $tweetDTO;
        }

        return $tweetDTOs;
    }

    public function show(int $id)
    {
        $tweet = Tweet::with('author', 'replies', 'tags')->findOrFail($id);
        $tagDTOs = [];
        foreach($tweet->tags as $tag) {
            $tag->tweets = null;
            $tagDTOs[] = $tag->toDTO();
        }
        $answerDTOs = [];
        foreach($tweet->replies->sortByDesc('created_at') as $answer) {
            $answerDTOs[] = $answer->toDTO();
        }
        $tweet->tags = $tagDTOs;
        $tweet->replies = $answerDTOs;
        $tweetDTO = $tweet->toDTO();
        return $tweetDTO;
    }

    public function store(TweetDTO $tweetDTO)
    {
        try {
            return Tweet::storeTweet($tweetDTO);
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function update(TweetDTO $tweetDTO, Tweet $tweet)
    {
        try {
            $tweet->updateTweet($tweetDTO);
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function markAsBestReplies(Tweet $tweet, Replies $answer)
    {
        try {
            $tweet->markAsBestReplies($answer->id);
        } catch(Exception $e) {
            throw $e;
        }
    }

}
