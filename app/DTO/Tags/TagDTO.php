<?php

namespace App\DTO\Tags;

use App\DTO\Questions\QuestionCollection;
use App\DTO\Users\UserDTO;
use App\Models\Tag;
use Spatie\DataTransferObject\DataTransferObject;

class TagDTO extends DataTransferObject
{
    public ?int $id;
    public ?string $name;
    public ?string $desc;
    public ?array $questions;
    public ?UserDTO $creator;
    public ?QuestionCollection $questions_collection;
    public ?string $created_at;
    public ?string $created_date;
    public ?string $updated_at;
    public ?string $updated_date;

    public function toModel(): Tag
    {
        $tag = Tag::findOrFail($this->id);
        return $tag;
    }
}
