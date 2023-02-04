<?php

namespace App\DTO\Answers;

use App\DTO\Questions\QuestionDTO;
use App\DTO\Users\UserDTO;
use Carbon\Carbon;
use Spatie\DataTransferObject\Caster;

class AnswerCollectionCaster implements Caster
{

    public function cast(mixed $value): mixed
    {
        return new AnswerCollection(array_map(function(array $data){
            $authUser = auth()->user();
            return new AnswerDTO(
                id: $data['id'],
                user_id: $data['user_id'],
                question_id: $data['question_id'],
                body: $data['body'],
                upvotes_count: $data['upvotes_count'],
                downvotes_count: $data['downvotes_count'],
                author: new UserDTO(...$data['author']),
                question: new QuestionDTO(...$data['question']),
                created_at: $data['created_at'],
                created_date: (new Carbon($data['created_at']))->diffForHumans(),
                updated_at: $data['updated_at'],
                updated_date: (new Carbon($data['updated_at']))->diffForHumans(),
                has_answer_upvote: $authUser ? $authUser->hasAnswerUpvote($data['id']) : false,
                has_answer_downvote: $authUser ? $authUser->hasAnswerDownvote($data['id']) : false,
            );
        }, $value));
    }
}
