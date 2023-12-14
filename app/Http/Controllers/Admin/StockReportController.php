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

        $query = StockRecord::where('outlet_name', 'LIKE', '%' . $request->outlet . '%')
            ->whereBetween('date', [$request->datetime, $request->todatetime]);

        if(isset($request->item)){
            $query->where('item_name', 'LIKE', '%' . $request->item . '%');
        }

        $stockArrItem = $query->orderBy('id', 'DESC')->get();

        foreach($stockArrItem as $data){
            $arrayData[] = [
                // 'id' => $data->id,
                'outlet' => $data->outlet_name,
                'item' => $data->item_name,
                'stock' => $data->stock_receive_qty,
                'sale' => $data->sale_qty,
                'date' => $data->date,
            ];
        }

        return response()->json([
            'status' => $request->outlet,
            'datas' => $arrayData
        ]);
    }

    // function keepAlive()
    // {
        //updating the session timestamp
    //     return response()->json(['status' => 'success']);
    // }
}
