@extends('page.index')
@section('title')
    welcome!!!!!!!!!!!!!!!!!!!!!
@endsection
@section('content')
    @include('includes.message')
    <section class="row new-post">

        <div class=" col-md-3 ">


            @foreach((array)$posts as  $task)
                <div class="thumbnail">
                    <img src="{{  URL::to('src/image/1.jpg') }}" width="240px" height="180px" alt="...">
                    <div class="caption">
                        <h4>{{$task -> first_name }} {{$task -> last_name }}</h4>
                        <p>{{ $task -> email }}</p>
                        <input type="hidden" title="" name="Email" id="email" value="{{ $task -> email }}">
                        <button class="btn btn-primary" type="button">Messages <span class="badge">4</span>
                        </button>
                        <button class="btn btn-primary" type="button">Add Friend</button>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="col-md-6 ">

                <header>
                    <h3>
                        What do you have to say?
                    </h3>
                </header>
                <form action="{{ route('userSend')  }}" method="post">
                    <div class="form-group">
                <textarea name="body" id="new-post" class="form-control" rows="5" title="new-post"
                          placeholder="your post" ></textarea>
                    </div>
                    <button type="submit" id="sendMessage" class="btn btn-primary">Create Post</button>
                    @foreach((array)$posts as $task)
                        <input type="hidden" id="inputId" name="idUser" value="{{ $task -> email }}">
                    @endforeach
                    <input type="hidden" name="_token" value="{{  Session::token() }}">
                </form>
            </div>
        @include('includes.users')
    </section>


    <section class="row posts">
        <div class="col-md-6 col-md-offset-3">
            <header>
                <h3 style="color:  #337ab7">What other people say....</h3>
            </header>


            @foreach($po as $post)
                <article class="post" data-postid="{{ $post->id }}">
                    <div class="list-group-item active">
                            <p class="list-group-item-heading">{{ $post->body }}</p>


                        <p class="list-group-item-text"> posted by {{$post->name }} on {{ $post->created_at }}</p>
                        <div class="interaction">
                            <a href="#">Like</a> |
                            <a href="#">Dislike</a>

                            @if(Auth::user()->id == $post->user_id)
                                |
                                <a class="edit" href="#">Edit</a> |
                                <a href="{{ route('post.delete', ['post_id' => $post ] )}}">Delete</a>
                            @endif

                        </div>
                    </div>

                </article>
            @endforeach


        </div>
    </section>
    <div class="modal fade" tabindex="-1" role="dialog" id="edit-model">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Post</h4>
                </div>
                <div class="modal-body">
                    <form action="">

                        <div class="form-group">
                            <label for="post-body">Edit the post</label>
                            <textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script>
        var token = '{{  Session::token() }}';
        var userUrl = '{{ route('post.Create.User') }}';
        var url = '{{ route('edit') }}';

    </script>

@endsection