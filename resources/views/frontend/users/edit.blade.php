@extends('layouts.frontend.layout')

@section('title', 'Edit User')

@section('hero-header-left')
    <h2 class="hero-title m-0">Edit Profile</h2>
@endsection

@section('hero-body')
    <div class="p16 br-10">
        <form action="{{route('users.update', $user->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row justify-content-center w-100">
                <div class="form-group">
                    <div class="profile-image">
                        <img src="https://ui-avatars.com/api/?name={{$user->name}}&rounded=true&size=150" alt="User Image">
                    </div>
                </div>
            </div>
            <div class="w-50 mx-auto">
                <div class="row justify-content-between">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text"
                           name="name"
                           value="{{old('name', $user->name)}}"
                           class="form-control box-shadow br-10 p12"
                           placeholder="eg: John Doe">
                        @error('name')
                           <small id="errorHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Location</label>
                        <input type="text"
                           name="location"
                           value="{{old('location', $user->location)}}"
                           class="form-control box-shadow br-10 p12"
                           placeholder="eg: India">
                        @error('location')
                           <small id="errorHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group w-100">
                        <label for="">About</label>
                        <input id="about" type="hidden" name="about" value="{{ old('about', $user->about)}}">
                        <trix-editor input="about" class="box-shadow p12" placeholder="Say something about yourself"></trix-editor>
                        @error('about')
                           <small id="errorHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success py8">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
