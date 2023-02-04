<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
{
    use HandlesAuthorization;

    public function performAuthorActions(User $user, Answer $answer)
    {
        return $user->id == $answer->user_id;
    }
}
