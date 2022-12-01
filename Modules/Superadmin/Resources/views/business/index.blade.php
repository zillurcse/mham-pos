@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | Business')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'superadmin::lang.all_business' )
        <small>@lang( 'superadmin::lang.manage_business' )</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">

	<div class="box">
        <div class="box-header">
            <h3 class="box-title">&nbsp;
                <input id="search" type="search" class="form-control input-sm" placeholder="Search ..." aria-controls="superadmin_subscription_table">
            </h3>
        	<div class="box-tools">
                <a href="{{action('\Modules\Superadmin\Http\Controllers\BusinessController@create')}}"
                    class="btn btn-block btn-primary">
                	<i class="fa fa-plus"></i> @lang( 'messages.add' )</a>
            </div>
        </div>

        <div class="box-body">
            @can('superadmin')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="business_table">
                        <thead>
                            <tr>
                                <th>@lang( 'superadmin::lang.image' )</th>
                                <th>@lang( 'superadmin::lang.business_name' )</th>
                                <th>@lang( 'superadmin::lang.owner_name' )</th>
                                <th>@lang( 'superadmin::lang.mobile')</th>
                                <th>@lang( 'superadmin::lang.address' )</th>
                                <th>@lang( 'superadmin::lang.package_name' )</th>
                                <th>@lang( 'superadmin::lang.remaining_days' )</th>
                                <th>@lang( 'superadmin::lang.action' )</th>
                            </tr>
                            @foreach ($businesses as $business)
                                @php
                                    $address = $business->locations->first();
                                @endphp

                                <tbody>
                                    <tr style="background-color: #fff;">
                                    <td>
                                        @if(!empty($business->logo))
                                            <img style="height: 80px" src="{{ url( 'uploads/business_logos/' . $business->logo ) }}" alt="Logo">
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($business->owner))
                                            <a href="{{action('\Modules\Superadmin\Http\Controllers\BusinessController@show', [$business->id])}}">
                                                {{$business->name}}
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($business->owner))
                                            <h5 class="widget-user-desc"><i class="fa fa-user-secret" title="Owner"></i> {{ $business->owner->first_name . ' ' . $business->owner->last_name}}</h5>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- /.widget-user-image -->
                                        @if(!empty($business->owner))
                                            <h5 class="widget-user-desc"><i class="fa fa-mobile" title="Owner Contact"></i> {{ $business->owner->contact_no }}</h5>
                                            <h5 class="widget-user-desc"><i class="fa fa-phone" title="Business Contact"></i> {{ $address->mobile }}</h5>
                                            <h5 class="widget-user-desc"><i class="fa fa-phone" title="Business Contact"></i> {{ $address->alternate_number}}</h5>
                                        @endif
                                    </td>
                                    <td>
                                        <address class="widget-user-desc" style="color: #000">
                                            @php
                                                $address_array = [];
                                                $city_landmark = '';
                                                if(!empty($address->city)){
                                                    $city_landmark = $address->city;
                                                }
                                                if(!empty($address->landmark)){
                                                    $city_landmark .= '- ' . $address->landmark;
                                                }
                                                if(!empty($city_landmark)){
                                                    $address_array[] = $city_landmark;
                                                }

                                                $state_country = '';
                                                if(!empty($address->state)){
                                                    $state_country = $address->state;
                                                }
                                                if(!empty($address->country)){
                                                    $state_country .= ' (' . $address->country . ')';
                                                }
                                                if(!empty($state_country)){
                                                    $address_array[] = $state_country;
                                                }
                                                if(!empty($address->zip_code)){
                                                    $address_array[] = __('business.zip_code') . ': ' .$address->zip_code;
                                                }
                                            @endphp
                                            {!! strip_tags(implode('<br>', $address_array), '<br>') !!}
                                        </address>
                                    </td>
                                    <td style="color: #000">
                                        @php
                                            $package = !empty($business->subscriptions[0]) ? optional($business->subscriptions[0])->package : '';
                                        @endphp

                                        @if(!empty($package))
                                            {{$package->name}}
                                        @endif
                                    </td>
                                    <td style="color: #000">
                                        @if(!empty($business->subscriptions[0]))
                                            <h5 class="widget-user-desc">
                                                <i class="fas fa-clock"></i>
                                                @lang('superadmin::lang.remaining', ['days' => \Carbon::today()->diffInDays($business->subscriptions[0]->end_date)])
                                            </h5>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-xs">
                                            <a href="{{action('\Modules\Superadmin\Http\Controllers\BusinessController@show', [$business->id])}}"
                                               class="">@lang('superadmin::lang.manage' )</a>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-xs btn-modal" data-href="{{action('\Modules\Superadmin\Http\Controllers\SuperadminSubscriptionsController@create', ['business_id' => $business->id])}}" data-container=".view_modal">
                                            @lang('superadmin::lang.add_subscription' )
                                        </button>
                                        <br>&nbsp;<br>
                                        @if($business->is_active == 1)
                                            <a href="{{action('\Modules\Superadmin\Http\Controllers\BusinessController@toggleActive', [$business->id, 0])}}"
                                               class="btn btn-danger btn-xs link_confirmation">@lang('messages.deactivate')
                                            </a>
                                        @else
                                            <a href="{{action('\Modules\Superadmin\Http\Controllers\BusinessController@toggleActive', [$business->id, 1])}}"
                                               class="btn btn-success btn-xs link_confirmation">@lang('messages.activate' )
                                            </a>
                                        @endif

                                        @if($business_id != $business->id)
                                            <a href="{{action('\Modules\Superadmin\Http\Controllers\BusinessController@destroy', [$business->id])}}"
                                               class="btn btn-danger btn-xs delete_business_confirmation">@lang('messages.delete' )
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                                @endforeach
                        </thead>
                    </table>
                </div>


                <div class="col-md-12">
                    {{ $businesses->links() }}
                </div>

            @endcan
        </div>

    </div>

    <div class="modal fade brands_modal" tabindex="-1" role="dialog"
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection

@section('javascript')

<script type="text/javascript">
    $(document).on('click', 'a.delete_business_confirmation', function(e){
        e.preventDefault();
        swal({
            title: LANG.sure,
            text: "Once deleted, you will not be able to recover this business!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((confirmed) => {
            if (confirmed) {
                window.location.href = $(this).attr('href');
            }
        });
    });

    $(document).ready(function(){

        // DataTable
        $('#empTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/superadmin/superadmin-subscription",
            columns: [
                { data: 'id' },
                { data: 'username' },
                { data: 'name' },
                { data: 'email' },
            ]
        });

    });
</script>
<script type="text/javascript">
    $('#search').on('keyup',function(){
        $value=$(this).val();
        $.ajax({
            type : 'get',
            url : '{{URL::to('/superadmin/search')}}',
            data:{'search':$value},
            success:function(data){
                $('tbody').html(data);
            }
        });
    })
</script>

@endsection
