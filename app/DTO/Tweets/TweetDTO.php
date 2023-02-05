<?php

namespace App\DTO\Tweets;

use App\DTO\Replies\RepliesCollection;
use App\DTO\Replies\RepliesDTO;
use App\DTO\Tags\TagCollection;
use App\DTO\Users\UserDTO;
use App\Models\Tweet;
use Spatie\DataTransferObject\DataTransferObject;

class TweetDTO extends DataTransferObject
{
    public ?int $id;
    public ?string $body;
    public ?int $replies_count;
    public ?int $likes_count;
    public ?int $report_spam_count;
    public ?int $user_id;
    public ?UserDTO $author;
    public ?array $tags;
    public ?TagCollection $tags_collection;
    public ?array $replies;
    public ?RepliesCollection $replies_collection;
    public ?string $created_at;
    public ?string $created_date;
    public ?string $updated_at;
    public ?string $updated_date;
    public ?bool $has_tweet_upvote;
    public ?bool $has_tweet_downvote;

    public function toModel(): Tweet
    {
        $tweet = Tweet::findOrFail($this->id);
        return $tweet;
    }
}
