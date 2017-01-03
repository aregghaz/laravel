<div class="col-md-3 ">
    <h3>Users List</h3>
    <ul class="list-group list_users" id="listUsers">
        @foreach((array)$users as $user)
            <form action="{{ route("post.Create.User")  }}" method="get">
                <li class="list-group-item">
                    <button>{{ $user->first_name }} {{ $user->last_name }}
                        <input type="hidden" name="userId" title="title" value="{{ $user->id }}">
                        <input type="hidden" name="userEmail" title="title" value="{{ $user->email }}">
                    </button>
                </li>
            </form>
        @endforeach
    </ul>
</div>