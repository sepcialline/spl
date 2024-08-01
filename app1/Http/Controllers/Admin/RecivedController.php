<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Rider;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Models\RecivedShipment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RecivedController extends Controller
{
    public function index()
    {
        $data['riders'] = Rider::select('id', 'name')->get();
        $data['vendors'] = VendorCompany::select('id', 'name')->get();


        $date_from = Carbon::now()->format('y-m-d');
        $date_to = Carbon::now()->format('y-m-d');
        if (request()->date_from) {
            $date_from = Carbon::parse(request()->date_from)->format('y-m-d');
        }

        if (request()->date_to) {
            $date_to = Carbon::parse(request()->date_to)->format('y-m-d');
        }

        $query = RecivedShipment::query()->whereBetween('date', [$date_from, $date_to]);

        if (Request()->rider_id && Request()->rider_id != 0) {
            $query->where('rider_id', Request()->rider_id);
        }
        if (Request()->vendor_id && Request()->vendor_id != 0) {
            $query->where('vendor_id', Request()->vendor_id);
        }

        if (Request()->date_from || Request()->date_to) {
            $query->whereBetween('date', [Carbon::parse(Request()->date_from)->format('Y-m-d'), Carbon::parse(Request()->date_to)->format('Y-m-d')]);
        }

        $data['shipments'] = $query->orderBy('id', 'desc')->paginate(30);
        $data['shipments']->appends(request()->query());



        return view('admin.reciveds.index', $data);
    }


    public function create()
    {
        $data['riders'] = Rider::select('id', 'name')->get();
        $data['vendors'] = VendorCompany::select('id', 'name')->get();
        return view('admin.reciveds.create', $data);
    }


    public function store(Request $request)
    {

        $image = null;
        if ($request->hasFile('file')) {
            $image = $request->file != null ? time() . '_' . $request->file->getClientOriginalName() : '';
            $request->file->move(public_path('build/assets/img/uploads/documents'),  $image);
        }

        RecivedShipment::create([
            'rider_id' => $request->rider_id,
            'vendor_id' => $request->vendor_id,
            'vendor_if_not_in_system' => $request->vendor_if_not_in_system,
            'count_of_shipments' => $request->count_of_shipments,
            'date' => Carbon::parse($request->date)->format('Y-m-d'),
            'created_by' => Auth::guard('admin')->user()->name,
            'is_approved' => 1,
            'image' => $image,
        ]);

        toastr()->success(__('admin.msg_success_add'));
        return redirect()->route('admin.recived_shipment_index');
    }

    public function updateStatus(Request $request, String $id )
    {

        try {
            //code...
            $shipment = RecivedShipment::find($id);

            $shipment->update([
                'is_approved' => $request->is_approved
            ]);


            return response($shipment,200);

        } catch (\Throwable $th) {
            return $th;
        }


    }

    public function show($id)
    {

        return view('admin.reciveds.show');
    }


    public function edit($id)
    {
        $data['riders'] = Rider::select('id', 'name')->get();
        $data['vendors'] = VendorCompany::select('id', 'name')->get();
        $data['shipment'] = RecivedShipment::find($id);
        return view('admin.reciveds.edit',$data);
    }

    public function update(Request $request)
    {
        $shipment = RecivedShipment::find($request->id);
        $image = $shipment->image;
        if ($request->hasFile('file')) {
            $image = $request->file != null ? time() . '_' . $request->file->getClientOriginalName() :  $shipment->image;
            $request->file->move(public_path('build/assets/img/uploads/documents'),  $image);
        }

        $shipment->update([
            'rider_id' => $request->rider_id,
            'vendor_id' => $request->vendor_id,
            'vendor_if_not_in_system' => $request->vendor_if_not_in_system,
            'count_of_shipments' => $request->count_of_shipments,
            'date' => Carbon::parse($request->date)->format('Y-m-d'),
            'updated_by' => Auth::guard('admin')->user()->name,
            'image' => $image,
        ]);

        toastr()->success(__('admin.msg_success_update'));
        return redirect()->route('admin.recived_shipment_index');
    }

    public function destroy($id)
    {
    }
}
