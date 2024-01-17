<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockRecord;
use App\Models\SaleRecord;
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
                'stock' => $data->stock_quantity,
                'date' => $data->date,
            ];
        }

        return response()->json([
            'status' => $request->outlet,
            'datas' => $arrayData
        ]);
    }

        ///function for chart
        function productSaleChart(Request $request){
            $fromdate = $request->fromdate;
            $todate = $request->todate;

            $stock = StockRecord::whereBetween('date', [$fromdate, $todate])
                ->distinct()
                ->take(850)
                ->get();
            $sale = SaleRecord::whereBetween('datetime', [$fromdate, $todate])
                ->distinct()
                ->take(850)
                ->get();


            $diff = abs(strtotime($todate) - strtotime($fromdate));
            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            $arrStock = [];
            $arrSale = [];
            foreach($stock as $data){
                array_push($arrStock,$data->stock_quantity);
            }
            foreach($sale as $data){
                array_push($arrSale,$data->sale_qty);
            }
            return view('dashboard', [
                'arrSale' => $arrSale,
                'arrStock' => $arrStock,
            ]);
        }
}
