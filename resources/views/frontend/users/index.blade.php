@extends('layouts.frontend.layout')

@section('title', 'Users')

@section('hero-header-left')
    <h2 class="hero-title m-0">Users</h2>
    <div class="d-flex align-items-center my8 w100">
        <p class="count m-0">{{$users->count()}} users</p>
        <ul class="fast-filters list-group list-group-horizontal align-items-center">
            <li class="list-group-item list-group-item-action p-0">
                <a href="" class="fast-filter">All</a>
            </li>
            <li class="list-group-item list-group-item-action p-0">
                <a href="" class="fast-filter">New</a>
            </li>
            {{-- <li class="list-group-item list-group-item-action p-0">
                <a href="" class="fast-filter">Reputation</a>
            </li>
            <li class="list-group-item list-group-item-action p-0">
                <a href="" class="fast-filter">Admins</a>
            </li>
            <li class="list-group-item list-group-item-action p-0">
                <a href="" class="fast-filter">Contributors</a>
            </li> --}}
        </ul>
        <form action="" class="input-group d-flex search-field w25">
            <input type="text"
                    name="user-search"
                    value="{{ request('search')}}"
                    class="form-control"
                    placeholder="Search a user...">
            <div class="input-group-append">
                <button type="submit" name="submit" class="btn btn-sm bg-white">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>
@endsection

@section('hero-body')
    <div class="d-flex flex-wrap">
        @foreach ($users as $user)
            <div class="section-card d-inline-block user-card mb12 mr20 p16">
                <div class="user-card-header">
                    <div class="user-image">
                        <img src="{{asset($user->avatar)}}" alt="User image">
                    </div>
                    <div class="user-details">
                        <a href="{{route('frontend.users.show', $user->id)}}" class="user-name">{{$user->name}}</a>
                        <span class="user-location">{{$user->location}}</span>
                    </div>
                </div>
                <div class="user-stats">
                    <p><span class="stat">{{$user->reputation}}</span> reputation</p>
                    <p><span class="stat">{{$user->replies->count()}}</span> replies</p>
                    <p><span class="stat">{{$user->tweets->count()}}</span> tweets</p>
                </div>
                <span class="m-0 badge badge-pill bg-outline-primary">{{$user->user_role}}</span>
            </div>
        @endforeach
    </div>
@endsection
@section('hero-footer')
    {{ $users->links() }}
@endsection
