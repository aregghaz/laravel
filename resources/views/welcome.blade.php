@extends('page.index')

@section('title')
    welcome!
@endsection
@section('content')
@include('includes.message')
        <div class="row">
            <div class="col-md-6">
                <h3>Registration</h3>
                <form action="{{ route('registration') }}" method="post">
                    <div class="form-group {{$errors->has('email') ? 'has-error': '' }}">
                        <label for="email">Email</label>
                        <input type="text" class="form-control " name="email" id="email" value="{{ Request::old('email') }}">
                    </div>
                    <div class="form-group {{$errors->has('first_name') ? 'has-error': '' }}">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="firstName" title="First Name" value="{{ Request::old('first_name') }}">
                    </div>
                    <div class="form-group {{$errors->has('last_name') ? 'has-error': '' }}">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="lastName" title="Last Name" value="{{ Request::old('last_name') }}">
                    </div>
                    <div class="form-group {{$errors->has('password') ? 'has-error': '' }}">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="lastName" title="Last Name">
                    </div>
                    <button type="submit" class="btn btn-primary">Registration</button>
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                </form>
            </div>
            <div class="col-md-6">
                <h3>Sign in</h3>
                <form action="{{ route('login') }}" method="post">
                    <div class="form-group  {{$errors->has('email') ? 'has-error': '' }}">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" value="{{ Request::old('email') }}">
                    </div>
                    <div class="form-group  {{$errors->has('password') ? 'has-error': '' }}">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="lastName" title="Last Name">
                    </div>
                    <button type="submit" class="btn btn-primary">Sign in</button>
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                </form>
            </div>

        </div>
@endsection