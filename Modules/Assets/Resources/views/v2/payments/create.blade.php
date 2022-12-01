<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('\Modules\Assets\Http\Controllers\PaymentsController@store'), 'method' => 'post','id' =>'addpayment' ]) !!}

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">تسجيل مدفوعات شريك</h4>
        </div>

        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name','إسم الشريك :*') !!}
                {!! Form::select('partner_id', $Assets, null, ['class' => 'form-control select2', 'style' => 'width:100%;height: 40px;']); !!}
            </div>

            <div class="form-group">
                {!! Form::label('value',' القيمة :*') !!}
                {!! Form::text('value', null, ['class' => 'form-control', 'required', 'placeholder' =>'قيمة العملية بالجنية' ]); !!}
            </div>

            <div class="form-group">
                <div class="form-group">
                    {!! Form::label('type','نوع العملية') !!}
                    {!! Form::select('type', ['1'=>'سحب ','2'=>'إيداع'], null, ['class' => 'form-control select2', 'style' => 'width:100%;height: 40px;']); !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('date','تاريخ العملية : ') !!}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>

                    {!! Form::text('date', null, ['class' => 'form-control date-picker','required','placeholder' => __('Assets.purchasedate'), 'readonly']); !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('notes',' الملاحظات :') !!}
                {!! Form::text('notes', null, ['class' => 'form-control',  'placeholder' =>'ملاحظات' ]); !!}
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
    $('.date-picker').datepicker({
        autoclose: true,
        endDate: 'today',
        format:'yyyy-m-d',
    });
</script>