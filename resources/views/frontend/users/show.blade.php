@extends('layouts.frontend.layout')

@section('title', 'User')

@section('hero-header-left')
    <h2 class="hero-title m-0">User Profile</h2>
@endsection

@can('update', $user)
    @section('hero-header-right')
        <a href="{{route('frontend.users.edit', $user->id)}}" class="btn btn-info py12 px20">Edit Profile</a>
    @endsection
@endcan

@section('hero-body')
    <div class="row">
        <div class="profile-image">
            <img src="https://ui-avatars.com/api/?name={{$user->name}}&rounded=true&size=150" alt="User Image">
        </div>
        <div class="profile-details mx20">
            <h2 class="user-name mb4">{{$user->name}}</h2>
            <p class="user-location mb4"><i class="bi bi-geo-alt-fill"></i> {{$user->location}}</p>
            <div class="user-stats">
                <p class="stat-container mb4">Reputation earned - <span class="stat">{{$user->reputation}}</span></p>
                <p class="stat-container mb4">Questions asked - <span class="stat">{{$user->questions->count()}}</span></p>
                <p class="stat-container mb4">Answers given - <span class="stat">{{$user->answers->count()}}</span></p>
            </div>
            <p class="user-about mb4">{{$user->about}}</p>

        </div>
    </div>
    <div class="row mt20">
        <div class="user-activity w100">
            <p class="section-heading">User Activity</p>
            @if($user->questions->count() > 0)
                <ul class="fast-filters list-group list-group-horizontal align-items-center w25 mx-0">
                    <li class="list-group-item list-group-item-action p-0">
                        <a href="" class="fast-filter">Questions asked</a>
                    </li>
                    <li class="list-group-item list-group-item-action p-0">
                        <a href="" class="fast-filter">Answers given</a>
                    </li>
                </ul>
                <table class="table table-bordered mb-0 mt8">
                    <thead class="thead-dark">
                        <tr>
                            <th>Question Title</th>
                            <th class="text-center">Got Answer</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question)
                            <tr>
                                <td>{{$question->title}}</td>
                                <td class="text-center status"><i class="{{$question->answer_style}}"></i></td>
                                <td>July 26, 2021 at 12:05</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-right mb16 mt8">
                    See all <strong><a href="">Questions</a></strong> and <strong><a href="">Answers -></a></strong>
                </div>
                <div class="alert bg-outline-info alert-dismissible fade show" role="alert">
                    <strong class="tips">
                        Quick Tip:
                        <span class="tip mx16">
                            <i class="bi bi-check-circle mr2"></i> Question was answered
                        </span>
                        <span class="tip mr16">
                            <i class="bi bi-check-circle-fill text-success mr2"></i> Question has best answer
                        </span>
                        <span class="mr16">
                            <i class="bi bi-x-circle-fill text-danger mr2"></i> Question was not answered
                        </span>
                    </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @else
                <div class="empty-state-card">
                    <div class="empty-state-card-body">
                        <img src="{{asset('frontend/assets/illustrations/user-activity.svg')}}" alt="empty activity">
                        <p class="mt20 mb20">All the activities done by user will be displayed here</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
