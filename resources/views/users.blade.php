@extends('page.index')
@section('title')
    Home
@endsection
@section('content')
    @include('includes.message')
    <section class="row new-post">
        <div class=" col-md-3 ">
            <div class="thumbnail">
                <!--  getting user information  -->
            @foreach((array)$userInfo as  $task)

                    <!--  checking if user don't have profile image seting defult image for profile  -->
                    @if(empty($task-> profileImage ))
                        <img src="{{  URL::to('src/image/1.jpg') }}" width="240px" height="180px" alt="...">
                            <!--  if user  have profile getting  profile image user -->
                        @else
                        <img src="/laravel/storage/app/{{$task-> profileImage }} " alt="">
                    @endif
                    <!--  user info -->
                    <div class="caption">
                        <h4>{{$task -> first_name }} {{$task -> last_name }}</h4>
                        <p>{{ $task -> email }}</p>
                        <!--  checking if it not Auth user  -->
                        @if(Auth::user()->id !== $task -> id )
                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#myModal">
                                Messages
                            </button>
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                        </div>
                                        <form action="{{ route('sendMessage') }}" method="post">
                                            <div class="modal-body">
                                                <textarea name="messageText" id="messageText" class="form-control"
                                                          rows="5" title="message"></textarea>
                                            </div>
                                            <input type="hidden" name="userId" value="{{ $task -> id }}">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="submit" class="btn btn-primary">Send Message</button>
                                            </div>
                                            <input type="hidden" name="_token" value="{{  Session::token() }}">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--  Adding friend  -->
                            <form action="{{ route('addFriend') }}" method="post">
                                <input type="hidden" name="friendEmail" value="{{ $task-> email }}">

                                <button class="btn btn-primary" type="submit">Add Friend
                                </button>

                                <input type="hidden" name="_token" value="{{  Session::token() }}">
                            </form>
                        @else
                        <!--  if it  Auth user  -->
                            <form action="{{ route('inbox') }}" method="get">
                                <button class="btn btn-primary" type="submit">inbox</button>
                                <input type="hidden" name="_token" value="{{  Session::token() }}">
                            </form>
                        @endif
                        <form action="{{ route("userImage") }}" method="get">
                            <input type="hidden" name="email" id="userEmailforLike" value="{{ $task -> email }}">
                            <input type="hidden" name="_token" value="{{  Session::token() }}">
                            <button class="btn btn-primary" type="submit">Image</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
        <!--  setting send post  -->
        <div class="col-md-6 ">
            <header>
                <h3>What do you have to say?</h3>
            </header>
            <form action="{{ route('userSend')  }}" method="post">
                <div class="form-group">
                    <textarea name="body" id="new-post" class="form-control" rows="5" title="new-post"></textarea>
                </div>
                <button type="submit" id="sendMessage" class="btn btn-primary">Create Post</button>
                @foreach((array)$userInfo as $task)
                    <input type="hidden" id="inputId" name="idUser" value="{{ $task -> email }}">
                @endforeach
                <input type="hidden" name="_token" value="{{  Session::token() }}">
            </form>
        </div>
        @include('includes.users')
        @include('includes.image')
        @include('includes.friend')
    </section>
    <section class="row posts">
        <div class="col-md-6 col-md-offset-3">
            <header>
                <h3 style="color:  #337ab7">What other people say....</h3>
            </header>
            @foreach($posts as $post)
                <article class="post" data-postid="{{ $post->id }}">
                    <div class="list-group-item active">
                        <p class="list-group-item-heading">{{ $post->body }}</p>
                        <p class="list-group-item-text"> posted by
                            {{$post->name }}on {{ $post->created_at }}
                        </p>
                        <div class="interaction">

                            <a href="#"
                               class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? ' This post like you and': 'like' : 'Like' }}</a>
                            <?php $conter = 0; ?>

                            @foreach($like as $likes)
                                @if($likes == $post->id)
                                    <?php $conter++;
                                    ?>
                                @endif
                            @endforeach
                            <?php if ($conter !== 0) {
                                echo $conter . " people";
                            } ?>

                            |
                            <a href="#"
                               class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0 ? 'You don`t like this post': 'Dislike' : 'Dislike' }}</a>

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
        var urlEdit = '{{ route('edit') }}';
        var urlLike = '{{ route('like') }}';
    </script>
@endsection