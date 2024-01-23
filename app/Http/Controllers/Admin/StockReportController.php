<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockRecord;
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
    public function productSaleChart(Request $request) {
        $fromdate = $request->fromdate;
        $todate = $request->todate;

        // Fetch records from the StockRecord table based on the date range
        $records = StockRecord::whereBetween('date', [$fromdate, $todate])->get();

        // Calculate total sale quantity
        $totalSale = $records->sum('sale_qty');

        // Pass the calculated values and records to the view
        return view('dashboard', [
            'totalSale' => $totalSale,
            'stockRecords' => $records, // You can pass all records if needed
        ]);
    }

    public function fetchChartData(Request $request) {
        // Assuming you have the necessary validations in place

        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');
        $itemName = $request->input('itemName');

        // Fetch data from the StockRecord table based on the criteria
        $chartData = StockRecord::select(DB::raw('SUM(sale_qty) as totalSale'), 'date')
            ->where('item_name', $itemName)
            ->whereBetween('date', [$fromDate, $toDate])
            ->groupBy('date')
            ->get();

        // Prepare the data for the chart
        $outlets = $chartData->pluck('outlet_name')->unique();
        $dates = $chartData->pluck('date')->unique();

        $data = [];
        $cumulativeTotals = [];

        foreach ($dates as $date) {
            $dailyTotals = [];
            foreach ($outlets as $outlet) {
                $totalSale = $chartData->where('date', $date)->where('outlet_name', $outlet)->sum('totalSale');
                $dailyTotals[] = $totalSale;
            }

            $cumulativeTotals[] = array_sum($dailyTotals);
        }

        return response()->json([
            'dates' => $dates,
            'cumulativeTotals' => $cumulativeTotals,
        ]);
    }

}
