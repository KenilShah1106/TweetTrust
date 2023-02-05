<?php

namespace App\DTO\Replies;

use App\DTO\Tweets\TweetDTO;
use App\DTO\Users\UserDTO;
use Carbon\Carbon;
use Spatie\DataTransferObject\Caster;

class RepliesCollectionCaster implements Caster
{

    public function cast(mixed $value): mixed
    {
        return new RepliesCollection(array_map(function(array $data){
            $authUser = auth()->user();
            return new RepliesDTO(
                id: $data['id'],
                user_id: $data['user_id'],
                tweet_id: $data['tweet_id'],
                body: $data['body'],
                likes_count: $data['likes_count'],
                report_spam_count: $data['report_spam_count'],
                author: new UserDTO(...$data['author']),
                tweet: new TweetDTO(...$data['tweet']),
                status: $data['status'],
                created_at: $data['created_at'],
                created_date: (new Carbon($data['created_at']))->diffForHumans(),
                updated_at: $data['updated_at'],
                updated_date: (new Carbon($data['updated_at']))->diffForHumans(),
                has_reply_upvote: $authUser ? $authUser->hasRepliesUpvote($data['id']) : false,
                has_reply_downvote: $authUser ? $authUser->hasRepliesDownvote($data['id']) : false,
            );
        }, $value));
    }
}
