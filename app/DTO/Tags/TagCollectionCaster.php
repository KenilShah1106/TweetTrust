<?php

namespace App\DTO\Tags;

use App\DTO\Questions\QuestionCollectionCaster;
use App\DTO\Users\UserDTO;
use Carbon\Carbon;
use Spatie\DataTransferObject\Caster;

class TagCollectionCaster implements Caster
{
    public function cast(mixed $value): mixed
    {
        return new TagCollection(array_map(function(array $data){
            $questionCaster = new QuestionCollectionCaster();
            return new TagDTO(
                id: $data['id'],
                name: $data['name'],
                desc: $data['desc'],
                creator: new UserDTO(...$data['creator']),
                questions: $data['questions'],
                questions_collection: $questionCaster->cast($data['questions']),
                created_at: $data['created_at'],
                created_date: (new Carbon($data['created_at']))->diffForHumans(),
                updated_at: $data['updated_at'],
                updated_date: (new Carbon($data['updated_at']))->diffForHumans(),
            );
        }, $value));
    }
}
