@extends('layouts.frontend.layout')

@section('title', 'Edit Answer')

@section('hero-header-left')
    <h2 class="hero-title m-0">Edit a Answer</h2>
@endsection

@section('hero-body')
    <div class="bg-white p16 br-10">
        <form action="{{route('questions.answers.update',[$question->id,$answer->id])}}" class="m-0" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="body">Body</label>
                <input id="body" type="hidden" name="body" value="{{ old('body', $answer->body)}}">
                <trix-editor input="body" class="p12" placeholder="Elaborate your answer..."></trix-editor>
                @error('body')
                    <small id="errorHelp" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group text-right">
                <button type="submit" class="btn btn-success py8">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('page-level-styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css">
@endsection

@section('page-level-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
@endsection
