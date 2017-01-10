<div class="col-md-3 ">
    <h3>Friends List</h3>
    @if(!empty($friend))
        @foreach($friend as $keys)
            <?php if (!empty($keys->profileImage)) {?>
            <p class="friend"><img src="/laravel/storage/app/{{$keys -> profileImage}}" height="30px" width="30px"
                    class="img-circle freands"> {{$keys ->first_name }} {{ $keys ->last_name}}</p>
                <?php  } else{ ?>
            <p class="friend"><img src="{{  URL::to('src/image/1.jpg') }}" height="30px" width="30px"
                 class="img-circle freands"> {{$keys ->first_name }} {{ $keys ->last_name}}</p>
            <?php } ?>

        @endforeach
    @else
        You don't have friends yet
    @endif


</div>