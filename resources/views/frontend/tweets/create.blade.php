@extends('layouts.frontend.layout')

@section('title', 'Ask Tweet')

@section('hero-header-left')
    <h2 class="hero-title m-0">Ask a Tweet</h2>
@endsection

@section('hero-body')
    <div class="bg-white p16 br-10">
        <form id="tweetForm" action="{{route('tweets.store')}}" class="m-0" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="mb4">Title</label>
                <input type="text"
                       name="title"
                       id="title"
                       value="{{old('title')}}"
                       class="form-control br-10 p12"
                       placeholder="eg: What is Java?">
                @error('title')
                    <small id="errorHelp" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="body">Body</label>
                <input id="body" type="hidden" id="body" name="body" value="{{ old('body')}}">
                <trix-editor input="body" class="p12" placeholder="Elaborate your tweet..."></trix-editor>
                @error('body')
                    <small id="errorHelp" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="tags">Tags</label>
                <select name="tags[]" id="tags" class="form-control select2" multiple>
                    <option></option>

                    @foreach ($tags as $tag)
                       <option value="{{ $tag->id }}"
                            {{ (old('tags') && (in_array($tag->id, old('tags'))) ? 'selected' : '') }}>
                            {{$tag->name}}
                       </option>
                    @endforeach
                </select>
                @error('tags')
                    <small id="errorHelp" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group text-right">
                <button type="submit" id="tweetBtn" class="btn btn-success py8">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('page-level-styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css">
@endsection

@section('page-level-scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>

    <script>
        $('.select2').select2({
            placeholder: "Select ....",
            allowClear: true
        });

        flatpickr('#published_at', {
            enableTime : true,
            dateFormat : "Y-m-d H:i",
            minDate : new Date(),
        });
        
        
    </script>
@endsection
