<?php

namespace App\Scopes;

use App\Models\User;

trait TagScopes
{
    public function scopeSearch($query)
    {
        $search = request('search');
        if($search) {
            return $query->where('name', 'like', "%$search%");
        }
        return $query;
    }

}
