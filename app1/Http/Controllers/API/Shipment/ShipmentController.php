<?php

namespace App\Http\Controllers\API\Shipment;

use Carbon\Carbon;
use App\Models\Shipment;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ShipmentResource;
use App\Models\Payment;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        $status = 0;
        // $query = Shipment::query()->whereDate('delivered_date', Carbon::today())->where('rider_id', Auth::id());

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        // $query = Shipment::query()->with('lastTracking')->whereHas('lastTracking',function($q){
        //     $q->where('rider_id',Auth::id());
        // });

        $tracking = DB::table('trackings')
            ->select('trackings.*')
            ->where('trackings.rider_id', '=', Auth::id())
            ->groupBy('trackings.shipment_id')
            ->orderBy('trackings.shipment_id', 'desc')
            ->whereDate('time', Carbon::today())
            ->get();



        // return $tracking;
        $tracing = [];
        foreach ($tracking as $track) {
            $last_track_same_shipment = Tracking::where('shipment_id', $track->shipment_id)->orderBy('id', 'desc')->first();
            // return $last_track_same_shipment;
            if ($last_track_same_shipment->rider_id == Auth::id()) {
                $tracing[] = $last_track_same_shipment;
            }
        }

        // return collect($tracing)->pluck('id');

        $query = Tracking::query()->whereIn('id',collect($tracing)->pluck('id'))->orderBy('id','desc');


        if ($request['query'] == 'all') {
            // $status = [2, 3, 4, 5, 6];
            $status = [2, 3, 5, 6];
            // $query->whereBetween('delivered_date',[$today,$tomorrow]);
            $query->whereDate('time',$today);


        } else if ($request['query'] == 'pending') {
            $status = [2];
            $query->whereDate('time',$today);


        } else if ($request['query'] == 'delivered') {
            $status = [3];
            $query->whereDate('time',$today);


        } else if ($request['query'] == 'delayed') {
            $status = [4];
            $query->whereDate('time',$today);


        } else if ($request['query'] == 'transferred') {
            $status = [5];
            $query->whereDate('time',$today);


        } else if ($request['query'] == 'canceled') {
            $status = [6];
            $query->whereDate('time',$today);


        } else if ($request['query'] == 'damaged') {
            $status = [7];
            $query->whereDate('time',$today);


        } else if ($request['query'] == 'duplicated') {
            $status = [8];
            $query->whereDate('time',$today);


        } else if ($request['query'] == 'returned') {
            $status = [9];
            $query->whereDate('time',$today);


        } else {
            return 'error';
        }

        // return $query->whereIn('status_id', $status)->get();





        $shipments = ShipmentResource::collection($query->whereIn('status_id', $status)->with('Company')
            ->with('Status')->with('shipment')->orderBy('id', 'desc')->get());

        $message = ['success' => 0, 'message' => 'Success'];
        return response(compact('shipments', 'message'), 200);
    }
    public function updateOrderStatus(Request $request)
    {
        // you will recieve status id, shipment no, amount(delivered and transferred),
        //if new you will recieve status_id
        //if delivered you will recieve amount(delivered/transferred), notes, image, reason, payment divided or not
        //ex: {status_id: statusId, payment_divided: false, delivered_amount: 0, transferred_amount: 0, image: null, notes: null, emirate_id: null}
        return [$request->hasFile('file'), $request->all()];
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
        // you will recieve status id, shipment no, amount(delivered and transferred),
        //if new you will recieve status_id
        //if delivered you will recieve amount(delivered/transferred), notes, image, reason, payment divided or not
        //ex: {status_id: statusId, payment_divided: false, delivered_amount: 0, transferred_amount: 0, image: null, notes: null, emirate_id: null}
        return [$request->hasFile('file'), $request->all(), $id];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
