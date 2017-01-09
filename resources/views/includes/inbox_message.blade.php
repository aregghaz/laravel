@extends('page.index')
@section('title')
    inbox
@endsection
@section('content')
   <div class="col-md-4">
       <div class="list-group">
           @if(!empty($friends))
               @foreach($friends as $key)
               <a href="{{ route('show.message',['userId' => $key->id]) }}" class="list-group-item">{{ $key->last_name }} {{ $key->first_name }}</a>
               @endforeach
               @endif
           </div>
   </div>
<div class="col-md-8" style="border: 1px solid black; height: 500px">
@if(!empty($message))
        @foreach($friends as $key)
            {{$key->message}}
        @endforeach
    @else
    you dont have any message
    @endif
</div>
@endsection