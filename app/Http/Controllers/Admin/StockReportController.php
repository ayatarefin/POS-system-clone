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
        $outlets = StockRecord::select('outlet_name')->groupBy('outlet_name')->get();
        $items =StockRecord::select('item_name')->groupBy('item_name')->get();
        $arrayData=[];
        return view('admin.stock-reports',compact('arrayData','outlets','items'));
    }
function searchStock(Request $request){
        $arrayData = [];
        $stockArrItem = [];
        if(isset($request->datetime) && isset($request->todatetime) && isset($request->outlet)){
            $stockArrItem =StockRecord::where('outlet_name','LIKE','%'.$request->outlet.'%')
                ->whereBetween('date',[$request->datetime,$request->todatetime])
                ->orderBy('id','DESC')->get();
        }
        if(isset($request->datetime) && isset($request->todatetime) && isset($request->outlet) && isset($request->item)){
            $stockArrItem =StockRecord::where('outlet_name','LIKE','%'.$request->outlet.'%')
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
        public function fetchChartData(Request $request)
        {
            $fromdate = $request->input('fromdate');
            $todate = $request->input('todate');

            $stock = StockRecord::whereBetween('date', [$fromdate, $todate])->get();
            $sale = SaleRecord::whereBetween('datetime', [$fromdate, $todate])->get();

            // ... Similar data preparation logic as in your existing method\

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

            return response()->json([
                'arrSale' => $arrSale,
                'arrStock' => $arrStock,
            ]);
        }
}
