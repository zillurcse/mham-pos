<section class="no-print">
    <nav class="navbar navbar-default bg-white m-4">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li @if(request()->segment(2) == 'assets') class="active" @endif>
                        <a href="{{action('\Modules\Assets\Http\Controllers\AssetsController@index')}}">
                            <i class="fa fa-user"></i>
                          @lang('assets::lang.assets_titel')
                        </a>
                    </li>

                    <li @if(request()->segment(2) == 'consumed') class="active" @endif>
                        <a href="{{action('\Modules\Assets\Http\Controllers\AssetsController@consumed')}}">
                            <i class="fa fa-user"></i>

                        </a>
                    </li>

                   </ul>

            </div>
            <!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section>