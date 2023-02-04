<?php

namespace App\Models;

use App\Constants\QuestionConstants;
use App\DTO\Questions\QuestionDTO;
use App\Helpers\Utils;
use App\Helpers\Votable;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Question extends Model implements QuestionConstants
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

    public function toDTO(): QuestionDTO
    {
        $authUser = auth()->user();
        return new QuestionDTO(
            id: $this->id,
            title: $this->title,
            slug: $this->slug,
            body: $this->body,
            user_id: $this->user_id,
            views_count: $this->views_count,
            answers_count: $this->answers_count,
            comments_count: $this->comments_count,
            upvotes_count: $this->upvotes_count,
            downvotes_count: $this->downvotes_count,
            best_answer_id: $this->best_answer_id,
            bestAnswer: null,
            author: $this->author->toDTO(),
            tags: gettype($this->tags) == 'array' ? $this->tags : null,
            answers: gettype($this->answers) == 'array' ? $this->answers : null,
            created_at: $this->created_at,
            updated_at: $this->updated_at,
            created_date: (new Carbon($this->created_at))->diffForHumans(),
            updated_date: (new Carbon($this->updated_at))->diffForHumans(),
            has_question_upvote: $authUser ? $authUser->hasQuestionUpvote($this->id) : false,
            has_question_downvote: $authUser ? $authUser->hasQuestionDownvote($this->id) : false
        );
    }
    /**
     * ACCESSORS
     */
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    public function getAnswerStyleAttribute()
    {
        if($this->answers_count > 0) {
            if($this->best_answer_id) {
                return "bi bi-check-circle-fill text-success";
            }
            return "bi bi-check-circle";
        }
        return "bi bi-x-circle-fill text-danger";
    }
    /**
     * MUTATORS
     */
    public function setTitleAttribute(string $title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = Str::slug($title);
    }
    /**
     * RELATIONSHIP METHODS
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
    public function votes()
    {
        return $this->morphToMany(User::class, 'vote')->withTimestamps();
    }
    public function bestAnswer()
    {
        return $this->hasOne(Answer::class, 'id')->with(['question', 'author', 'votes']);
    }
    /**
     * DB Helper Methods
     */

    public static function storeQuestion(QuestionDTO $questionDTO): self | Exception
    {
        Utils::validateOrThrow(self::CREATE_RULES, $questionDTO->toArray());
        $question = null;
        DB::transaction(function () use(&$question, $questionDTO) {
            $question = auth()->user()->questions()->create([
                'title' => $questionDTO->title,
                'body' => $questionDTO->body,
                'views_count'=> 0,
                'answers_count'=> 0,
                'upvotes_count'=> 0,
                'downvotes_count'=> 0,
            ]);
            $question->tags()->attach($questionDTO->tags);
        });
        return $question;
    }

    public function updateQuestion(QuestionDTO $questionDTO): self | Exception
    {
        Utils::validateOrThrow(self::UPDATE_RULES, $questionDTO->toArray());
        DB::transaction(function () use($questionDTO){
            $this->fill([
                'title' => $questionDTO->title,
                'body' => $questionDTO->body,
            ]);
            $this->tags()->sync($questionDTO->tags);
            // if($this->isClean()) {
            //     throw new Exception('You must change some value to update', 422);
            // }
            $this->save();
        });
        return $this;
    }

    public function markAsBestAnswer(int $answerId)
    {
        DB::transaction(function () use($answerId) {
            $this->update([
                'best_answer_id' => $answerId,
            ]);
        });
    }
}
