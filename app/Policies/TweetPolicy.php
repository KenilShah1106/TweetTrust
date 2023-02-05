<?php

namespace App\Policies;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TweetPolicy
{
    use HandlesAuthorization;

    // public function update(User $user, Tweet $tweet)
    // {
    //     return $user->id == $tweet->user_id;
    // }

    // public function delete(User $user, Tweet $tweet)
    // {
    //     return $user->id == $tweet->user_id;
    // }

    public function performAuthorActions(User $user, Tweet $tweet)
    {
        return $user->id == $tweet->user_id;
    }


}
