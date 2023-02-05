@extends('layouts.frontend.layout')

@section('title', 'Tags')

@section('hero-header-left')
    <h2 class="hero-title m-0">Tags</h2>
    <div class="d-flex align-items-center my8 w100">
        <p class="count m-0">{{$tags->count()}} users</p>
        <ul class="fast-filters list-group list-group-horizontal align-items-center">
            <li class="list-group-item list-group-item-action p-0">
                <a href="" class="fast-filter">Newest</a>
            </li>
            <li class="list-group-item list-group-item-action p-0">
                <a href="" class="fast-filter">Popular</a>
            </li>
        </ul>
        <form action="" class="input-group d-flex search-field w25">
            <input type="text"
                    name="tag-search"
                    value="{{ request('search')}}"
                    class="form-control"
                    placeholder="Search a tag...">
            <div class="input-group-append">
                <button type="submit" name="submit" class="btn btn-sm bg-white">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>
@endsection

@section('hero-header-right')
    <a href="{{route('frontend.tags.create')}}" class="btn btn-primary py12 px20">Create a Tag</a>
@endsection

@section('hero-body')
    @foreach ($tags as $tag)
        <div class="section-card d-inline-block tag-card mb12 mr20 p16">
            <a href="{{route('frontend.tags.show', $tag->id)}}" class="m-0 tag badge badge-pill bg-outline-info">{{$tag->name}}</a>
            <div class="tag-desc my12">
                {!! \Illuminate\Support\Str::limit($tag->desc, 30)!!}
            </div>
            <div class="tweets-count">
                <i class="bi bi-tweet-circle mr8"></i>
                <span>{{$tag->tweets->count()}} tweets</span>
            </div>
        </div>
    @endforeach
@endsection
@section('hero-footer')
    {{ $tags->links() }}
@endsection
