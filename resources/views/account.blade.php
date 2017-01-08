@extends('page.index')
@section('title')
    {{  $user ->first_name }} {{  $user ->last_name }} account
@endsection
@section('content')
    @include('includes.message')
    <form method="post" action="{{ route('edit.account') }}" enctype="multipart/form-data">
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" name="lastName" id="lastName" value="{{  $user ->last_name }} ">
        </div>
        <div class="form-group">
            <label for="firstNAme">First Name</label>
            <input type="text" name="firstName" class="form-control" id="firstNAme" value="{{  $user ->first_name }} ">
        </div>
        <div class="form-group">
            <label for="inputFile">User image</label>
            <input type="file" id="File" name="image">
        </div>
        <input type="hidden" name="_token" value="{{  Session::token() }}">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <div class="container links">
        <a href="{{ route('userlink' , ['userEmail' =>  $user->email ]) }}" class="active ">Back to home page</a>
    </div>

@endsection