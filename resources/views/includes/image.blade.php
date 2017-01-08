
@if(!empty($images))

<div class="col-md-3 ">
    <h3>Photo</h3>
    @foreach($images as $key)

        <!-- Button trigger modal -->

            <img   data-toggle="modal" data-target="#{{ $key->id }}" src="/laravel/storage/app/{{ $key->name }}" width="90px" height="90px" id="{{ $key->name }}" >


        <!-- Modal -->
        <div class="modal fade" id="{{ $key->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="/laravel/storage/app/{{ $key->name }}" width="690px" height="690px" id="{{ $key->name }}" >
                        <?php if(Auth::user()->email ==  $key->email ) { ?>
                        <a href="{{ route('imageId', ['imageName' => $key->name  ] )}}">Set pofile pictue</a>
                           <?php }; ?>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>

                </div>
            </div>
        </div>
        @endforeach

</div>
@endif

