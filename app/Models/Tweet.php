<?php

namespace App\Models;

use App\Constants\TweetConstants;
use App\DTO\Tweets\TweetDTO;
use App\Helpers\Utils;
use App\Helpers\Votable;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Tweet extends Model implements TweetConstants
{
    use HasFactory, Votable;

    protected $guarded = ['id'];

    /**
     * HELPER METHODS
     */
    public function hasTag(int $tag_id):bool
    {
        return in_array($tag_id, $this->tags->pluck('id')->toArray());
    }

    public function toDTO(): TweetDTO
    {
        $authUser = auth()->user();
        return new TweetDTO(
            id: $this->id,
            body: $this->body,
            user_id: $this->user_id,
            replies_count: $this->replies_count,
            likes_count: $this->likes_count,
            report_spam_count: $this->report_spam_count,
            author: $this->author->toDTO(),
            tags: gettype($this->tags) == 'array' ? $this->tags : null,
            replies: gettype($this->replies) == 'array' ? $this->replies : null,
            created_at: $this->created_at,
            updated_at: $this->updated_at,
            created_date: (new Carbon($this->created_at))->diffForHumans(),
            updated_date: (new Carbon($this->updated_at))->diffForHumans(),
            has_tweet_upvote: $authUser ? $authUser->hasTweetUpvote($this->id) : false,
            has_tweet_downvote: $authUser ? $authUser->hasTweetDownvote($this->id) : false
        );
    }
    /**
     * ACCESSORS
     */
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    public function getRepliesStyleAttribute()
    {
        if($this->replies_count > 0) {
            // if($this->best_answer_id) {
                // return "bi bi-check-circle-fill text-success";
            // }
            return "bi bi-check-circle";
        }
        return "bi bi-x-circle-fill text-danger";
    }
    /**
     * MUTATORS
     */
    /**
     * RELATIONSHIP METHODS
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function replies()
    {
        return $this->hasMany(Replies::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
    public function votes()
    {
        return $this->morphToMany(User::class, 'vote')->withTimestamps();
    }
    public function bestReplies()
    {
        return $this->hasOne(Replies::class, 'id')->with(['tweet', 'author', 'votes']);
    }
    /**
     * DB Helper Methods
     */

    public static function storeTweet(TweetDTO $tweetDTO): self | Exception
    {
        Utils::validateOrThrow(self::CREATE_RULES, $tweetDTO->toArray());
        $tweet = null;
        DB::transaction(function () use(&$tweet, $tweetDTO) {
            $tweet = auth()->user()->tweets()->create([
                'body' => $tweetDTO->body,
                'replies_count'=> 0,
                'likes_count'=> 0,
                'report_spam_count'=> 0,
            ]);
            $tweet->tags()->attach($tweetDTO->tags);
        });
        return $tweet;
    }

    public function updateTweet(TweetDTO $tweetDTO): self | Exception
    {
        Utils::validateOrThrow(self::UPDATE_RULES, $tweetDTO->toArray());
        DB::transaction(function () use($tweetDTO){
            $this->fill([
                'body' => $tweetDTO->body,
            ]);
            $this->tags()->sync($tweetDTO->tags);
            // if($this->isClean()) {
            //     throw new Exception('You must change some value to update', 422);
            // }
            $this->save();
        });
        return $this;
    }

    public function markAsBestReplies(int $answerId)
    {
        DB::transaction(function () use($answerId) {
            $this->update([
                'best_answer_id' => $answerId,
            ]);
        });
    }
}
