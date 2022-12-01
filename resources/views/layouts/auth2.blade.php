<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="icon" type="image/x-icon" href="{{ asset('/img/fav.png') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'POS') }}</title>

    @include('layouts.partials.css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    </head>

<body style="background:rgb(38, 45, 66) none repeat scroll 0% 0%;">
    @inject('request', 'Illuminate\Http\Request')
    @if (session('status'))
        <input type="hidden" id="status_span" data-status="{{ session('status.success') }}" data-msg="{{ session('status.msg') }}">
    @endif
          <div class="container-fluid">


                <div class="row  eq-height-row" style="background-color: #662B2B;height: 60px;">
                    <div class="col-lg-2 col-md-2 col-xs-12" style="text-align: left;max-width: 200px;">
                        <select class="form-control " id="change_lang" style="margin: 10px;min-width: 140px">
                            @foreach(config('constants.langs') as $key => $val)
                                <option value="{{$key}}"
                                        @if( (empty(request()->lang) && config('app.locale') == $key)
                                        || request()->lang == $key)
                                        selected
                                        @endif
                                         >
                                    {{$val['full_name']}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xs-12" style="text-align: right;padding-top: 10px;">
                    @if(!($request->segment(1) == 'business' && $request->segment(2) == 'register'))
                        <!-- Register Url -->
                            @if(config('constants.allow_registration'))
                                <a href="{{ route('business.getRegister') }}@if(!empty(request()->lang)){{'?lang=' . request()->lang}} @endif" class="btn bg-maroon btn-flat" style="background-color: #4d4649 !important; "><b>{{ __('business.not_yet_registered')}}</b> {{ __('business.register_now') }}</a>
                                <!-- pricing url -->
                                {{-- @if(Route::has('pricing') && config('app.env') != 'demo' && $request->segment(1) != 'pricing')
                                     &nbsp; <a href="{{ action('\Modules\Superadmin\Http\Controllers\PricingController@index') }}">@lang('superadmin::lang.pricing')</a>
                                 @endif--}}
                            @endif
                        @endif
                        @if($request->segment(1) != 'login')
                            &nbsp; &nbsp;<span class="text-white">{{ __('business.already_registered')}} </span><a href="{{ action('Auth\LoginController@login') }}@if(!empty(request()->lang)){{'?lang=' . request()->lang}} @endif">{{ __('business.sign_in') }}</a>
                        @endif
                    </div>
                </div>
                @yield('content')
          </div>

    @include('layouts.partials.javascripts')
    
    <!-- Scripts -->
    <script src="{{ asset('js/login.js?v=' . $asset_v) }}"></script>
    
    @yield('javascript')

    <script type="text/javascript">
        $(document).ready(function(){
            $('.select2_register').select2();

            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

</html>