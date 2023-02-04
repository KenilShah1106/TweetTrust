@extends('layouts.frontend.layout')

@section('title', 'Create a Tag')

@section('hero-header-left')
    <h2 class="hero-title m-0">Create a Tag</h2>
@endsection

@section('hero-body')
    <div class="bg-white p16 br-10">
        <form action="{{route('tags.store')}}" class="m-0" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="mb4">Name</label>
                <input type="text"
                       name="name"
                       value="{{old('name')}}"
                       class="form-control br-10 p12"
                       placeholder="eg: programming">
                @error('name')
                    <small id="errorHelp" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label class="mb4">Description</label>
                <textarea type="text"
                       name="desc"
                       value="{{old('desc')}}"
                       class="form-control br-10 p12"
                       placeholder="Give some brief information about the tag"></textarea>
                @error('desc')
                    <small id="errorHelp" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group text-right">
                <button type="submit" class="btn btn-success py8">Submit</button>
            </div>
        </form>
    </div>
@endsection

