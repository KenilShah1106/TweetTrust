@extends('layouts.frontend.layout')

@section('title', 'Questions')

@section('hero-header-left')
    <h2 class="hero-title m-0">Recent Questions</h2>
@endsection

@section('hero-header-right')
    <a href="{{route('frontend.questions.create')}}" class="btn btn-primary py12 px20">Ask a question</a>
@endsection

@section('hero-body')
    @foreach ($questions as $question)
        <div class="section-card mb12 p16">
            <div class="author-image mr12">
                <img src="{{$question->author->avatar}}" alt="User image">
            </div>
            <div class="section-details">
                <div class="section-header">
                    <span class="user-info">Asked by: <a href="{{route('frontend.users.show', $question->author->id)}}" class="author-name">{{$question->author->name}}</a> {{$question->created_date}}</span>
                    <div class="tags-container">
                        <span class="ml12">Tags:</span>
                        <div class="tags">
                            @foreach ($question->tags as $tag)
                                <a href="{{route('frontend.tags.show', $tag->id)}}" class="tag badge badge-pill bg-outline-info">{{$tag->name}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="section-body">
                    <a href="{{route('frontend.questions.show', $question->id)}}"  class="section-title">{{$question->title}}</a>
                    <p class="section-content">{!! \Illuminate\Support\Str::limit($question->body, 200) !!}</p>
                </div>
                <div class="section-footer d-flex mt8">
                    <div class="section-stats">
                        <div class="stat answers-count">
                            <i class="bi bi-chat-right mr8"></i>{{$question->answers_count . " " .\Illuminate\Support\Str::plural('answer', $question->answers_count)}}
                        </div>
                        <div class="stat upvotes-count">
                            <i class="bi bi-caret-up-fill mr8"></i>{{$question->upvotes_count . " " .\Illuminate\Support\Str::plural('upvote', $question->upvotes_count)}}
                        </div>
                        <div class="stat views-count">
                            <i class="bi bi-eye-fill mr8"></i>{{$question->views_count . " " .\Illuminate\Support\Str::plural('view', $question->views_count)}}
                        </div>
                        @if($question->best_answer_id)
                            <span class="stat best-answer-badge">
                                <i class="bi bi-check-circle mr8"></i>Best answer given by {{$question->bestAnswer->author->name}}
                            </span>
                        @endif
                    </div>
                    <div class="view-question-btn-container">
                        <a href="{{route('frontend.questions.show', $question->id)}}"  class="view-question-btn br-10 btn btn-sm btn-outline-primary no-border">View this question</a>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endsection

