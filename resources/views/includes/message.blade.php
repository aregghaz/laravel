@if(count($errors)>0)
    <div class="row">
        <div class="col-md-4 col-md-offset-4 error alert alert-danger" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

    </div>
@endif
@if(Session::has('message'))
    <div class="row">
        <div class="col-md-4 col-md-offset-4 alert alert-success" role="alert">
            <ul>

                    <li>{{ Session::get('message') }}</li>

            </ul>
        </div>
    </div>

@endif
