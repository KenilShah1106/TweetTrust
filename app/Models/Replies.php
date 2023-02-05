<?php

namespace App\Models;

use App\Constants\RepliesConstants;
use App\DTO\Replies\RepliesDTO;
use App\DTO\Tweets\TweetDTO;
use App\DTO\Users\UserDTO;
use App\Helpers\Utils;
use App\Helpers\Votable;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Replies extends Model implements RepliesConstants
{
    use HasFactory;
    use Votable;

    protected $guarded = ['id'];
    protected $dates = ['published_at', 'approved_at', 'disapproved_at'];

    /**
     * Relationships
     */
    public function tweet()
    {
        return $this->belongsTo(Tweet::class, 'tweet_id');
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
    public function votes()
    {
        return $this->morphToMany(User::class, 'vote')->withTimestamps();
    }
    /**
     * Helper methods
     */
    public function isYourComment()
    {
        return $this->user_id == auth()->user()->id;
    }
    public function isApproved()
    {
        return $this->approved_at != NULL;
    }
    public function isDisapproved()
    {
        return $this->disapproved_at != NULL;
    }

    /**
     * Accessors
     */
    public function getPublishedDateAttribute()
    {
        return $this->published_at->diffForHumans();
    }
    public function getApprovedDateAttribute()
    {
        return $this->approved_at->diffForHumans();
    }
    public function getDisapprovedDateAttribute()
    {
        return $this->disapproved_at->diffForHumans();
    }
    public function getDeletedDateAttribute()
    {
        return $this->deleted_at->diffForHumans();
    }
    public function getApproverAttribute()
    {
        return User::findOrFail($this->approved_by)->name;
    }
    public function getDisapproverAttribute()
    {
        return User::findOrFail($this->disapproved_by)->name;
    }
    /**
     * Query Scopes
     */
    public function scopeUser($query)
    {
        return $query->where('user_id', auth()->id());
    }
    public function scopeApproved($query)
    {
        return $query->where('approved_at', '<=', now());
    }
    public function scopeDisapproved($query)
    {
        return $query->where('disapproved_at', '<=', now());
    }
    public function scopeParentReplies($query)
    {
        return $query->where('parent_id' , NULL);
    }
    public function scopeMyTweetsReplies($query)
    {
        return $query->where('approved_by' , auth()->id())
                    ->OrWhere('disapproved_by', auth()->id());
    }

    public static function storeReplies(RepliesDTO $replyDTO): self | Exception
    {
        Utils::validateOrThrow(self::CREATE_RULES, $replyDTO->toArray());
        $reply = null;
        DB::transaction(function () use($replyDTO, &$reply) {
            $reply = auth()->user()->replies()->create($replyDTO->except('created_at', 'updated_at', 'author')->toArray());
        });
        return $reply;
    }

    public function updateReplies(RepliesDTO $replyDTO): self | Exception
    {
        Utils::validateOrThrow(self::UPDATE_RULES, $replyDTO->toArray());
        DB::transaction(function () use($replyDTO) {
            $this->fill([
                'body' => $replyDTO->body,
            ]);
            if($this->isClean()) {
                throw new Exception('You must change some value to update', 422);
            }
            $this->save();
        });
        return $this;
    }
    public function toDTO(): RepliesDTO
    {
        $authUser = auth()->user();
        return new RepliesDTO(
            id: $this->id,
            user_id: $this->user_id,
            tweet_id: $this->tweet_id,
            body: $this->body,
            likes_count: $this->likes_count,
            report_spam_count: $this->report_spam_count,
            author: $this->author->toDTO(),
            tweet: $this->tweet->toDTO(),
            status: $this->status,
            created_at: $this->created_at,
            created_date: (new Carbon($this->created_at))->diffForHumans(),
            updated_at: $this->updated_at,
            updated_date: (new Carbon($this->updated_at))->diffForHumans(),
            has_reply_upvote: $authUser ? $authUser->hasRepliesUpvote($this->id) : false,
            has_reply_downvote: $authUser ? $authUser->hasRepliesDownvote($this->id) : false,
        );
    }
}
