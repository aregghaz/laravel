<div class="col-md-3 ">
    <h3>Friends List</h3>
    @if(!empty($friend))
        @foreach($friend as $key)
            <?php if (!empty($key->profileImage)) {?>
            <p class="friend"><img src="/laravel/storage/app/{{$key -> profileImage}}" height="30px" width="30px"
                    class="img-circle freands"> {{$key ->first_name }} {{ $key ->last_name}}</p>
                <?php  } else{ ?>
            <p class="friend"><img src="{{  URL::to('src/image/1.jpg') }}" height="30px" width="30px"
                 class="img-circle freands"> {{$key ->first_name }} {{ $key ->last_name}}</p>
            <?php } ?>

        @endforeach
    @else
        you have no friends
    @endif


</div>