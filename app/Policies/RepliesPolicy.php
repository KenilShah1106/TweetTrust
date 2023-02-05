<?php

namespace App\Policies;

use App\Models\Replies;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RepliesPolicy
{
    use HandlesAuthorization;

    public function performAuthorActions(User $user, Replies $answer)
    {
        return $user->id == $answer->user_id;
    }
}
