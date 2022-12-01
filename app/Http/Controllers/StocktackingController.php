<?php

namespace App\Http\Controllers;

use App\BusinessLocation;

use App\PurchaseLine;

use App\Transaction;
use App\Utils\ModuleUtil;

use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use Datatables;
use App\StocktackingLine;
use DB;
use App\Brands;


use App\Category;
use Illuminate\Http\Request;

class StocktackingController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $productUtil;
    protected $transactionUtil;
    protected $moduleUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(ProductUtil $productUtil, TransactionUtil $transactionUtil, ModuleUtil $moduleUtil)
    {
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business_id = request()->session()->get('user.business_id');
        if (!auth()->user()->can('stocktacking.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $transactions=\DB::table('transactions')->join('business_locations','business_locations.id','transactions.location_id')
        ->where('transactions.type','stocktacking')
        ->where('transactions.business_id',$business_id)
        ->select(
            'transactions.*',
            'business_locations.name as location_name'
            )
        ->get();
        return view(viewSource().'stocktacking.index',['transactions'=>$transactions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         if (!auth()->user()->can('stocktacking.create') ) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');
        $business_locations = BusinessLocation::forDropdown($business_id);
        
        return view(viewSource().'stocktacking.create')
                ->with(compact('business_locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('stocktacking.create') ) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');
        $transactions=\DB::table('transactions')->where('type','stocktacking')->where('business_id',$business_id)->whereBetween('transaction_date',[$request->start_date,$request->end_date])->orWhereBetween('end_date',[$request->start_date,$request->end_date])->where('location_id',$request->location_id)->get();
        if(sizeof($transactions )> 0 ){
            
            $output = ['success' => 0,
                            'msg' =>'تتعارض فترة الجرد مع عملية جرد اخري لهذا الفرع      '
                        ];
            return redirect()->back()->with('status', $output);
                        
        }
       try{
            \DB::table('transactions')->insert([
           'business_id'=>$business_id,
           'location_id'=>$request->location_id,
           'type'=>'stocktacking',
           'status'=>$request->status,
           'transaction_date'=>$request->start_date,
           'end_date'=>$request->end_date,
           'created_by'=>\Auth::user()->id
           ]);
        $output = ['success' => 1,
                            'msg' =>'تم اضافة الجرد بنجاح'
                    ];

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => __('messages.something_went_wrong')
                        ];
        }
        return redirect('stocktacking')->with('status', $output);
    }
    

  
  
    
    public function transaction($id)
    {
        if (!auth()->user()->can('stocktacking.products') ) {
            abort(403, 'Unauthorized action.');
        }
        $transaction=\DB::table('transactions')->where('id',$id)->first();
        if($transaction->status!=='on' || $transaction->end_date < date("Y-m-d") ){
             $output = ['success' => 0,
                            'msg' =>'خطأ، عملية جرد مغلقة '
                        ];
            return redirect()->back()->with('status', $output);
        }
        if($transaction->end_date < date("Y-m-d") ){
             $output = ['success' => 0,
                            'msg' =>'خطأ، عملية جرد منتهية  '
                        ];
            return redirect()->back()->with('status', $output);
        }
       $transaction_id=$id;
        $business_id = request()->session()->get('user.business_id');
        $variations=\DB::table('variations')->join('products','products.id','variations.product_id')->where('products.business_id',$business_id)
        ->select(
            'variations.*',
            'products.name as product_name'
            )
            ->get();
            $last_row=\DB::table('stocktacking_lines')->where('transaction_id',$transaction_id)->orderBy('id','DESC')->first();
         if($last_row){
          $lastproduct=\DB::table('variations')->join('products','products.id','variations.product_id')->where('variations.id',$last_row->variation_id)
        ->select(
            'variations.*',
            'products.name as product_name'
            )->first();
         }else{
             $lastproduct = new \stdClass();
             $lastproduct->product_name='';//[];
         }
        return view(viewSource().'stocktacking.transaction_form')
                ->with(compact('variations','transaction_id','lastproduct'));
    }
    public function get_last_product(Request $request){
        $transaction_id=$request->transaction_id;
         $last_row=\DB::table('stocktacking_lines')->where('transaction_id',$transaction_id)->orderBy('id','DESC')->first();
          $lastproduct=\DB::table('variations')->join('products','products.id','variations.product_id')->where('variations.id',$last_row->variation_id)
        ->select(
            'variations.*',
            'products.name as product_name'
            )->first();
            return $lastproduct->product_name;
    }
    public function transaction_ajax_post(Request $request){
         $business_id = request()->session()->get('user.business_id');
         $transaction_id=$request->transaction_id;
       try{
          $exist=StocktackingLine::where('transaction_id',$request->transaction_id)->where('variation_id',$request->variation_id)->first();
          if(!$exist){
                $stock_line_id=\DB::table('stocktacking_lines')->insertGetId([
               'transaction_id'=>$request->transaction_id,
               'real_qty_available'=>$request->real_qty_available,
               'variation_id'=>$request->variation_id,
               'created_by'=>\Auth::user()->id
               ]);
               
            }else{
                $stock_line_id=$exist->id;
              \DB::table('stocktacking_lines')->where('id',$exist->id)->update([
               'transaction_id'=>$request->transaction_id,
               'real_qty_available'=>$request->real_qty_available,
               'variation_id'=>$request->variation_id,
               'created_by'=>\Auth::user()->id,
               'updated_at'=>now(),
               ]);  
            }
                $output = ['success' => 1,
                            'msg' =>'تم اضافة الكمية الفعلية بنجاح'
                    ];
                    
                $output=$this->make_liquidation($transaction_id,$stock_line_id);    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => __('messages.something_went_wrong')
                            ];
        }
        return $output;
    }
    public function make_liquidation($transaction_id,$stock_lines_id){

         $transaction=\DB::table('transactions')->where('id',$transaction_id)->first();
        $location_id=$transaction->location_id ;
        $stocktacking_line=\DB::table('stocktacking_lines')->where('id',$stock_lines_id)->first();
        try{
            
     
              $stock=\DB::table('variation_location_details')
                    ->where('variation_id',$stocktacking_line->variation_id)
                    ->where('location_id',$location_id)
                    ->first();
              \DB::table('stocktacking_lines')->where('id',$stocktacking_line->id)->update(['current_stock'=>$stock->qty_available]);
              
              \DB::table('variation_location_details')
              ->where('variation_id',$stocktacking_line->variation_id)
              ->where('location_id',$location_id)
              ->update(['qty_available'=>$stocktacking_line->real_qty_available]);
              $output = ['success' => 1,
                            'msg' =>'تم الجرد والتسوية'
                    ];
        }catch(\Exception $e){
        DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => __('messages.something_went_wrong')
                            ];
            
        }
         return $output;
    }
    public function transaction_ajax_get(Request $request){
         $business_id = request()->session()->get('user.business_id');
         $transaction=DB::table('transactions')->where('id',$request->transaction_id)->first();

        $exist=\DB::table('stocktacking_lines')->where('transaction_id',$request->transaction_id)->where('variation_id',$request->variation_id)->first();

        $variations=\DB::table('variations')
            ->join('products','products.id','variations.product_id')
            ->join('variation_location_details','variations.id','variation_location_details.variation_id')
            ->where('products.business_id',$business_id)
            ->where('variations.id',$request->variation_id)
            ->where('variation_location_details.location_id',$transaction->location_id)
            ->select(
            'variations.*',
            'products.name as product_name',
            'variation_location_details.qty_available'
            )
            ->first();
        if(!$exist){
          $html='
            <tr>
                            <td>
                             
                                <input type="text" class="form-control" id="product_name" value="'.$variations->product_name.'-'.$variations->name.'">
                            </td>';
                             if (auth()->user()->can('stocktacking.show_qty_available') ) {
                                       $html .='<td><input type="text" class="form-control" id="" readonly="readonly" value="'.number_format($variations->qty_available, 0, '.', ',').'"></td>';

                                }
                            
                            $html .='<td>
                                
                                <input type="text" class="form-control" id="real_qty_available">
                            </td>
                            
                        </tr>
            ';
        }else{
           $html='
            <tr>
                            <td>
                             
                                <input type="text" class="form-control" id="product_name" value="'.$variations->product_name.'-'.$variations->name.'">
                            </td>';
                             if (auth()->user()->can('stocktacking.show_qty_available') ) {
                                       $html .='<td><input type="text" class="form-control" id="qty_available" readonly="readonly" value="'.$variations->qty_available.'"></td>';
                                }
                            
                            $html .='
                            <td>
                                
                                <input type="text" class="form-control" id="real_qty_available" value="'.$exist->real_qty_available.'">
                            </td>
                             ';
                             if (auth()->user()->can('stocktacking.delete_form_stocktacking') ) {
                                       $html .='<td>
                                       <input type="hidden" id="stL_id" value="'.$exist->id.'">
                                       <button class="btn btn-danger" id="delete_from_stocktacking">  حذف</button>
                                       <script>
                                            $("#delete_from_stocktacking").on("click",function(){
                                            
                                               var id = $("#stL_id").val();
                                             
                                                $.ajax({
                                                       type:"POST",
                                                       url:"'.action("StocktackingController@delete_from_stocktacking").'",
                                                       data:{
                                                             "_token" :"'.csrf_token().'",
                                                             "id":  id,
                                                           
                                                       },
                                                       success:function(result) {
                                                         
                                                         
                                                          if(result.success == true){
                                                          get_last_product();
                                                                toastr.success(result.msg);
                                                                $("#real_qty_available").val(null);
                                                                $("#delete_from_stocktacking").hide();
                                                            } else {
                                                                toastr.error(result.msg);
                                                            }
                                                       }
                                                    });
                                                 
                                          }); 
                                        </script>
                                       </td>';

                                }
                            
                            $html .='
                        </tr>
            '; 
        }
       return $html;
    }
    public function delete_from_stocktacking(Request $request){
    try{
        \DB::table('stocktacking_lines')->where('id',$request->id)->delete();
    
        $output = ['success' => 1,
                            'msg' =>'تم حذف جرد المنتج'
                    ];
     
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => __('messages.something_went_wrong')
                        ];
        }
        return $output;
    }
    
    public function report($id)
    {
        if (!auth()->user()->can('stocktacking.report') ) {
            abort(403, 'Unauthorized action.');
        }
        $location=Transaction::select('business_locations.name')
            ->where('transactions.id',$id)
            ->join('business_locations','transactions.location_id','=','business_locations.id')
            ->first();
         $business_id = request()->session()->get('user.business_id');
        if (request()->ajax()) {
            $transactions=\DB::table('transactions')->where('id',$id)->first();
            $business_id = request()->session()->get('user.business_id');
            $user_id = request()->session()->get('user.id');
            $products=StocktackingLine::
            join('transactions','stocktacking_lines.transaction_id','transactions.id')
            ->join('variations','variations.id','stocktacking_lines.variation_id')
            ->join('products','products.id','variations.product_id')
            ->join('variation_location_details as vld','vld.variation_id','stocktacking_lines.variation_id')
            ->join('users','stocktacking_lines.created_by','users.id')
            ->where('transactions.id',$id)
            ->where('vld.location_id',$transactions->location_id)
            ->select(
                'products.name',
                'stocktacking_lines.real_qty_available',
                'stocktacking_lines.current_stock',
                'variations.name as variation_name',
                'vld.qty_available',
                'users.first_name',
                'users.last_name',
                'users.id as user_id',
                'stocktacking_lines.created_at',
                'stocktacking_lines.updated_at'
            );

             $current_stock = request()->get('current_stock');

            if ($current_stock=='zero') {
             
                $products->where('vld.qty_available', '0');
            }
             if ($current_stock=='gtzero') {
                $products->where('vld.qty_available','>', 0);
            }
             if ($current_stock=='lszero') {
                $products->where('vld.qty_available','<', 0);
            }

            $category_id = request()->get('category_id', null);
            if (!empty($category_id)) {
                $products->where('products.category_id', $category_id);
            }

            $brand_id = request()->get('brand_id', null);
            if (!empty($brand_id)) {
                $products->where('products.brand_id', $brand_id);
            }
            $products->get();

            return Datatables::of($products)
               ->addColumn(
                    'compare',
                    function ($row) {
                        $compare =(float)$row->current_stock - (float)$row->qty_available;
                        return $compare;
                    }
                )
                ->rawColumns(['name','current_stock', 'real_qty_available','variation_name','qty_available','first_name','created_at','compare'])
                ->make(true);
        }

        $categories = Category::forDropdown($business_id, 'product');
        $brands = Brands::forDropdown($business_id);
        return view(viewSource().'stocktacking.report',['transaction_id'=>$id,'categories'=>$categories,'brands'=>$brands ,'location'=>$location]);
    }
    public function not_tacking_report($id){
        $transactions=\DB::table('transactions')->where('id',$id)->first();
            $business_id = request()->session()->get('user.business_id');
            $user_id = request()->session()->get('user.id');
      
       

        if (!auth()->user()->can('stocktacking.report') ) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $transactions=\DB::table('transactions')->where('id',$id)->first();
            $business_id = request()->session()->get('user.business_id');
            $user_id = request()->session()->get('user.id');
                $products = \App\Product::leftJoin('brands', 'products.brand_id', '=', 'brands.id')
                ->join('units', 'products.unit_id', '=', 'units.id')
                ->leftJoin('tax_rates', 'products.tax', '=', 'tax_rates.id')
                ->join('variations as v', 'v.product_id', '=', 'products.id')
                ->leftJoin('variation_location_details as vld', 'vld.variation_id', '=', 'v.id')
                ->where('products.business_id', $business_id)
                ->where('vld.location_id', $transactions->location_id)
                ->where('products.type', '!=', 'modifier')
                //->where('st.transaction_id',$id)
                ->whereRaw("v.id  not in (select variation_id from stocktacking_lines where stocktacking_lines.transaction_id=$id)")
                ->select(
                     \DB::raw("(select transactions.id from transactions where transactions.id =$id) as transaction_id "),
                    'products.name',
                    'v.name as variation_name',
                    'vld.qty_available',
                    'v.id as var_id'
                    );
                  $current_stock = request()->get('current_stock');

            if ($current_stock=='zero') {
               
                $products->where('vld.qty_available', '0');
            }
             if ($current_stock=='gtzero') {
                $products->where('vld.qty_available','>', 0);
            }
             if ($current_stock=='lszero') {
                $products->where('vld.qty_available','<', 0);
            }

            $category_id = request()->get('category_id', null);
            if (!empty($category_id)) {
                $products->where('products.category_id', $category_id);
            }

            $brand_id = request()->get('brand_id', null);
            if (!empty($brand_id)) {
                $products->where('products.brand_id', $brand_id);
            }
            $products->get();
                foreach($products as $row){
                    $row->transaction_id=$id;
                }
            
            return Datatables::of($products)
               ->addColumn(
                    'action',
                    function ($row) {
                        $href='/stocktacking/transaction/'.$row->transaction_id.'?var_id='.$row->var_id;
                        $word="جرد";
                        $html='<a class="btn btn-info dropdown-toggle btn-xs" target="_blank" href="'.$href.'">'.$word.'</a>';
                        return $html;
                    }
                )
                ->rawColumns(['product_name','variation_name','action'])
                ->make(true);
        }
        $categories = Category::forDropdown($business_id, 'product');
        $brands = Brands::forDropdown($business_id);
        return view(viewSource().'stocktacking.not_tacking_report',['transaction_id'=>$id,'categories'=>$categories,'brands'=>$brands]);
    
    }
    
    public function report_plus($id)
    {
        if (!auth()->user()->can('stocktacking.report') ) {
            abort(403, 'Unauthorized action.');
        }

        $location=Transaction::select('business_locations.name')
            ->where('transactions.id',$id)
            ->join('business_locations','transactions.location_id','=','business_locations.id')
            ->first();

        if (request()->ajax()) {
             $transactions=\DB::table('transactions')->where('id',$id)->first();
            $business_id = request()->session()->get('user.business_id');
            $user_id = request()->session()->get('user.id');
            $lines=DB::table('stocktacking_lines')
            ->join('transactions','stocktacking_lines.transaction_id','transactions.id')
            ->join('variations','variations.id','stocktacking_lines.variation_id')
            ->join('products','products.id','variations.product_id')
            ->join('variation_location_details as vld','vld.variation_id','stocktacking_lines.variation_id')
            ->join('users','stocktacking_lines.created_by','users.id')
            ->where('transactions.id',$id)
            ->where('stocktacking_lines.real_qty_available','>', DB::raw('stocktacking_lines.current_stock'))
            ->where('vld.location_id',$transactions->location_id)
            ->select(
                'products.name as product_name',
                'stocktacking_lines.real_qty_available',
                'stocktacking_lines.current_stock',
                'variations.name as variation_name',
                'vld.qty_available',
                'users.first_name',
                'users.last_name',
                'users.id as user_id',
                'stocktacking_lines.created_at',
                'stocktacking_lines.updated_at'
            )
            ->get();
            return Datatables::of($lines)
               ->addColumn(
                    'compare',
                    function ($row) {
                        $compare =(float)$row->real_qty_available - (float)$row->current_stock;
                        return $compare;
                    }
                )
                ->rawColumns(['product_name','current_stock', 'real_qty_available','variation_name','qty_available','first_name','created_at','compare'])
                ->make(true);
        }

        return view(viewSource().'stocktacking.plus_report',['transaction_id'=>$id,'location'=>$location]);
    }
    public function report_minus($id)
    {
        if (!auth()->user()->can('stocktacking.report') ) {
            abort(403, 'Unauthorized action.');
        }

        $location=Transaction::select('business_locations.name')
                                 ->where('transactions.id',$id)
                                 ->join('business_locations','transactions.location_id','=','business_locations.id')
                                 ->first();

        if (request()->ajax()) {
            $transactions=\DB::table('transactions')->where('id',$id)->first();
            $business_id = request()->session()->get('user.business_id');
            $user_id = request()->session()->get('user.id');
            $lines=DB::table('stocktacking_lines')
            ->join('transactions','stocktacking_lines.transaction_id','transactions.id')
            ->join('variations','variations.id','stocktacking_lines.variation_id')
            ->join('products','products.id','variations.product_id')
            ->join('variation_location_details as vld','vld.variation_id','stocktacking_lines.variation_id')
            ->join('users','stocktacking_lines.created_by','users.id')
            ->where('transactions.id',$id)
            ->where('stocktacking_lines.real_qty_available','<', DB::raw('stocktacking_lines.current_stock'))
           
            ->where('vld.location_id',$transactions->location_id)
            ->select(
                'products.name as product_name',
                'stocktacking_lines.real_qty_available',
                'stocktacking_lines.current_stock',
                'variations.name as variation_name',
                'vld.qty_available',
                'users.first_name',
                'users.last_name',
                'users.id as user_id',
                'stocktacking_lines.created_at',
                'stocktacking_lines.updated_at'
            )
            ->get();
            return Datatables::of($lines)
               ->addColumn(
                    'compare',
                    function ($row) {
                        $compare =(float)$row->real_qty_available - (float)$row->current_stock;
                        return $compare;
                    }
                )
                ->rawColumns(['product_name','current_stock', 'real_qty_available','variation_name','qty_available','first_name','created_at','compare'])
                ->make(true);
        }

        return view(viewSource().'stocktacking.minus_report',['transaction_id'=>$id,'location'=>$location]);
    }
    
    public function changeStatus($id,$status){
         if (!auth()->user()->can('stocktacking.changeStatus') ) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');
        $transaction=\DB::table('transactions')->where('id',$id)->first();
        if($status=='on' && $transaction->end_date < date("Y-m-d") ){
             $output = ['success' => 0,
                            'msg' =>'خطأ، عملية جرد منتهية '
                        ];
                         return redirect('stocktacking')->with('status', $output);
        }

        $transaction_on=Transaction::where('business_id',$business_id)
                                     ->where('status','on')
                                     ->where('location_id', $transaction->location_id)
                                      ->count();


       if($transaction_on && $status=='on'){
           $output = ['success' => 0,
                            'msg' =>'هناك عملية جرد مفتوحة بالفعل '
                            ]  ;
            return redirect('stocktacking')->with('status', $output);
       }
       try{
           
       
        \DB::table('transactions')->where('id',$id)->update(['status'=>$status]);
        $output = ['success' => 1,
                            'msg' =>'تم تحديث حالة الجرد   '
                    ];
                    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => __('messages.something_went_wrong')
                        ];
        }
        return redirect('stocktacking')->with('status', $output);
    }

     public function Stock_liquidation(Request $request){
          
    
        $transaction=\DB::table('transactions')->where('id',$request->transaction_id)->first();
        if($transaction->sub_type=='liquidation'){
            $output = ['success' => 0,
                            'msg' => __('تمت التصفية من قبل')
                        ];
            return  $output;
        }
         if($transaction->end_date < date("Y-m-d")){
            $output = ['success' => 0,
                            'msg' => __('  انتهت فترة الجرد ')
                        ];
            return  $output;
        }
        \DB::table('transactions')->where('id',$request->transaction_id)->update(['sub_type'=>'liquidation']);
        $location_id=$transaction->location_id ;
        $stocktacking_lines=\DB::table('stocktacking_lines')->where('transaction_id',$transaction->id)->get();
       try{
           //update qty available
           
          foreach($stocktacking_lines as $row){
              $stock=\DB::table('variation_location_details')
                    ->where('variation_id',$row->variation_id)
                    ->where('location_id',$location_id)
                    ->first();
              \DB::table('stocktacking_lines')->where('id',$row->id)->update(['current_stock'=>$stock->qty_available]);
              
              \DB::table('variation_location_details')
              ->where('variation_id',$row->variation_id)
              ->where('location_id',$location_id)
              ->update(['qty_available'=>$row->real_qty_available]);
          }
          
        $output = ['success' => 1,
                            'msg' =>'تم تصفية الجرد بنجاح'
                    ];
                    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => __('messages.something_went_wrong')
                        ];
        }
        return  $output;
    }
     
    
}
