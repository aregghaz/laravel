<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div>
                <?php
                if (Auth::check()) {
                $emailUs = Auth::user()->email; ?>
                <p class="navbar-text">Signed in
                    <a href="{{ route('userlink' , ['userEmail' =>  $emailUs ]) }}">
                        <?php print_r(Auth::user()->first_name . " " . Auth::user()->last_name); ?>
                    </a>
                    <?php } ?>
                </p>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ route('account') }}">Account</a></li>
                    <li><a href="{{ route('logout') }}">Log Out</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
