<?php

namespace App\DTO\Answers;

use App\DTO\Questions\QuestionDTO;
use App\DTO\Users\UserDTO;
use App\Models\Answer;
use Spatie\DataTransferObject\DataTransferObject;

class AnswerDTO extends DataTransferObject
{
    public ?int $id;
    public ?string $body;
    public ?int $upvotes_count;
    public ?int $downvotes_count;
    public ?int $user_id;
    public ?int $question_id;
    public ?UserDTO $author;
    public ?QuestionDTO $question;
    public ?string $created_at;
    public ?string $created_date;
    public ?string $updated_at;
    public ?string $updated_date;
    public ?bool $has_answer_upvote;
    public ?bool $has_answer_downvote;

    public function toModel(): Answer
    {
        $answer = Answer::findOrFail($this->id);
        return $answer;
    }
}
