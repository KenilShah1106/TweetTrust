@extends('layouts.frontend.layout')

@section('title', 'Notifications')

@section('hero-header-left')
    <h2 class="hero-title m-0">Notifications</h2>
@endsection

@section('hero-body')
    <ul class="section-card list-group">
        @foreach ($notifications as $notification)
            <li class="list-group-item">
                @switch($notification->type)
                    @case(\App\Notifications\Tweets\NewTweetAdded::class)
                        <div class="d-flex justify-content-between">
                            <div>
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>{{$notification->data['msg']}} - </span>
                                <a href="{{route('frontend.tweets.show', $notification->data['tweet']['id'])}}"class="text-dark" >
                                    <strong class="mx-1">
                                        <i class="bi bi-tweet-circle mr-1" title="Icon representing tweet asked"></i>
                                        See the tweet
                                    </strong>
                                </a>
                                @if ($notification->read_at == NULL)
                                  <span class="badge badge-sm bg-danger text-white ml-1">NEW</span>
                                @endif
                            </div>
                            <div>
                                <span class="text-muted float-right">{{$notification->created_at->diffForHumans()}}</span>
                            </div>
                        </div>
                        @break
                @endswitch
        @endforeach
    </ul>
    {{auth()->user()->unreadNotifications->markAsRead()}}
@endsection

