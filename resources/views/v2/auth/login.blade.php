@extends('layouts.auth2_old')
@section('title', __('lang_v1.login'))

@section('content')

            <div class="" style="background-color: white; padding: 10px 30px 30px 30px;border-radius: 10px;max-width: 350px;margin: auto; margin-top: 70px;">

                <div>

                    <h3>
{{--                        {{env('APP_TITLE','AZHA-ERP')}}--}}
                        <img src="{{ asset('/img/PNG LOGO00004.png') }}" alt="" style="height: 120px; width: 300px; object-fit: cover">
                    </h3>

                </div>

               {{-- <div class="login-header" style="text-align: center;margin-bottom: 20px;">
                    <p class="form-header ">@lang('lang_v1.login')</p>
                </div>--}}

                <form method="POST" action="{{ route('login') }}" id="login-form">
                    {{ csrf_field() }}

                    {{--User name--}}
                    <div class="form-group has-feedback {{ $errors->has('username') ? ' has-error' : '' }}" >
                        @php
                            $username = old('username');
                            $password = null;
                            if(config('app.env') == 'demo'){
                                $username = 'admin';
                                $password = '123456';

                                $demo_types = array(
                                    'all_in_one' => 'admin',
                                    'super_market' => 'admin',
                                    'pharmacy' => 'admin-pharmacy',
                                    'electronics' => 'admin-electronics',
                                    'services' => 'admin-services',
                                    'restaurant' => 'admin-restaurant',
                                    'superadmin' => 'superadmin',
                                    'woocommerce' => 'woocommerce_user',
                                    'essentials' => 'admin-essentials',
                                    'manufacturing' => 'manufacturer-demo',
                                );

                                if( !empty($_GET['demo_type']) && array_key_exists($_GET['demo_type'], $demo_types) ){
                                    $username = $demo_types[$_GET['demo_type']];
                                }
                            }
                        @endphp
                        <input id="username" type="text" class="form-control" name="username" value="{{ $username }}" required autofocus placeholder="@lang('lang_v1.username')">
                        <span class="fa fa-user form-control-feedback"></span>
                        @if ($errors->has('username'))
                            <span class="help-block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                        @endif
                    </div>

                    {{--Password--}}
                    <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" type="password" class="form-control" name="password"
                               value="{{ $password }}" required placeholder="@lang('lang_v1.password')">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                            <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                        @endif
                    </div>


                    <div class="form-group">
                        <div class="checkbox icheck">
                            <label style="color: #0c0c0c">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('lang_v1.remember_me')
                            </label>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-flat btn-login" style="border-radius: 10px;height: 50px;font-size: 19px; background-color: #473272 !important;">@lang('lang_v1.login')</button>

                   </div>
                    <div class="form-group" style="padding-bottom: 9px;">
                        @if(config('app.env') != 'demo')
                            <a href="{{ route('password.request') }}" class="pull-right" style="color: #0c0c0c">
                                @lang('lang_v1.forgot_your_password')
                            </a>
                        @endif
                        @php
                            $system_settings = App\System::getProperties(['superadmin_enable_register_tc', 'superadmin_register_tc'], true);
                        @endphp
                            @if(!empty($system_settings['superadmin_enable_register_tc']))
                                <div>
                                    <label>
                                        {!! Form::checkbox('accept_tc', 0, false, ['required', 'class' => 'input-icheck']); !!}
                                        <u><a style="color: #1572e8" class="terms_condition cursor-pointer" href="http://terms-and-conditions.mhamcloud.com/" target="_blank">
                                                @lang('lang_v1.accept_terms_and_conditions') <i></i>
                                            </a></u>
                                    </label>
{{--                                    @include('business.partials.terms_conditions')--}}
                                </div>
                            @endif
                    </div>

                       </form>

            </div>

            <div class="" style="text-align: center;background-color: white; padding: 6px 10px 15px 10px;border-radius: 10px;max-width: 350px;margin: auto; margin-top: 70px;">
              <h3>لتجربة البرنامج يمكنك الضغط هنا </h3>
                <button type="button" class="btn btn-flat btn-login" style="border-radius: 10px;height: 50px;font-size: 19px; color: #fff !important;  background-color: #473272 !important;" id="test" >تجربة البرنامج </button>

            </div>



    @if(config('app.env') == 'demo')
    <div class="col-md-12 col-xs-12" style="padding-bottom: 30px;">
        @component('components.widget', ['class' => 'box-primary', 'header' => '<h4 class="text-center">Demo Shops <small><i> Demos are for example purpose only, this application <u>can be used in many other similar businesses.</u></i></small></h4>'])

            <a href="?demo_type=all_in_one" class="btn btn-app bg-olive demo-login" data-toggle="tooltip" title="Showcases all feature available in the application." data-admin="{{$demo_types['all_in_one']}}"> <i class="fas fa-star"></i> All In One</a>

            <a href="?demo_type=pharmacy" class="btn bg-maroon btn-app demo-login" data-toggle="tooltip" title="Shops with products having expiry dates." data-admin="{{$demo_types['pharmacy']}}"><i class="fas fa-medkit"></i>Pharmacy</a>

            <a href="?demo_type=services" class="btn bg-orange btn-app demo-login" data-toggle="tooltip" title="For all service providers like Web Development, Restaurants, Repairing, Plumber, Salons, Beauty Parlors etc." data-admin="{{$demo_types['services']}}"><i class="fas fa-wrench"></i>Multi-Service Center</a>

            <a href="?demo_type=electronics" class="btn bg-purple btn-app demo-login" data-toggle="tooltip" title="Products having IMEI or Serial number code."  data-admin="{{$demo_types['electronics']}}" ><i class="fas fa-laptop"></i>Electronics & Mobile Shop</a>

            <a href="?demo_type=super_market" class="btn bg-navy btn-app demo-login" data-toggle="tooltip" title="Super market & Similar kind of shops." data-admin="{{$demo_types['super_market']}}" ><i class="fas fa-shopping-cart"></i> Super Market</a>

            <a href="?demo_type=restaurant" class="btn bg-red btn-app demo-login" data-toggle="tooltip" title="Restaurants, Salons and other similar kind of shops." data-admin="{{$demo_types['restaurant']}}"><i class="fas fa-utensils"></i> Restaurant</a>
            <hr>

            <i class="icon fas fa-plug"></i> Premium optional modules:<br><br>

            <a href="?demo_type=superadmin" class="btn bg-red-active btn-app demo-login" data-toggle="tooltip" title="SaaS & Superadmin extension Demo" data-admin="{{$demo_types['superadmin']}}"><i class="fas fa-university"></i> SaaS / Superadmin</a>

            <a href="?demo_type=woocommerce" class="btn bg-woocommerce btn-app demo-login" data-toggle="tooltip" title="WooCommerce demo user - Open web shop in minutes!!" style="color:white !important" data-admin="{{$demo_types['woocommerce']}}"> <i class="fab fa-wordpress"></i> WooCommerce</a>

            <a href="?demo_type=essentials" class="btn bg-navy btn-app demo-login" data-toggle="tooltip" title="Essentials & HRM (human resource management) Module Demo" style="color:white !important" data-admin="{{$demo_types['essentials']}}">
                    <i class="fas fa-check-circle"></i>
                    Essentials & HRM</a>
                    
            <a href="?demo_type=manufacturing" class="btn bg-orange btn-app demo-login" data-toggle="tooltip" title="Manufacturing module demo" style="color:white !important" data-admin="{{$demo_types['manufacturing']}}">
                    <i class="fas fa-industry"></i>
                    Manufacturing Module</a>

            <a href="?demo_type=superadmin" class="btn bg-maroon btn-app demo-login" data-toggle="tooltip" title="Project module demo" style="color:white !important" data-admin="{{$demo_types['superadmin']}}">
                    <i class="fas fa-project-diagram"></i>
                    Project Module</a>

            <a href="?demo_type=services" class="btn btn-app demo-login" data-toggle="tooltip" title="Advance repair module demo" style="color:white !important; background-color: #bc8f8f" data-admin="{{$demo_types['services']}}">
                    <i class="fas fa-wrench"></i>
                    Advance Repair Module</a>

            <a href="{{url('docs')}}" target="_blank" class="btn btn-app" data-toggle="tooltip" title="Advance repair module demo" style="color:white !important; background-color: #2dce89">
                    <i class="fas fa-network-wired"></i>
                    Connector Module / API Documentation</a>
        @endcomponent   
    </div>
    @endif


@stop



@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        $('#change_lang').change( function(){
           
            window.location = "{{ route('login') }}?lang=" + $(this).val();
        });

        $('#test').click( function (e) {
           e.preventDefault();
           $('#username').val('admin');
           $('#password').val("123456");
           $('form#login-form').submit();
        });
    })
</script>
@endsection
