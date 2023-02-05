<?php

namespace App\DTO\Tweets;

use App\DTO\Replies\RepliesCollectionCaster;
use App\DTO\Tags\TagCollectionCaster;
use App\DTO\Users\UserDTO;
use Carbon\Carbon;
use Spatie\DataTransferObject\Caster;

class TweetCollectionCaster implements Caster
{

    public function cast(mixed $value): mixed
    {
        return new TweetCollection(array_map(function(array $data){
            $authUser = auth()->user();
            $tagCaster = new TagCollectionCaster();
            $answerCaster = new RepliesCollectionCaster();
            return new TweetDTO(
                id: $data['id'],
                body: $data['body'],
                replies_count: $data['replies_count'],
                likes_count: $data['likes_count'],
                report_spam_count: $data['report_spam_count'],
                user_id: $data['user_id'],
                author: new UserDTO(...$data['author']),
                replies_collection: $answerCaster->cast($data['replies']),
                tags: $data['tags'],
                tags_collection: $tagCaster->cast($data['tags']),
                created_at: $data['created_at'],
                created_date: (new Carbon($data['created_at']))->diffForHumans(),
                updated_at: $data['updated_at'],
                updated_date: (new Carbon($data['updated_at']))->diffForHumans(),
                has_tweet_upvote: $authUser ? $authUser->hasTweetUpvote($data['id']) : false,
                has_tweet_downvote: $authUser ? $authUser->hasTweetDownvote($data['id']) : false,
            );
        }, $value));
    }
}
