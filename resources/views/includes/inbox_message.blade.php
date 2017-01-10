@extends('page.index')
@section('title')
    inbox
@endsection
@section('content')
    <div class="col-md-4">
        <div class="list-group">
            @if(!empty($friends))
                @foreach($friends as $key)
                    <div class="panel panel-primary"><a href="{{ route('inbox',['userId' => $key->id]) }}"
                                                        class="list-group-item">{{ $key->first_name }} {{ $key->last_name }}</a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-md-8">
        <div class="well well-lg">
            @if(!empty($message))
                @foreach($message as $item)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {{$item->message}}<br>
                        </div>
                        <span class="label label-primary">
                            Sending at {{$item->created_at }} by
                            <?php if ($item->from_id == Auth::user()->id) {
                                echo Auth::user()->last_name . "" . Auth::user()->first_name;
                            } else {
                                foreach ($user as $key) {
                                    echo $key->last_name . " " . $key->first_name;
                                }
                            }
                            ?>
                        </span>
                    </div>
                @endforeach
            @else
                you dont have any message
            @endif
        </div>
        <form action="{{ route('Message') }}" method="post">
            <div class="form-group">
                <textarea name="messageText" id="Text" class="form-control" rows="5"
                          title="message">
                </textarea>
            </div>
            <?php
            if(!empty($userId)) {  ?>
            <input type="hidden" id="userId" name="userId" value="<?php echo $userId;?>">
            <?php } ?>
            <div class="form-group">

                <button type="submit" id="inboxMessage" class="btn btn-primary">Send Message</button>
            </div>
            <input type="hidden" name="_token" value="{{  Session::token() }}">
        </form>
    </div>

@endsection
