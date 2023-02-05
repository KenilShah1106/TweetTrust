<?php

namespace App\Models;

use App\DTO\Users\UserDTO;
use App\Scopes\UserScopes;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, UserScopes;

    const ADMIN = 1;
    const CONTRIBUTOR = 2;
    const USER = 3;
    protected $guarded = ['id'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * Accessors
     */
    public function getAvatarAttribute()
    {
        $size=40;
        $name = $this->name;
        return "https://ui-avatars.com/api/?name={$name}&rounded=true&size={$size}";
    }

    public function getUserRoleAttribute()
    {
        if($this->role == self::ADMIN) {
            return 'admin';
        }
        if($this->role == self::CONTRIBUTOR) {
            return 'contributor';
        }
        if($this->role == self::USER) {
            return 'user';
        }
    }
    /**
     * RELATIONSHIP METHODS
     */
    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }
    public function replies()
    {
        return $this->hasMany(Replies::class);
    }
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
    public function votesTweet()
    {
        return $this->morphedByMany(Tweet::class, 'vote')->withTimestamps();
    }
    public function votesReplies()
    {
        return $this->morphedByMany(Replies::class, 'vote')->withTimestamps();
    }

     /**
     * Helper methods for Tweet
     */
    public function hasTweetUpvote($tweet_id)
    {
        if(gettype($tweet_id) == "integer") {
            return auth()->user()->votesTweet()->where(['vote' => 1, 'vote_id' => $tweet_id, 'vote_type'=> Tweet::class])->exists();
        }
        return false;
    }
    public function hasTweetDownvote($tweet_id)
    {
        if(gettype($tweet_id) == "integer") {
            return auth()->user()->votesTweet()->where(['vote' => -1, 'vote_id' => $tweet_id, 'vote_type'=> Tweet::class])->exists();
        }
        return false;
    }
    public function hasVoteForTweet($tweet_id)
    {
        return ($this->hasTweetUpvote($tweet_id) || $this->hasTweetDownvote($tweet_id));
    }

    public function hasRepliesUpvote($reply_id)
    {
        if(gettype($reply_id) == "integer") {
            return auth()->user()->votesReplies()->where(['vote' => 1, 'vote_id' => $reply_id, 'vote_type'=> Replies::class])->exists();
        }
        return false;
    }
    public function hasRepliesDownvote($reply_id)
    {
        if(gettype($reply_id) == "integer") {
            return auth()->user()->votesReplies()->where(['vote' => -1, 'vote_id' => $reply_id, 'vote_type' => Replies::class])->exists();
        }
        return false;
    }
    public function hasVoteForReplies($reply_id)
    {
        return ($this->hasRepliesUpvote($reply_id) || $this->hasRepliesDownvote($reply_id));
    }

    public function toDTO(): UserDTO
    {
        return new UserDTO(
            id: $this->id,
            name: $this->name,
            email: $this->email,
            about: $this->about,
            location: $this->location,
            role: $this->role,
            avatar: $this->avatar,
            reputation: $this->reputation,
            tweets: gettype($this->tweets) == 'array' ? $this->tweets : null,
            replies: gettype($this->replies) == 'array' ? $this->replies : null,
            tags: gettype($this->tags) == 'array' ? $this->tags : null,
            created_at: $this->created_at,
            updated_at: $this->updated_at,
            created_date: (new Carbon($this->created_at))->diffForHumans(),
            updated_date: (new Carbon($this->updated_at))->diffForHumans(),
        );
    }
}
