<?php

namespace App\Http\Controllers;

use App\DTO\Replies\RepliesDTO;
use App\DTO\Tweets\TweetDTO;
use App\Models\Replies;
use App\Models\Tweet;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VotesController extends Controller
{
    public function voteTweet(Tweet $tweet, int $vote)
    {
        $authUser = auth()->user();
        try {
            if($authUser->hasVoteForTweet($tweet->id)) {
                //i will update
                if(($vote === 1 && $authUser->hasTweetUpvote($tweet->id))) {
                    // Has already liked and wants to unlike
                    $tweet->updateVote($vote, 1);
                } elseif(($vote === 1 && $authUser->hasTweetDownvote($tweet->id))) {
                    // Had disliked and now wants to like
                    $tweet->updateVote($vote);
                } elseif(($vote === -1 && $authUser->hasTweetDownvote($tweet->id))) {
                    // Has already disliked and wants to undislike
                    $tweet->updateVote($vote, -1);
                } elseif(($vote === -1 && $authUser->hasTweetUpvote($tweet->id))) {
                    // Had liked and now wants to dislike
                    $tweet->updateVote($vote);
                }

            }else {
                // i will create a new vote
                $tweet->vote($vote);
            }
            return new JsonResponse([
                'success' => [
                    'tweet' => new TweetDTO(
                        id: $tweet->id,
                        likes_count: $tweet->likes_count,
                        report_spam_count: $tweet->report_spam_count,
                        has_tweet_upvote: $authUser->hasTweetUpvote($tweet->id),
                        has_tweet_downvote: $authUser->hasTweetDownvote($tweet->id),
                    ),
                ]
            ]);
        } catch(Exception $e) {
            return new JsonResponse([
                'error' => "Some unexpected error " . $e,
            ]);
        }
    }

    public function voteReplies(Tweet $tweet, Replies $reply, int $vote)
    {
        try {
            $authUser = auth()->user();
            if($authUser->hasVoteForReplies($reply->id)) {
                //i will update
                if(($vote === 1 && $authUser->hasRepliesUpvote($reply->id))) {
                    // Has already liked and wants to unlike
                    $reply->updateVote($vote, 1);
                } elseif(($vote === 1 && $authUser->hasRepliesDownvote($reply->id))) {
                    // Had disliked and now wants to like
                    $reply->updateVote($vote);
                } elseif(($vote === -1 && $authUser->hasRepliesDownvote($reply->id))) {
                    // Has already disliked and wants to undislike
                    $reply->updateVote($vote, -1);
                } elseif(($vote === -1 && $authUser->hasRepliesUpvote($reply->id))) {
                    // Had liked and now wants to dislike
                    $reply->updateVote($vote);
                }

            }else {
                // i will create a new vote
                $reply->vote($vote);
            }
            return new JsonResponse([
                'success' => [
                    'reply' => new RepliesDTO(
                        id: $reply->id,
                        likes_count: $reply->likes_count,
                        report_spam_count: $reply->report_spam_count,
                        has_reply_upvote: $authUser->hasRepliesUpvote($reply->id),
                        has_reply_downvote: $authUser->hasRepliesDownvote($reply->id),
                    ),
                ]
            ]);
        } catch(Exception $e) {
            return new JsonResponse([
                'error' => "Some unexpected error " . $e,
            ]);
        }
    }
}
