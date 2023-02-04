<?php

namespace App\DTO\Users;

use App\DTO\Users\UserDTO;
use Carbon\Carbon;
use Spatie\DataTransferObject\Caster;

class UserCollectionCaster implements Caster
{
    public function cast(mixed $value): mixed
    {
        return new UserCollection(array_map(function(array $data){
            return new UserDTO(
                id: $data['id'],
                name: $data['name'],
                email: $data['email'],
                about: $data['about'],
                location: $data['location'],
                role: $data['role'],
                reputation: $data['reputation'],
                created_at: $data['created_at'],
                created_date: (new Carbon($data['created_at']))->diffForHumans(),
                updated_at: $data['updated_at'],
                updated_date: (new Carbon($data['updated_at']))->diffForHumans(),
            );
        }, $value));
    }
}
