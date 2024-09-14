<?php

namespace App\Http\Controllers\Vendor\Shipment;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Rider;
use App\Models\Cities;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Branches;
use App\Models\Emirates;
use App\Models\FeesType;
use App\Models\Shipment;
use App\Models\Tracking;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Models\PaymentMethods;
use App\Models\ProductDetails;

use App\Helpers\ShipmentHelper;
use App\Models\ShipmentContent;
use App\Imports\ShipmentsImport;
use App\Models\ShipmentStatuses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ShipmentController extends Controller
{
    public function index()
    {
        $data['companies'] = VendorCompany::where('vendor_id',Auth::guard('vendor')->user()->id)->select('id', 'name')->get();
        $data['riders'] = Rider::select('id', 'name')->get();
        $data['payment_methods'] = PaymentMethods::select('id', 'name')->get();
        $data['shipment_status'] = ShipmentStatuses::select('id', 'name')->get();
        $data['emirates'] = Emirates::select('id', 'name')->get();
        $data['cities'] = Cities::select('id', 'name')->get();
        $data['branches'] = Branches::select('id', 'branch_name')->get();
        $date_from = Carbon::today()->format('y-m-d');
        $date_to = Carbon::today()->format('y-m-d');



        // if (request()->input('action') == 'search_action') {


        // return request();


        if (request()->date_from) {
            $date_from = Carbon::parse(request()->date_from)->format('y-m-d');
        }
        if (request()->date_to) {
            $date_to = Carbon::parse(request()->date_to)->format('y-m-d');
        }

        $query = Shipment::query()->whereBetween('delivered_date', [$date_from, $date_to])->with('Client')->where('company_id', Request()->company_id);

        $request = request();

        $all_shipments = ShipmentHelper::searchShipment($request, $query);

        $data['from'] = $date_from;
        $data['to'] = $date_to;






        if (request()->input('action') == 'report') {

            $emirates = [];
            $statues = [];
            $data['shipments'] = $all_shipments->join('users', 'shipments.user_id', '=', 'users.id')
                ->orderBy('shipments.delivered_date', 'desc')
                ->orderBy('users.emirate_id', 'ASC')
                ->orderBy('users.city_id', 'ASC')
                ->orderBy('users.address', 'ASC')
                ->select('shipments.*') //see PS:
                ->get();


            foreach ($data['shipments'] as $shipment) {
                $emirates[] = $shipment->Client->emirate_id;
            }
            $data['emirates_shipment'] = Emirates::whereIn('id', $emirates)->orderBy('id', 'ASC')->groupBy('id')->get();

            return view('vendor.shipment.reports.shipments_report', $data);
        } else {
            $data['shipments'] = $all_shipments->join('users', 'shipments.user_id', '=', 'users.id')
                ->orderBy('shipments.delivered_date', 'desc')
                ->orderBy('users.emirate_id', 'ASC')
                ->orderBy('users.city_id', 'ASC')
                ->orderBy('users.address', 'ASC')
                ->select('shipments.*') //see PS:
                ->paginate(30);
            return view('vendor.shipment.index', $data);
        }



        // }

    }

    public function search(Request $request)
    {
        $data['search'] = $request->search;
        $query = Shipment::query()->where('company_id', Auth::guard('vendor')->user()->company_id);
        $query->where('shipment_no', 'like', '%' . $request->search  . '%')
            ->orWhere('shipment_refrence', 'like', '%' . $request->search  . '%');
        $query->orWhereHas('Client', function ($q) use ($request) {
            return $q->where('mobile', 'like', '%' . $request->search  . '%');
        });
        $query->orWhereHas('Client', function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search  . '%');
        });
        $data['shipments'] = $query->paginate('50');

        return view('vendor.shipment.search', $data);
    }

    public function create()
    {
        $data['emirates'] = Emirates::select('id', 'name')->get();
        $data['companies'] = VendorCompany::select('id', 'name')->get();
        $data['payment_methods'] = PaymentMethods::select('id', 'name')->get();
        $data['fees_types'] = FeesType::select('id', 'name')->get();
        $data['branches'] = Branches::where('is_main', 0)->where('status', 1)->select('id', 'branch_name')->get();
        $data['vendor_companies'] = VendorCompany::where('vendor_id',Auth::guard('vendor')->user()->id)->select('id','name')->get();


        $now = Carbon::now();
        $tz = 'Asia/Dubai';
        $start = Carbon::createFromTimeString('00:01', $tz);
        $end = Carbon::createFromTimeString('15:59', $tz);

        $data['date'] = Carbon::today($tz)->format('Y-m-d');

        if ($now->between($start, $end)) {
            $data['date'] = Carbon::today($tz)->format('Y-m-d');
        } else {
            $data['date'] =  Carbon::today($tz)->addDay(1)->format('Y-m-d');
        }


        // return $data;
        return view('vendor.shipment.create', $data);
    }

    public function store(Request $request)
    {
        $guard = 'vendor';
        $ref = ''; // start with in refrence code
        $states = ShipmentHelper::states($request);

        if ($request->input('action') == "just_save") {
            // just save shipment
            $user = ShipmentHelper::checkUser($request, $guard);

            $shipment = ShipmentHelper::storeShipment($request, $user, $guard, $states['rider_should_recive'], $states['vendor_due'], $states['specialline_due'], $ref);

            if ($request->product_ids) {
                $shipment_content = ShipmentHelper::shipmentContentFromStock($shipment, $request, $guard);
            } elseif ($request->content_text) {
                $shipment_content = ShipmentHelper::shipmentContentText($shipment, $request, $guard);
            }
        } else if ($request->input('action') == "save_and_send_invoice") {
            // save and send invoice
        } else {
            // save and print
            // Redirect::away() or Redirect:to()
        }

        $action = __('admin.shipments_create_shipment');
        $rider = $shipment->rider_id;
        $tracking = ShipmentHelper::shipmentTracking($shipment, $guard, $action , $rider);
        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }

    public function shipment_actions($id)
    {
        $data = ShipmentHelper::ShipmentViewPrintInvoicePdf($id);
        return view('vendor.shipment.actions', $data);
    }


    public function edit($id)
    {

        $data = ShipmentHelper::ShipmentViewPrintInvoicePdf($id);
        $data['vendor_companies'] = VendorCompany::where('vendor_id',Auth::guard('vendor')->user()->id)->select('id','name')->get();

        return view('vendor.shipment.edit', $data);
    }

    public function update(Request $request)
    {
        $guard = 'vendor';
        
        $states = ShipmentHelper::states($request);
        
        if ($request->input('action') == "just_save") {
            // just save shipment
            $user = ShipmentHelper::checkUser($request, $guard);
            
            $shipment = ShipmentHelper::updateShipment($request, $user, $guard, $states['rider_should_recive'], $states['vendor_due'], $states['specialline_due']);

            if ($request->product_ids) {
                $shipment_content = ShipmentHelper::shipmentContentFromStock($shipment, $request, $guard);
            } elseif ($request->content_text) {
                $shipment_content = ShipmentHelper::shipmentContentText($shipment, $request, $guard);
            }
        } else if ($request->input('action') == "save_and_send_invoice") {
            // save and send invoice
        } else {
            // save and print
            // Redirect::away() or Redirect:to()
        }

        $action = __('admin.shipments_update_shipment');
        $rider = $shipment->rider_id;
        $tracking = ShipmentHelper::shipmentTracking($shipment, $guard, $action , $rider);
        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }

    public function printInvoice($id)
    {
        $data = ShipmentHelper::ShipmentViewPrintInvoicePdf($id);
        $data['barcode'] = ShipmentHelper::generateBarCode($data['shipment']->shipment_no);

        return view('vendor.shipment.print_invoice', $data);
    }





    public function delete(Request $request)
    {
        $guard = 'vendor';
        $shipment = Shipment::where('id', $request->id)->first();
        if ($shipment) {
            $shipment->update(['deleted_by' => Auth::guard('vendor')->user()->name]);

            $shipment->delete();
            // $shipment->update([
            //     'deleted_by' => Auth::guard($guard)->user()->name
            // ]);
            if ($shipment->delete()) {
                $shipment->shipmentContents()->delete();
                $action = __('admin_delete_shipment');
                $rider = $shipment->rider_id;
                ShipmentHelper::shipmentTracking($shipment, $guard, $action , $rider);
                return response()->json(['code' => 200]);
            }
        }
    }


    public function printSticker($id)
    {
        $data = ShipmentHelper::ShipmentViewPrintInvoicePdf($id);
        $barcode = ShipmentHelper::generateBarCode($data['shipment']->shipment_no);
        return view('vendor.shipment.sticker', $data)->with('barcode', $barcode);
    }


    public function shipmentCompanyHasStock(Request $request)
    {
        $company = VendorCompany::where('id', $request->company_id)->first();

        $vendor_rate = $company->customer_rate;
        if ($request->fees_type_id == 2) {
            $vendor_rate = $company->vendor_rate;
        }
        if ($company->has_stock == 1) {

            $products = Product::where('company_id', $request->company_id)->get();
            return response()->json(['code' => 200, 'data' => $products, 'vendor_rate' => $vendor_rate]);
        } else {
            return response()->json(['code' => 202, 'vendor_rate' => $vendor_rate]);
        }
    }

    public function shipmentProdcutDetails(Request $request)
    {
        if (ProductDetails::where('product_id', $request->product_id)->where('branch_id', $request->branch_created_id)->exists()) {
            $product_details = ProductDetails::where('product_id', $request->product_id)->where('branch_id', $request->branch_created_id)->select('id', 'quantity')->first();
            if ($product_details->quantity > 0) {
                return response()->json(['code' => '200', 'data' => $product_details->quantity]);
            }
        } else {
            return response()->json(['code' => '202', 'msg' => 'this product is not in your warehouse']);
        }
    }
    public function shipmentGetCities(Request $request)
    {
        return Cities::where('emirate_id', $request->emirate_id)->select('id', 'name')->get();
    }

    public function getShipmentProducts(Request $request)
    {
        return ShipmentContent::where('shipment_id', $request->shipment_id)->with('product')->get();
    }

    public function returnProductToStock(Request $request)
    {
        $shipment_content = ShipmentContent::where('id', $request->id)->first();
        $product_details = ProductDetails::where('product_id', $shipment_content->product_id)->where('branch_id', $request->branch_id)->first();


        $product_details->update([
            'quantity' => $product_details->quantity + $shipment_content->quantity
        ]);

        if ($product_details->update()) {
            $shipment_content->delete();
            if ($shipment_content->delete()) {
                return response()->json(['code' => 200]);
            }
        }
    }

    public function getShipmentClient(Request $request)
    {
        $user = User::where('mobile', '971' . $request->mobile)->first();
        if ($user) {
            return response()->json(['code' => 200, 'user' => $user]);
        } else {
            return response()->json(['code' => 203]);
        }
    }


    public function import(Request $request)
    {
        $validator = Validator::make(
            [
                'file'      => $request->file,
                'extension' => strtolower($request->file->getClientOriginalExtension()),
            ],
            [
                'file'          => 'required',
                'extension'      => 'required|in:xlsx,xls',
            ]
          );
        Excel::import(new ShipmentsImport, request()->file('file'));
        toastr()->success('File has been uploaded successfully!', 'Congrats');
        return redirect()->back();
    }

    public function downloadfile()
    {
        $filepath = public_path('build/assets/shipments.xlsx');
        return Response::download($filepath);
    }

        /////////////////////////////////
        public function multi_invoices()
        {
            $data['vendor_companies'] = VendorCompany::where('vendor_id', Auth::guard('vendor')->user()->id)->get();
            $data['emirates'] = Emirates::select('id', 'name')->get();
            $data['status_list'] = ShipmentStatuses::select('id','name') ->get();
            return view('vendor.shipment.multi_invoices.multi_invoices', $data);
        }

        public function printVendorInvoices(Request $request)
        {
            $date_from = Carbon::now()->format('Y-m-d');
            $date_to = Carbon::now()->format('Y-m-d');


            if (request()->date_from) {
                $date_from = Carbon::parse(request()->date_from)->format('Y-m-d');
            }
            if (request()->date_to) {
                $date_to = Carbon::parse(request()->date_to)->format('Y-m-d');
            }

            //         $timestamp = '2024-02-28 19:50:00';
            // $date = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp,'UTC');
            // return $date_to;

            $query = Shipment::query()->whereBetween('delivered_date', [$date_from, $date_to]);


            $all_shipments = ShipmentHelper::searchShipment($request, $query);
            $vendor_shipments = $all_shipments->get();

            $data['shipments'] = array();
            $data['barcodes'] = array();
            foreach ($vendor_shipments as $shipment) {
                $data['shipments'][] = ShipmentHelper::ShipmentViewPrintInvoicePdf($shipment->id);
                $data['barcodes'][] = ShipmentHelper::generateBarCode($shipment->shipment_no);
            }

            // return '<h1>مع تحيات القسم البرمجي | يتم العمل على هذه الصفحة ستراها قريياً ❤️</h1>';


            return view('vendor.shipment.multi_invoices.print_multi_invoices', $data);
        }




}
