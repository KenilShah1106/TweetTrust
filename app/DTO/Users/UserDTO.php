<?php

namespace App\DTO\Users;

use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

class UserDTO extends DataTransferObject
{
    public ?int $id;
    public ?string $name;
    public ?string $email;
    public ?string $about;
    public ?string $location;
    public ?string $role;
    public ?string $avatar;
    public ?int $reputation;
    public ?string $created_at;
    public ?string $created_date;
    public ?string $updated_at;
    public ?string $updated_date;

    public function toModel(): User
    {
        $user = User::findOrFail($this->id);
        return $user;
    }
}
