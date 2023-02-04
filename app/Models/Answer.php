<?php

namespace App\Models;

use App\Constants\AnswerConstants;
use App\DTO\Answers\AnswerDTO;
use App\Helpers\Utils;
use App\Helpers\Votable;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Answer extends Model implements AnswerConstants
{
    use HasFactory, Votable;

    protected $guarded = ['id'];

    /**
     * MODEL EVENTS
     */
    public static function boot()
    {
        parent::boot();
        static::created(function(Answer $answer) {
            $answer->question->increment('answers_count');
        });
        static::deleted(function(Answer $answer) {
            $answer->question->decrement('answers_count');
        });
    }
    /**
     * ACCESSORS
     */
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    /**
     * RELATIONSHIP METHODS
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function votes()
    {
        return $this->morphToMany(User::class, 'vote')->withTimestamps();
    }
    /**
     * HELPER METHODS
     */

    public static function storeAnswer(AnswerDTO $answerDTO): self | Exception
    {
        Utils::validateOrThrow(self::CREATE_RULES, $answerDTO->toArray());
        $answer = null;
        DB::transaction(function () use($answerDTO, &$answer) {
            $answer = auth()->user()->answers()->create($answerDTO->except('created_at', 'updated_at', 'author')->toArray());
        });
        return $answer;
    }

    public function updateAnswer(AnswerDTO $answerDTO): self | Exception
    {
        Utils::validateOrThrow(self::UPDATE_RULES, $answerDTO->toArray());
        DB::transaction(function () use($answerDTO) {
            $this->fill([
                'body' => $answerDTO->body,
            ]);
            if($this->isClean()) {
                throw new Exception('You must change some value to update', 422);
            }
            $this->save();
        });
        return $this;
    }

    public function toDTO(): AnswerDTO
    {
        $authUser = auth()->user();
        return new AnswerDTO(
          id: $this->id,
          body: $this->body,
          upvotes_count: $this->upvotes_count,
          downvotes_count: $this->downvotes_count,
          user_id: $this->user_id,
          question_id: $this->question_id,
          question: $this->question->toDTO(),
          author: $this->author->toDTO(),
          created_at: $this->created_at,
          updated_at: $this->updated_at,
          created_date: (new Carbon($this->created_at))->diffForHumans(),
          updated_date: (new Carbon($this->updated_at))->diffForHumans(),
          has_answer_upvote: $authUser ? $authUser->hasAnswerUpvote($this->id) : false,
          has_answer_downvote: $authUser ? $authUser->hasAnswerDownvote($this->id) : false
        );
    }
}
