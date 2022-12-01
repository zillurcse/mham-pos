@extends('v2.metronic.index')
@if($role->id)
    @section('title', __('role.edit_role'))
@else
  @section('title', __('role.add_role'))
@endif
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        @if($role->id)
          <h1>@lang( 'role.edit_role' )</h1>
        @else
            <h1>@lang( 'role.add_role' )</h1>
        @endif

    </section>

    <!-- Main content -->
    <section class="content">
        @component('v2.components.widget', ['class' => 'box-primary'])
            @if($role->id)
                {!! Form::open(['url' => action('RoleController@update', [$role->id]), 'id' => 'role_form' ]) !!}
                <input name="_method" type="hidden" value="PUT">
            @else
                {!! Form::open(['url' => action('RoleController@store'), 'method' => 'post', 'id' => 'role_add_form' ]) !!}
                <input name="_method" type="hidden" value="post">
            @endif

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('name', __( 'user.role_name' ) . ':*') !!}
                        {!! Form::text('name', str_replace( '#' . auth()->user()->business_id, '', $role->name) , ['class' => 'form-control', 'required', 'placeholder' => __( 'user.role_name' ) ]); !!}
                    </div>
                </div>
            </div>
            @if(in_array('service_staff', $enabled_modules))
                <div class="row">
                    <div class="col-md-2">
                        <h4>@lang( 'lang_v1.user_type' )</h4>
                    </div>
                    <div class="col-md-9 col-md-offset-1">
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('is_service_staff', 1, $role->is_service_staff,
                                    [ 'class' => '']); !!} {{ __( 'restaurant.service_staff' ) }}
                                </label>
                                @show_tooltip(__('restaurant.tooltip_service_staff'))


                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-3">
                    <label>@lang( 'user.permissions' ):</label>
                </div>
            </div>
            <div class="row check_group">
                <div class="col-md-1">
                    <h4>@lang( 'role.user' )</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox-list">
                                <label class="checkbox">
                            <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                        </label>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'user.view', in_array('user.view', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.user.view' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'user.create', in_array('user.create', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.user.create' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'user.update', in_array('user.update', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.user.update' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'user.delete', in_array('user.delete', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.user.delete' ) }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row check_group">
                <div class="col-md-1">
                    <h4>@lang( 'user.roles' )</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox-list">
                                <label class="checkbox">
                            <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                        </label>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'roles.view', in_array('roles.view', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'lang_v1.view_role' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'roles.create', in_array('roles.create', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.add_role' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'roles.update', in_array('roles.update', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.edit_role' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'roles.delete', in_array('roles.delete', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'lang_v1.delete_role' ) }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row check_group">
                <div class="col-md-1">
                    <h4>@lang( 'role.supplier' )</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox-list">
                                <label class="checkbox">
                            <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                        </label>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'supplier.view', in_array('supplier.view', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'lang_v1.view_all_supplier' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'supplier.view_own', in_array('supplier.view_own', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'lang_v1.view_own_supplier' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'supplier.create', in_array('supplier.create', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.supplier.create' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'supplier.update', in_array('supplier.update', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.supplier.update' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'supplier.delete', in_array('supplier.delete', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.supplier.delete' ) }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row check_group">
                <div class="col-md-1">
                    <h4>@lang( 'role.customer' )</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox-list">
                                <label class="checkbox">
                            <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                        </label>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'customer.view', in_array('customer.view', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'lang_v1.view_all_customer' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'customer.view_own', in_array('customer.view_own', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'lang_v1.view_own_customer' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'customer.create', in_array('customer.create', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.customer.create' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'customer.update', in_array('customer.update', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.customer.update' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'customer.delete', in_array('customer.delete', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.customer.delete' ) }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row check_group">
                <div class="col-md-1">
                    <h4>@lang( 'business.product' )</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox-list">
                                <label class="checkbox">
                            <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                        </label>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'product.view', in_array('product.view', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.product.view' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'product.create', in_array('product.create', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.product.create' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'product.update', in_array('product.update', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.product.update' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'product.delete', in_array('product.delete', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.product.delete' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'product.opening_stock', in_array('product.opening_stock', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'lang_v1.add_opening_stock' ) }}
                            </label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'stcok_compares', in_array('stcok_compares', $role_permissions),
                                [ 'class' => '']); !!}مقارنة المخازن
                            </label>
                        </div>
                    </div>



                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'view_purchase_price', in_array('view_purchase_price', $role_permissions),['class' => '']); !!}
                                {{ __('lang_v1.view_purchase_price') }}
                            </label>
                            @show_tooltip(__('lang_v1.view_purchase_price_tooltip'))
                        </div>
                    </div>
                </div>
            </div>

            @if(in_array('purchases', $enabled_modules) || in_array('stock_adjustment', $enabled_modules) )
                <div class="row check_group">
                    <div class="col-md-1">
                        <h4>@lang( 'role.purchase' )</h4>
                    </div>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">




                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'purchase.view', in_array('purchase.view', $role_permissions),
                                    [ 'class' => '']); !!} عرض المشتريات
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'purchase.porduct_qty_setting', in_array('purchase.porduct_qty_setting', $role_permissions),
                                    [ 'class' => '']); !!} ضبط كمية المنتجات والمخزون الهالك
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'purchase.create', in_array('purchase.create', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.purchase.create' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'purchase.edit_composeit_discount', in_array('purchase.edit_composeit_discount', $role_permissions),
                                    [ 'class' => '']); !!} تعديل قيم الخصم المركب اثناء الشراء
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'purchase.update', in_array('purchase.update', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.purchase.update' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'purchase.delete', in_array('purchase.delete', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.purchase.delete' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'purchase.payments', in_array('purchase.payments', $role_permissions),['class' => '']); !!}
                                    اضافة دفع شراء
                                </label>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'purchase_payment.edit', in_array('purchase_payment.edit', $role_permissions),['class' => '']); !!}
                                    تعديل دفع الشراء
                                </label>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'purchase_payment.delete', in_array('purchase_payment.delete', $role_permissions),['class' => '']); !!}
                                    حذف دفغ الشراء
                                </label>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'purchase.update_status', in_array('purchase.update_status', $role_permissions),['class' => '']); !!}
                                    {{ __('lang_v1.update_status') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'view_own_purchase', in_array('view_own_purchase', $role_permissions),['class' => '']); !!}
                                    {{ __('lang_v1.view_own_purchase') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'purchase_return.view', in_array('purchase_return.view', $role_permissions),
                                    [ 'class' => '']); !!} مرتجع المشتريات
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'purchase_return.create', in_array('purchase_return.create', $role_permissions),
                                    [ 'class' => '']); !!} اضافة مرتجع المشتريات
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-----------------for stocktransfer -------------------->
                <div class="row check_group">
                    <div class="col-md-1">
                        <h4>تحويلات المخازن </h4>
                    </div>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">



                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'stock_transfer', in_array('stock_transfer', $role_permissions),
                                    [ 'class' => '']); !!}عرض تحويلات المخازن
                                </label>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'stock_transfer.create_pending', in_array('stock_transfer.create_pending', $role_permissions),
                                    [ 'class' => '']); !!} انشاء وتعديل  تحويل مخازن -طلب -
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'stock_transfer.create_confirmed', in_array('stock_transfer.create_confirmed', $role_permissions),
                                    [ 'class' => '']); !!} انشاء وتعديل  تحويل مخازن -  تأكيد-
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'stock_transfer.create_in_transit', in_array('stock_transfer.create_in_transit', $role_permissions),
                                    [ 'class' => '']); !!} انشاء وتعديل  تحويل مخازن - تسليم -

                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'stock_transfer.create_completed', in_array('stock_transfer.create_completed', $role_permissions),
                                    [ 'class' => '']); !!} انشاء وتعديل  تحويل مخازن - استلام --

                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <!-----------------for stocktacking -------------------->
                <div class="row check_group">
                    <div class="col-md-1">
                        <h4>جرد المخازن</h4>
                    </div>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'stocktacking.view', in_array('stocktacking.view', $role_permissions),
                                    [ 'class' => '']); !!} اظهار صفحة الجرد
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'stocktacking.show_qty_available', in_array('stocktacking.show_qty_available', $role_permissions),
                                    [ 'class' => '']); !!} اظهار الكمية الحالية أثناء الجرد
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'stocktacking.create', in_array('stocktacking.create', $role_permissions),
                                    [ 'class' => '']); !!} انشاء جرد
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'stocktacking.changeStatus', in_array('stocktacking.changeStatus', $role_permissions),
                                    [ 'class' => '']); !!} تغير حالة الجرد
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'stocktacking.products', in_array('stocktacking.products', $role_permissions),
                                    [ 'class' => '']); !!}  جرد المنتجات
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'stocktacking.delete_form_stocktacking', in_array('stocktacking.delete_form_stocktacking', $role_permissions),
                                    [ 'class' => '']); !!}  حذف منتج من الجرد
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'stocktacking.report', in_array('stocktacking.report', $role_permissions),['class' => '']); !!}
                                    عرض تقارير المنتجات المجرودة
                                </label>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'stocktacking.liquidation', in_array('stocktacking.liquidation', $role_permissions),['class' => '']); !!}
                                    عمل تصفية
                                </label>
                            </div>
                        </div>


                    </div>
                </div>

            @endif

        {{--Sells Permissions--}}
            <div class="row check_group">
                <div class="col-md-1">
                    <h4>@lang( 'sale.sale' )</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox-list">
                                <label class="checkbox">
                            <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                        </label>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'sales.print_invoice', in_array('sales.print_invoice', $role_permissions),
                                [ 'class' => '']); !!} طباعة الفاتورة
                            </label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'sales.pos_meswada', in_array('sales.pos_meswada', $role_permissions),
                                [ 'class' => '']); !!}     عمل مسودة
                            </label>
                        </div>
                    </div>


                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sales.edit_composite_discount', in_array('sales.edit_composite_discount', $role_permissions),
                                    [ 'class' => '']); !!}      تعديل الخصم المركب في نقطة البيع
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sales.price_offer', in_array('sales.price_offer', $role_permissions),
                                    [ 'class' => '']); !!}    عمل عرض سعر
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sales.puse_sell', in_array('sales.puse_sell', $role_permissions),
                                    [ 'class' => '']); !!}     تعليق عملية بيع
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sales.puse_show', in_array('sales.puse_show', $role_permissions),
                                    [ 'class' => '']); !!}عرض عمليات البيع المعلقة
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sales.sell_agel', in_array('sales.sell_agel', $role_permissions),
                                    [ 'class' => '']); !!}     بيع اجل
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sales.pay_card', in_array('sales.pay_card', $role_permissions),
                                    [ 'class' => '']); !!}     بطاقة دفع
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sales.multi_pay_ways', in_array('sales.multi_pay_ways', $role_permissions),
                                    [ 'class' => '']); !!}     طرق تحصيل متعددة
                                </label>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sales.sell_in_cash', in_array('sales.sell_in_cash', $role_permissions),
                                    [ 'class' => '']); !!}     بيع كاش
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sales.less_than_purchase_price', in_array('sales.less_than_purchase_price', $role_permissions),
                                    [ 'class' => '']); !!}     البيع باقل من سعر الشراء
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sales.show', in_array('sales.show', $role_permissions),
                                    [ 'class' => '']); !!} عرض قائمة المبيعات
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sales.show_current_stock_in_pos', in_array('sales.show_current_stock_in_pos', $role_permissions),
                                    [ 'class' => '']); !!} عرض المخزون الحالي  في نقطة البيع
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sales.show_purchase_price_in_pos', in_array('sales.show_purchase_price_in_pos', $role_permissions),
                                    [ 'class' => '']); !!} عرض سعر الشراء في نقطة البيع
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'today_sells_total.show', in_array('today_sells_total.show', $role_permissions),
                                    [ 'class' => '']); !!} عرض الاجمالي اليومي
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sell.view', in_array('sell.view', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.sell.view' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sell.installment', in_array('sell.installment', $role_permissions),
                                    [ 'class' => '']); !!} جميع الاقساط
                                </label>
                            </div>
                        </div>
                        @if(in_array('pos_sale', $enabled_modules))
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('permissions[]', 'sell.create', in_array('sell.create', $role_permissions),
                                        [ 'class' => '']); !!} {{ __( 'role.sell.create' ) }}
                                    </label>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sell.update', in_array('sell.update', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.sell.update' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sell.delete', in_array('sell.delete', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.sell.delete' ) }}
                                </label>
                            </div>
                        </div>
                        @if(in_array('add_sale', $enabled_modules))
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('permissions[]', 'direct_sell.access', in_array('direct_sell.access', $role_permissions),
                                        [ 'class' => '']); !!} {{ __( 'role.direct_sell.access' ) }}
                                    </label>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'list_drafts', in_array('list_drafts', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'lang_v1.list_drafts' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'list_quotations', in_array('list_quotations', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'lang_v1.list_quotations' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'view_own_sell_only', in_array('view_own_sell_only', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'lang_v1.view_own_sell_only' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sell.payments', in_array('sell.payments', $role_permissions),['class' => '']); !!}
                                    اضافة دفع بيع
                                </label>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sell_payment.edit', in_array('sell_payment.edit', $role_permissions),['class' => '']); !!}
                                    تعديل دفع البيع
                                </label>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sell_payment.delete', in_array('sell_payment.delete', $role_permissions),['class' => '']); !!}
                                    حذف دفغ البيع
                                </label>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'edit_product_price_from_sale_screen', in_array('edit_product_price_from_sale_screen', $role_permissions), ['class' => '']); !!}
                                    {{ __('lang_v1.edit_product_price_from_sale_screen') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'edit_product_price_from_pos_screen', in_array('edit_product_price_from_pos_screen', $role_permissions), ['class' => '']); !!}
                                    {{ __('lang_v1.edit_product_price_from_pos_screen') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'edit_product_discount_from_sale_screen', in_array('edit_product_discount_from_sale_screen', $role_permissions), ['class' => '']); !!}
                                    {{ __('lang_v1.edit_product_discount_from_sale_screen') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'edit_product_discount_from_pos_screen', in_array('edit_product_discount_from_pos_screen', $role_permissions), ['class' => '']); !!}
                                    {{ __('lang_v1.edit_product_discount_from_pos_screen') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'discount.access', in_array('discount.access', $role_permissions), ['class' => '']); !!}
                                    {{ __('lang_v1.discount.access') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'access_shipping', in_array('access_shipping', $role_permissions), ['class' => '']); !!}
                                    {{ __('lang_v1.access_shipping') }}
                                </label>
                            </div>
                        </div>
                        @if(in_array('types_of_service', $enabled_modules))
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('permissions[]', 'access_types_of_service', in_array('access_types_of_service', $role_permissions),
                                        [ 'class' => '']); !!} {{ __( 'lang_v1.access_types_of_service' ) }}
                                    </label>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'access_sell_return', in_array('access_sell_return', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'مرتجع المبيعات' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'importsales.create', in_array('importsales.create', $role_permissions),
                                    [ 'class' => '']); !!} استيراد مبيعات من نظام اخر
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'recent_transaction.view', in_array('recent_transaction.view', $role_permissions),
                                    [ 'class' => '']); !!}     اخر المعاملات في شاشة نقاط البيع
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'customer_balance_due_in_pos', in_array('customer_balance_due_in_pos', $role_permissions),
                                    [ 'class' => '']); !!}    عرض الرصيد المستحق علي العميل في شاشة نقاط البيع
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'pos_lite',  in_array('pos_lite', $role_permissions),
                                    [ 'class' => '']); !!}    نقطة بيع لايت
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'pos_repair',  in_array('pos_repair', $role_permissions),
                                    [ 'class' => '']); !!}    نقطة بيع الصيانة
                                </label>
                            </div>
                        </div>




                </div>
            </div>


            {{--Expenses--}}
            <div class="row check_group">
                <div class="col-md-1">
                    <h4>@lang( 'role.expenses' )</h4>
                </div>
                <div class="col-md-2">
                    <div class="checkbox-list">
                                <label class="checkbox">
                            <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                        </label>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'expenses.view',  in_array('expenses.view', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.expenses.view' ) }}
                            </label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'expense.categories', in_array('expenses.categories', $role_permissions),
                                ['class' => '']); !!} {{ __('role.expenses.categories') }}
                            </label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'expense.create', in_array('expenses.create', $role_permissions),
                                ['class' => '']); !!} {{ __('role.expenses.create') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'expense.edit',  in_array('expenses.edit', $role_permissions),
                                ['class' => '']); !!} {{ __('role.expenses.edit') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'expense.delete',  in_array('expenses.delete', $role_permissions),
                                ['class' => '']); !!} {{ __('role.expenses.delete') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>


            {{-- End of Expense --}}





                <div class="row check_group">
                    <div class="col-md-1">
                        <h4>@lang( 'cash_register.cash_register' )</h4>
                    </div>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'view_cash_register', in_array('view_cash_register', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'lang_v1.view_cash_register' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'close_cash_register', in_array('close_cash_register', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'lang_v1.close_cash_register' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'register_payment_details.view', in_array('register_payment_details.view', $role_permissions),
                                    [ 'class' => '']); !!}    عرض تفاصيل الدفعات  في كشف الوردية
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'register_product_details.view',in_array('register_product_details.view', $role_permissions),
                                    [ 'class' => '']); !!}     عرض تفاصيل المنتجات المباعة في كشف الوردية
                                </label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row check_group">
                    <div class="col-md-1">
                        <h4>@lang( 'role.brand' )</h4>
                    </div>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'brand.view', in_array('brand.view', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.brand.view' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'brand.create', in_array('brand.create', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.brand.create' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'brand.update', in_array('brand.update', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.brand.update' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'brand.delete', in_array('brand.delete', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.brand.delete' ) }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row check_group">
                    <div class="col-md-1">
                        <h4>@lang( 'role.tax_rate' )</h4>
                    </div>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'tax_rate.view', in_array('tax_rate.view', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.tax_rate.view' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'tax_rate.create', in_array('tax_rate.create', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.tax_rate.create' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'tax_rate.update', in_array('tax_rate.update', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.tax_rate.update' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'tax_rate.delete', in_array('tax_rate.delete', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.tax_rate.delete' ) }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row check_group">
                    <div class="col-md-1">
                        <h4>@lang( 'role.unit' )</h4>
                    </div>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'unit.view', in_array('unit.view', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.unit.view' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'unit.create', in_array('unit.create', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.unit.create' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'unit.update', in_array('unit.update', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.unit.update' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'unit.delete', in_array('unit.delete', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.unit.delete' ) }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row check_group">
                    <div class="col-md-1">
                        <h4>@lang( 'category.category' )</h4>
                    </div>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'category.view', in_array('category.view', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.category.view' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'category.create', in_array('category.create', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.category.create' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'category.update', in_array('category.update', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.category.update' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'category.delete', in_array('category.delete', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.category.delete' ) }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row check_group">
                    <div class="col-md-1">
                        <h4>@lang( 'role.report' )</h4>
                    </div>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        @if(in_array('purchases', $enabled_modules) || in_array('add_sale', $enabled_modules) || in_array('pos_sale', $enabled_modules))
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('permissions[]', 'purchase_n_sell_report.view', in_array('purchase_n_sell_report.view', $role_permissions),
                                        [ 'class' => '']); !!} {{ __( 'role.purchase_n_sell_report.view' ) }}
                                    </label>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'tax_report.view', in_array('tax_report.view', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.tax_report.view' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'contacts_report.view', in_array('contacts_report.view', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.contacts_report.view' ) }}
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'profit_loss_report.view', in_array('profit_loss_report.view', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.profit_loss_report.view' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'stock_report.view', in_array('stock_report.view', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.stock_report.view' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'stock_missing_report.view', in_array('stock_missing_report.view', $role_permissions),
                                    [ 'class' => '']); !!} تقرير النواقص
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'trending_product_report.view', in_array('trending_product_report.view', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.trending_product_report.view' ) }}
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'register_report.view', in_array('register_report.view', $role_permissions),
                                    [ 'class' => '']); !!} تقرير الوردية
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sales_representative.view', in_array('sales_representative.view', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.sales_representative.view' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'view_product_stock_value', in_array('view_product_stock_value', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'lang_v1.view_product_stock_value' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'less_trending_product_report.view', in_array('less_trending_product_report.view', $role_permissions),
                                    [ 'class' => '']); !!} المنتجات الراكدة
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'sell_purchase_lines_report.view', in_array('sell_purchase_lines_report.view', $role_permissions),
                                    [ 'class' => '']); !!} تقرير حركة صنف
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row check_group">
                    <div class="col-md-1">
                        <h4>@lang( 'role.settings' )</h4>
                    </div>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'business_settings.backup_database', in_array('business_settings.backup_database', $role_permissions),
                                    [ 'class' => '']); !!} نسخ احتياطي
                                </label>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'business_settings.access', in_array('business_settings.access', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.business_settings.access' ) }}
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'barcode_settings.access', in_array('barcode_settings.access', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.barcode_settings.access' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'invoice_settings.access', in_array('invoice_settings.access', $role_permissions),
                                    [ 'class' => '']); !!} {{ __( 'role.invoice_settings.access' ) }}
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'access_printers', in_array('access_printers', $role_permissions),['class' => '']); !!}
                                    {{ __('lang_v1.access_printers') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

        <div style="display: none">
            {{--dashboard--}}
            <div class="row check_group">
                <div class="col-md-3">
                    <h4>@lang( 'role.dashboard' )</h4>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'dashboard.data', in_array('dashboard.data', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'role.dashboard.data' ) }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{--account.account--}}
            <div class="row check_group">
                <div class="col-md-3">
                    <h4>@lang( 'account.account' )</h4>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('permissions[]', 'account.access', in_array('account.access', $role_permissions),
                                [ 'class' => '']); !!} {{ __( 'lang_v1.access_accounts' ) }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>


                @if(in_array('booking', $enabled_modules))
                    <div class="row check_group">
                        <div class="col-md-1">
                            <h4>@lang( 'restaurant.bookings' )</h4>
                        </div>
                        <div class="col-md-2">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    <input type="checkbox" class="check_all " > {{ __( 'role.select_all' ) }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('permissions[]', 'crud_all_bookings', in_array('crud_all_bookings', $role_permissions),
                                        [ 'class' => '']); !!} {{ __( 'restaurant.add_edit_view_all_booking' ) }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('permissions[]', 'crud_own_bookings', in_array('crud_own_bookings', $role_permissions),
                                        [ 'class' => '']); !!} {{ __( 'restaurant.add_edit_view_own_booking' ) }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                @endif
                <div class="row check_group ">
                    <div class="col-md-3">
                        <h4>@lang( 'lang_v1.access_selling_price_groups' )</h4>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'access_default_selling_price', in_array('access_default_selling_price', $role_permissions),
                                    [ 'class' => '']); !!} {{ __('lang_v1.default_selling_price') }}
                                </label>
                            </div>
                        </div>
                        @if(count($selling_price_groups) > 0)
                            @foreach($selling_price_groups as $selling_price_group)
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <label>
                                            {!! Form::checkbox('spg_permissions[]', 'selling_price_group.' . $selling_price_group->id, in_array('selling_price_group.' . $selling_price_group->id, $role_permissions),
                                            [ 'class' => '']); !!} {{ $selling_price_group->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

            {{--Projects Setting--}}
              {{--  <div class="row">
                    <div class="col-md-3">
                        <h4> Projects Setting </h4>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'projcts.show', in_array('projcts.show', $role_permissions),
                                    [ 'class' => '']); !!} عرض المشروعات
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <h4> مديول كاتالوج </h4>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'catalouge.show', in_array('catalouge.show', $role_permissions),
                                    [ 'class' => '']); !!} عرض الكتالوج
                                </label>
                            </div>
                        </div>
                    </div>

                </div>--}}
           {{--Repair--}}
            {{--    <div class="row">
                    <div class="col-md-3">
                        <h4> مديول الصيانة </h4>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'repair_setting.view', in_array('repair_setting.view', $role_permissions),
                                    [ 'class' => '']); !!} الاعدادت
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'repair_device_model.create', in_array('repair_device_model.create', $role_permissions),
                                    [ 'class' => '']); !!} اضافة موديل جهاز
                                </label>
                            </div>
                        </div>
                    </div>
                </div>--}}

            {{--HRM Setting--}}
               {{-- <div class="row check_group">
                    <div class="col-md-3">
                        <h4> HRM Setting </h4>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-12">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    {!! Form::checkbox('permissions[]', 'hrm_show', in_array('hrm_show', $role_permissions),
                                    [ 'class' => '']); !!} HRM
                                </label>
                            </div>
                        </div>
                    </div>

                </div>--}}
                @if(in_array('tables', $enabled_modules))
                    <div class="row">
                        <div class="col-md-3">
                            <h4>@lang( 'restaurant.restaurant' )</h4>
                        </div>
                        <div class="col-md-9">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('permissions[]', 'access_tables', in_array('access_tables', $role_permissions),
                                        [ 'class' => '']); !!} {{ __('lang_v1.access_tables') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @include('role.partials.module_permissions')
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right">@lang( 'messages.update' )</button>
                    </div>
                </div>

            {!! Form::close() !!}
        @endcomponent
    </section>
    <!-- /.content -->

@endsection
