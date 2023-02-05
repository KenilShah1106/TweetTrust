<?php

namespace App\DTO\Replies;

use App\DTO\Tweets\TweetDTO;
use App\DTO\Users\UserDTO;
use App\Models\Replies;
use Spatie\DataTransferObject\DataTransferObject;

class RepliesDTO extends DataTransferObject
{
    public ?int $id;
    public ?string $body;
    public ?int $likes_count;
    public ?int $report_spam_count;
    public ?int $user_id;
    public ?int $tweet_id;
    public ?UserDTO $author;
    public ?TweetDTO $tweet;
    public ?string $created_at;
    public ?string $created_date;
    public ?string $updated_at;
    public ?string $updated_date;
    public ?bool $has_reply_upvote;
    public ?bool $has_reply_downvote;
    public ?string $status;

    public function toModel(): Replies
    {
        $reply = Replies::findOrFail($this->id);
        return $reply;
    }
}
