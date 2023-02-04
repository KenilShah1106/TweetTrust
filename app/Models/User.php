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
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
    public function votesQuestion()
    {
        return $this->morphedByMany(Question::class, 'vote')->withTimestamps();
    }
    public function votesAnswer()
    {
        return $this->morphedByMany(Answer::class, 'vote')->withTimestamps();
    }

     /**
     * Helper methods for Question
     */
    public function hasQuestionUpvote($question_id)
    {
        if(gettype($question_id) == "integer") {
            return auth()->user()->votesQuestion()->where(['vote' => 1, 'vote_id' => $question_id, 'vote_type'=> Question::class])->exists();
        }
        return false;
    }
    public function hasQuestionDownvote($question_id)
    {
        if(gettype($question_id) == "integer") {
            return auth()->user()->votesQuestion()->where(['vote' => -1, 'vote_id' => $question_id, 'vote_type'=> Question::class])->exists();
        }
        return false;
    }
    public function hasVoteForQuestion($question_id)
    {
        return ($this->hasQuestionUpvote($question_id) || $this->hasQuestionDownvote($question_id));
    }

    public function hasAnswerUpvote($answer_id)
    {
        if(gettype($answer_id) == "integer") {
            return auth()->user()->votesAnswer()->where(['vote' => 1, 'vote_id' => $answer_id, 'vote_type'=> Answer::class])->exists();
        }
        return false;
    }
    public function hasAnswerDownvote($answer_id)
    {
        if(gettype($answer_id) == "integer") {
            return auth()->user()->votesAnswer()->where(['vote' => -1, 'vote_id' => $answer_id, 'vote_type' => Answer::class])->exists();
        }
        return false;
    }
    public function hasVoteForAnswer($answer_id)
    {
        return ($this->hasAnswerUpvote($answer_id) || $this->hasAnswerDownvote($answer_id));
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
            questions: gettype($this->questions) == 'array' ? $this->questions : null,
            answers: gettype($this->answers) == 'array' ? $this->answers : null,
            tags: gettype($this->tags) == 'array' ? $this->tags : null,
            created_at: $this->created_at,
            updated_at: $this->updated_at,
            created_date: (new Carbon($this->created_at))->diffForHumans(),
            updated_date: (new Carbon($this->updated_at))->diffForHumans(),
        );
    }
}
