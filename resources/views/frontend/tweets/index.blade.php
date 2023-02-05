@extends('layouts.frontend.layout')

@section('title', 'Tweets')

@section('hero-header-left')
    <h2 class="hero-title m-0">Recent Tweets</h2>
@endsection

@section('hero-header-right')
    <a href="{{route('frontend.tweets.create')}}" class="btn btn-primary py12 px20">Post a tweet</a>
@endsection

@section('hero-body')
    @foreach ($tweets as $tweet)
        <div class="section-card mb12 p16">
            <div class="author-image mr12">
                <img src="{{$tweet->author->avatar}}" alt="User image">
            </div>
            <div class="section-details">
                <div class="section-header">
                    <span class="user-info">Posted by: <a href="{{route('frontend.users.show', $tweet->author->id)}}" class="author-name">{{$tweet->author->name}}</a> {{$tweet->created_date}}</span>
                    <div class="tags-container">
                        <span class="ml12">Tags:</span>
                        <div class="tags">
                            @foreach ($tweet->tags as $tag)
                                <a href="{{route('frontend.tags.show', $tag->id)}}" class="tag badge badge-pill bg-outline-info">{{$tag->name}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="section-body">
                    {{-- <a href="{{route('frontend.tweets.show', $tweet->id)}}"  class="section-title">{{$tweet->title}}</a> --}}
                    <p class="section-content">{!! \Illuminate\Support\Str::limit($tweet->body, 200) !!}</p>
                </div>
                <div class="section-footer d-flex mt8">
                    <div class="section-stats">
                        <div class="stat replies-count">
                            <i class="bi bi-chat-right mr8"></i>{{$tweet->replies_count . " " .\Illuminate\Support\Str::plural('reply', $tweet->replies_count)}}
                        </div>
                        <div class="stat upvotes-count">
                            <i class="bi bi-caret-up-fill mr8"></i>{{$tweet->likes_count . " " .\Illuminate\Support\Str::plural('like', $tweet->likes_count)}}
                        </div>
                        <div class="stat views-count">
                            {{-- <i class="bi bi-eye-fill mr8"></i>{{$tweet->views_count . " " .\Illuminate\Support\Str::plural('view', $tweet->views_count)}} --}}
                        </div>
                    </div>
                    <div class="view-tweet-btn-container">
                        <a href="{{route('frontend.tweets.show', $tweet->id)}}"  class="view-tweet-btn br-10 btn btn-sm btn-outline-primary no-border">View this tweet</a>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endsection

