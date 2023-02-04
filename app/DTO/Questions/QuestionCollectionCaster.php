<?php

namespace App\DTO\Questions;

use App\DTO\Answers\AnswerCollectionCaster;
use App\DTO\Tags\TagCollectionCaster;
use App\DTO\Users\UserDTO;
use Carbon\Carbon;
use Spatie\DataTransferObject\Caster;

class QuestionCollectionCaster implements Caster
{

    public function cast(mixed $value): mixed
    {
        return new QuestionCollection(array_map(function(array $data){
            $authUser = auth()->user();
            $tagCaster = new TagCollectionCaster();
            $answerCaster = new AnswerCollectionCaster();
            return new QuestionDTO(
                id: $data['id'],
                title: $data['title'],
                slug: $data['slug'],
                body: $data['body'],
                views_count: $data['views_count'],
                answers_count: $data['answers_count'],
                upvotes_count: $data['upvotes_count'],
                downvotes_count: $data['downvotes_count'],
                comments_count: $data['comments_count'],
                best_answer: $data['best_answer_id'],
                user_id: $data['user_id'],
                author: new UserDTO(...$data['author']),
                answers_collection: $answerCaster->cast($data['answers']),
                tags: $data['tags'],
                tags_collection: $tagCaster->cast($data['tags']),
                created_at: $data['created_at'],
                created_date: (new Carbon($data['created_at']))->diffForHumans(),
                updated_at: $data['updated_at'],
                updated_date: (new Carbon($data['updated_at']))->diffForHumans(),
                has_question_upvote: $authUser ? $authUser->hasQuestionUpvote($data['id']) : false,
                has_question_downvote: $authUser ? $authUser->hasQuestionDownvote($data['id']) : false,
            );
        }, $value));
    }
}
