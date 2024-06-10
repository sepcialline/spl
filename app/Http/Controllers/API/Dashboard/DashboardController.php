<?php

namespace App\Http\Controllers\API\Dashboard;

use Carbon\Carbon;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Event\Tracer\Tracer;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['from'] = Carbon::now()->format('Y-m-d 00:00:01');
        $data['to'] = Carbon::now()->format('Y-m-d 23:59:59');
        //shipments
        $all_tracking = [];


        $tracking = DB::table('trackings')
            ->select('trackings.*')
            ->where('trackings.rider_id', '=', Auth::id())
            ->groupBy('trackings.shipment_id')
            ->orderBy('trackings.shipment_id', 'desc')
            ->whereDate('time', Carbon::today())
            ->get();


        // return $tracking;
        $tracing = [];
        foreach($tracking as $track){
            $last_track_same_shipment= Tracking::whereDate('time',  Carbon::today())->where('shipment_id',$track->shipment_id)->orderBy('id','desc')->first();
            // return $last_track_same_shipment;
            if($last_track_same_shipment->rider_id == Auth::id()){
                $tracing[]=$last_track_same_shipment;
            }
        }

        $collect_tracing =  collect($tracing);

        $stats = [
            'all' => count($collect_tracing),
            'pending' => count($collect_tracing->where('status_id',2)),
            'delayed' => count($collect_tracing->where('status_id',4)),
            'transferred' => count($collect_tracing->where('status_id',5)),
            'cancelled' => count($collect_tracing->where('status_id',6)),
            'damaged' => count($collect_tracing->where('status_id',7)),
            'delivered' =>  count($collect_tracing->where('status_id',3)),
            'returned' =>  count($collect_tracing->where('status_id',9)),
        ];

        $expenses = ['pending' => Expense::where('rider_id', Auth::id())->whereDate('date', Carbon::today())->sum('value')];
        // $cash_expense = Expense::where('rider_id', Auth::id())->where('payment_type', 1)->sum('value');
        $cash_expense = Expense::where('rider_id', Auth::id())->whereDate('date', Carbon::today())->where('payment_type', 1)->sum('value');
        // COD
        // TR SP // On Client
        // TR VE // On Client
        // $data['sum'] = Payment::where('rider_id', Auth::id())
        //     ->where('payment_method_id', 1)
        //     ->where('is_rider_has', 1)
        //     ->where('deleted_at', Null)
        //     ->with('shipment')
        //     ->sum('amount');
        $data['sum'] = Payment::where('rider_id', Auth::id())
            ->where('payment_method_id', 1)
            ->where('is_rider_has', 1)
            ->whereDate('date', Carbon::today())
            ->where('deleted_at', Null)
            ->with('shipment')
            ->sum('amount');

        $hand_cash = ['value' => $data['sum'] -  $cash_expense];

        $message = ['success' => 0, 'message' => 'Success'];

        return response(compact('stats', 'expenses',  'hand_cash', 'message'), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
