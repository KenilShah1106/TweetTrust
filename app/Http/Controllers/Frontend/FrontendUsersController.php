<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FrontendUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:update,user')->only('edit');
    }
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('frontend.users.index', compact(['users']));
    }
    public function show(User $user)
    {
        $tweets = $user->tweets()->latest()->paginate(3);
        return view('frontend.users.show', compact(['user', 'tweets']));
    }
    public function edit(User $user)
    {
        return view('frontend.users.edit', compact(['user']));
    }
    public function notifications()
    {
        $notifications = auth()->user()->notifications()->latest()->simplePaginate(10);
        return view('frontend.users.notifications', compact(['notifications']));
    }
}
