<?php

namespace App\Scopes;

use App\Models\User;

trait TweetScopes
{
    public function scopeSearch($query)
    {
        $search = request('search');
        if($search) {
            return $query->where('body', 'like', "%$search%");
        }
        return $search;
    }

}
