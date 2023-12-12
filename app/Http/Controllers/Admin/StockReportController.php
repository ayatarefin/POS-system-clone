<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockRecord;
use App\Models\AllItems;
use App\Models\Outlets;
use DB;
class StockReportController extends Controller
{
    ///current stock ////
    function currentStock(Request $request){
        $outlets = Outlets::pluck('outlet_name');
        $items = AllItems::pluck('item_name');
        $arrayData=[];
        return view('admin.stock-reports',compact('arrayData','outlets','items'));
    }
    function searchStock(Request $request){
        $arrayData = [];
        $stockArrItem = [];
        if(isset($request->datetime) && isset($request->todatetime) && isset($request->outlet)){
            $stockArrItem = StockRecord::where('outlet_name','LIKE','%'.$request->outlet.'%')
                ->whereBetween('date',[$request->datetime,$request->todatetime])
                ->orderBy('id','DESC')->get();
        }
        if(isset($request->datetime) && isset($request->todatetime) && isset($request->outlet) && isset($request->item)){
            $stockArrItem = StockRecord::where('outlet_name','LIKE','%'.$request->outlet.'%')
                ->where('item_name','LIKE','%'.$request->item.'%')
                ->whereBetween('date',[$request->datetime,$request->todatetime])
                ->orderBy('id','DESC')->get();
        }
        foreach($stockArrItem as $data){
            $arrayData[] = [
                'id' => $data->id,
                'outlet' => $data->outlet_name,
                'item' => $data->item_name,
                'stock' => $data->stock_receive_qty,
                'sale' => $data->sale_qty,
                'date' => $data->date,
            ];
        }
        return response()->json([
            'status'=>$request->outlet,
            'datas' => $arrayData
        ]);

    }
}
