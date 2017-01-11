<div class="col-md-3 ">
    <h3>Users List</h3>
    <ul class="list-group list_users" id="listUsers">
        @foreach($users as $user)
            <form action="{{ route("post.Create.User")  }}" method="get">
                <div class="list-group" style="margin-bottom: 0;">
                        <input type="hidden" name="userId" title="title" value="{{ $user->id }}">
                        <input type="hidden" name="userEmail" title="title" value="{{ $user->email }}">
                        <button type="submit" class="list-group-item list-group-item-info">{{ $user->first_name }} {{ $user->last_name }}</button>
                </div>
            </form>
        @endforeach
    </ul>
</div>