@php
	$subtype = '';
@endphp
@if(!empty($transaction_sub_type))
	@php
		$subtype = '?sub_type='.$transaction_sub_type;
	@endphp
@endif
<table class="table table-slim no-border">
<thead>
<tr>
	<th class="table-dark">رقم الفاتورة</th>
	<th class="table-dark">العميل</th>
	<th class="table-dark">القيمة</th>
	<th class="table-dark">خيارات</th>
</tr>
</thead>

@if(!empty($transactions))

		@foreach ($transactions as $transaction)
			<tr class="cursor-pointer" 
	    		title="Customer: {{optional($transaction->contact)->name}} 
		    		@if(!empty($transaction->contact->mobile) && $transaction->contact->is_default == 0)
		    			<br/>Mobile: {{$transaction->contact->mobile}}
		    		@endif
	    		" >
				<td>
					{{--{{ $loop->iteration}}.--}}
					{{ $transaction->invoice_no }}
				</td>
				<td>
					 ({{optional($transaction->contact)->name}})
					@if(!empty($transaction->table))
						- {{$transaction->table->name}}
					@endif
				</td>
				<td class="display_currency">
					{{ $transaction->final_total }}
				</td>
				<td>
					<a href="{{action('SellPosController@edit', [$transaction->id]).$subtype}}">
	    				<i class="fas fa-pen text-muted" aria-hidden="true" title="{{__('lang_v1.click_to_edit')}}"></i>
	    			</a>
					@if($is_admin)
	    			<a href="{{action('SellPosController@destroy', [$transaction->id])}}" class="delete-sale" style="padding-left: 20px; padding-right: 20px"><i class="fa fa-trash text-danger" title="{{__('lang_v1.click_to_delete')}}"></i></a>
					@endif
	    			<a href="{{action('SellPosController@printInvoice', [$transaction->id])}}" class="print-invoice-link" @if(!$is_admin)style="margin-left: 15px;" @endif>
	    				<i class="fa fa-print text-muted" aria-hidden="true" title="{{__('lang_v1.click_to_print') }}"></i>
	    			</a>
					<a href="/reports/product-sell-report" target="_blank" style="padding-left: 20px; padding-right: 20px"><i class="fa fa-undo-alt" title="{{__('lang_v1.product_sell_day')}}"></i></a>

				</td>
			</tr>
		@endforeach
	</table>
@else
	<p>@lang('sale.no_recent_transactions')</p>
@endif