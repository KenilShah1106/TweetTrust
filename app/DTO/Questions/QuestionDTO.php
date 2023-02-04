<?php

namespace App\DTO\Questions;

use App\DTO\Answers\AnswerCollection;
use App\DTO\Answers\AnswerDTO;
use App\DTO\Tags\TagCollection;
use App\DTO\Users\UserDTO;
use App\Models\Question;
use Spatie\DataTransferObject\DataTransferObject;

class QuestionDTO extends DataTransferObject
{
    public ?int $id;
    public ?string $title;
    public ?string $slug;
    public ?string $body;
    public ?int $views_count;
    public ?int $answers_count;
    public ?int $comments_count;
    public ?int $upvotes_count;
    public ?int $downvotes_count;
    public ?int $best_answer_id;
    public ?AnswerDTO $bestAnswer;
    public ?int $user_id;
    public ?UserDTO $author;
    public ?array $tags;
    public ?TagCollection $tags_collection;
    public ?array $answers;
    public ?AnswerCollection $answers_collection;
    public ?string $created_at;
    public ?string $created_date;
    public ?string $updated_at;
    public ?string $updated_date;
    public ?bool $has_question_upvote;
    public ?bool $has_question_downvote;

    public function toModel(): Question
    {
        $question = Question::findOrFail($this->id);
        return $question;
    }
}
