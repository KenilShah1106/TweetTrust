<?php

namespace App\Scopes;

use App\Models\User;

trait UserScopes
{
    public function scopeAdmin($query)
    {
        return $query->where('role', User::ADMIN);
    }
    public function scopeContributor($query)
    {
        return $query->where('role', User::CONTRIBUTOR);
    }
    public function scopeUser($query)
    {
        return $query->where('role', User::USER);
    }
}
