<?php

namespace App\Http\Controllers\Admin\Shipment;

use App\Exports\operationReportExport;
use App\Exports\ShipmentExport;
use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Rider;
use App\Models\Cities;
use App\Models\Company;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Branches;
use App\Models\Emirates;
use App\Models\FeesType;
use App\Models\Shipment;
use App\Models\Tracking;
use Illuminate\Support\Arr;
use App\Models\ShopifyOrder;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Models\PaymentMethods;
use App\Models\ProductDetails;
use Illuminate\Support\Facades\Response;

use App\Helpers\ShipmentHelper;
use App\Http\Middleware\Branch;
use App\Models\ShipmentContent;
use App\Models\ShipmentStatuses;
use Illuminate\Support\Facades\DB;
use App\Models\ShopifyOrderContent;
use function App\Helpers\checkUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use function App\Helpers\storeSipment;
use App\Imports\EmployeeShipmetnImport;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Admin\ReportController;
use App\Models\RecivedShipment;

class ShipmentController extends Controller
{

    function __construct()
    {
        $this->middleware(['permission:admin-Shipment-Report'], ['only' => ['index']]);
        $this->middleware(['permission:admin-Shipment-vendor-shipments'], ['only' => ['vendorsShipment']]);
        $this->middleware(['permission:admin-Shipment-add'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:admin-Shipment-add'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:admin-Shipment-edit|admin-Shipment-assign rider|admin-Shipment-print|admin-Shipment-change-status'], ['only' => ['shipment_actions']]);
        $this->middleware(['permission:admin-Shipment-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:admin-Shipment-print'], ['only' => ['printInvoice']]);
        $this->middleware(['permission:admin-Shipment-assign rider'], ['only' => ['assignRider', 'assignToRider', 'assignShipments']]);
        $this->middleware(['permission:admin-Shipment-change-status'], ['only' => ['changeStatus']]);
        $this->middleware(['permission:admin-Shipment-delete'], ['only' => ['delete']]);
        $this->middleware(['permission:admin-Shipment-print'], ['only' => ['printSticker']]);
        $this->middleware(['permission:admin-Shipment-print'], ['only' => ['multi_stickers']]);
        $this->middleware(['permission:admin-Shipment-print'], ['only' => ['multi_stickers', 'printVendorStickers']]);
        $this->middleware(['permission:admin-Shipment-daily-report'], ['only' => ['dailyShipmentRider']]);
    }

    public function index()
    {
        $data['companies'] = VendorCompany::where('status', 1)->select('id', 'name')->get();
        $data['riders'] = Rider::select('id', 'name')->get();
        $data['payment_methods'] = PaymentMethods::select('id', 'name')->get();
        $data['shipment_status'] = ShipmentStatuses::whereIn('id', [10, 2, 3, 4, 5, 6, 7, 8, 9])->select('id', 'name')->get();
        $data['emirates'] = Emirates::select('id', 'name')->get();
        $data['cities'] = Cities::select('id', 'name')->get();
        $data['branches'] = Branches::where('is_main', 0)->select('id', 'branch_name')->get();
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

        $query = Shipment::query()->whereBetween('delivered_date', [$date_from, $date_to])->with('Client');

        $request = request();

        $all_shipments = ShipmentHelper::searchShipment($request, $query);

        $data['from'] = $date_from;
        $data['to'] = $date_to;




        if(request()->input('action') == 'export'){
            return Excel::download(new ShipmentExport, 'from'.Carbon::parse($request->date_from)->format('Y-m-d').'to'.Carbon::parse($request->date_to)->format('Y-m-d').'.xlsx');
        }


        if (request()->input('action') == 'report') {

            $emirates = [];
            $vendors = [];
            $data['shipments'] = $all_shipments->whereIn('status_id', [10, 2, 3, 4, 5, 6, 7, 8, 9])->join('users', 'shipments.user_id', '=', 'users.id')
                ->orderBy('shipments.delivered_date', 'desc')
                ->orderBy('users.emirate_id', 'ASC')
                ->orderBy('users.city_id', 'ASC')
                ->orderBy('users.address', 'ASC')
                ->select('shipments.*') //see PS:
                ->get();


            foreach ($data['shipments'] as $shipment) {
                $emirates[] = $shipment->Client->emirate_id;
                $vendors[] = $shipment->company_id;
            }
            $data['emirates_shipment'] = Emirates::whereIn('id', $emirates)->orderBy('id', 'ASC')->groupBy('id')->get();
            $data['vendors_shipment'] = VendorCompany::whereIn('id', $vendors)->orderBy('id', 'ASC')->groupBy('id')->get();

            return view('admin.shipment.reports.shipments_report', $data);
        } else {
            $data['shipments'] = $all_shipments->whereIn('status_id', [10, 2, 3, 4, 5, 6, 7, 8, 9])->join('users', 'shipments.user_id', '=', 'users.id')
                ->orderBy('shipments.delivered_date', 'desc')
                ->orderBy('users.emirate_id', 'ASC')
                ->orderBy('users.city_id', 'ASC')
                ->orderBy('users.address', 'ASC')
                ->select('shipments.*') //see PS:
                ->paginate(30);
            return view('admin.shipment.index', $data);
        }
    }

    public function vendorsShipment()
    {
        $data['companies'] = VendorCompany::select('id', 'name')->get();
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

        $query = Shipment::query()->whereBetween('delivered_date', [$date_from, $date_to])->with('Client');

        $request = request();

        $all_shipments = ShipmentHelper::searchShipment($request, $query);

        $data['from'] = $date_from;
        $data['to'] = $date_to;






        if (request()->input('action') == 'report') {

            $emirates = [];
            $statues = [];
            $data['shipments'] = $all_shipments->where('status_id', 1)->join('users', 'shipments.user_id', '=', 'users.id')
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

            return view('admin.shipment.reports.shipments_report', $data);
        } else {
            $data['shipments'] = $all_shipments->where('status_id', 1)->join('users', 'shipments.user_id', '=', 'users.id')
                ->orderBy('shipments.delivered_date', 'desc')
                ->orderBy('users.emirate_id', 'ASC')
                ->orderBy('users.city_id', 'ASC')
                ->orderBy('users.address', 'ASC')
                ->select('shipments.*') //see PS:
                ->paginate(30);

            return view('admin.shipment.vendor_shipments', $data);
        }
    }


    public function search(Request $request)
    {
        $data['search'] = $request->search;
        $query = Shipment::query();
        $query->where('shipment_no', 'like', '%' . $request->search  . '%')
            ->orWhere('shipment_refrence', 'like', '%' . $request->search  . '%');
        $query->orWhereHas('Client', function ($q) use ($request) {
            return $q->where('mobile', 'like', '%' . $request->search  . '%');
        });
        $query->orWhereHas('Client', function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search  . '%');
        });
        $data['shipments'] = $query->paginate('50');

        return view('admin.shipment.search', $data);
    }

    public function create()
    {
        $data['emirates'] = Emirates::select('id', 'name')->get();
        $data['companies'] = VendorCompany::where('status', 1)->select('id', 'name')->get();
        $data['payment_methods'] = PaymentMethods::select('id', 'name')->get();
        $data['fees_types'] = FeesType::select('id', 'name')->get();
        $data['branches'] = Branches::where('is_main', 0)->where('status', 1)->select('id', 'branch_name')->get();

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
        return view('admin.shipment.create', $data);
    }


    public function createShopifyShipment($order)
    {
        $data['emirates'] = Emirates::select('id', 'name')->get();
        $data['companies'] = VendorCompany::select('id', 'name')->get();
        $data['payment_methods'] = PaymentMethods::select('id', 'name')->get();
        $data['fees_types'] = FeesType::select('id', 'name')->get();
        $data['branches'] = Branches::where('is_main', 0)->where('status', 1)->select('id', 'branch_name')->get();
        $data['order'] = ShopifyOrder::where('order_id', $order)->first();
        $data['order_contents'] = ShopifyOrderContent::where('order_id', $order)->get();
        // return $data;
        return view('admin.shipment.create_shopify_shipment', $data);
    }


    public function store(Request $request)
    {
        $guard = 'admin';
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
        $rider = $shipment->rider_id;
        $action = __('admin.shipments_create_shipment');
        $tracking = ShipmentHelper::shipmentTracking($shipment, $guard, $action, $rider);
        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }

    public function shipment_actions($id)
    {
        $data = ShipmentHelper::ShipmentViewPrintInvoicePdf($id);
        $data['trackings'] = Tracking::where('shipment_id', $id)->get();
        return view('admin.shipment.actions', $data);
    }


    public function edit($id)
    {

        $data = ShipmentHelper::ShipmentViewPrintInvoicePdf($id);
        return view('admin.shipment.edit', $data);
    }

    public function update(Request $request)
    {
        $guard = 'admin';

        $states = ShipmentHelper::states($request);

        if ($request->input('action') == "just_save") {
            // just save shipment
            // return $request;
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
        $rider = $shipment->rider_id;
        $action = __('admin.shipments_update_shipment');
        $tracking = ShipmentHelper::shipmentTracking($shipment, $guard, $action, $rider);
        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }

    public function printInvoice($id)
    {
        $data = ShipmentHelper::ShipmentViewPrintInvoicePdf($id);
        $data['barcode'] = ShipmentHelper::generateBarCode($data['shipment']->shipment_no);
        // return $data;
        return view('admin.shipment.print_invoice', $data);
    }



    public function assignRider(Request $request)
    {
        $guard = 'admin';
        $rider = Rider::where('id', $request->rider_id)->first();
        $action = __('admin.assign_shipment_to ') . $rider->name;
        $shipment = Shipment::where('id', $request->id)->first();
        if ($shipment && $shipment->status_id != 3) {
            $shipment->update([
                'rider_id' => $request->rider_id,
                'status_id' => 2
            ]);
            if ($shipment->update()) {
                $rider = $shipment->rider_id;
                ShipmentHelper::shipmentTracking($shipment, $guard, $action, $rider);
                toastr()->success(__('admin.msg_success_update'));
                return redirect()->back();
            }
        } else {
            toastr()->error('لا يمكن تعديل السائق في حال كانت الشحنة مسلمة');
            return redirect()->back();
        }
    }

    public function changeStatus(Request $request)
    {

        $guard = 'admin';

        $shipment = Shipment::where('id', $request->id)->first();


        $shipmentChangeStatus = ShipmentHelper::shipmentChangeStatus($request, $shipment, $guard);
        toastr()->success(__('admin.msg_success_update'));
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $guard = 'admin';
        $shipment = Shipment::where('id', $request->id)->first();
        if ($shipment) {
            $shipment->update(['deleted_by' => Auth::guard('admin')->user()->name]);

            $shipment->delete();
            // $shipment->update([
            //     'deleted_by' => Auth::guard($guard)->user()->name
            // ]);
            if ($shipment->delete()) {
                $shipment->shipmentContents()->delete();
                $action = __('admin.delete');
                $rider = $shipment->rider_id;
                ShipmentHelper::shipmentTracking($shipment, $guard, $action, $rider);
                return response()->json(['code' => 200]);
            }
        }
    }


    public function printSticker($id)
    {
        $data = ShipmentHelper::ShipmentViewPrintInvoicePdf($id);
        $barcode = ShipmentHelper::generateBarCode($data['shipment']->shipment_no);
        return view('admin.shipment.sticker', $data)->with('barcode', $barcode);
    }

    public function multi_stickers()
    {
        $data['companies'] = VendorCompany::select('id', 'name')->get();
        $data['emirates'] = Emirates::select('id', 'name')->get();
        return view('admin.shipment.multi_stickers', $data);
    }
    public function printVendorStickers(Request $request)
    {

        $date_from = Carbon::today()->format('Y-m-d');
        $date_to = Carbon::today()->format('Y-m-d');


        if (request()->date_from) {
            $date_from = Carbon::parse(request()->date_from);
        }
        if (request()->date_to) {
            $date_to = Carbon::parse(request()->date_to);
        }

        //         $timestamp = '2024-02-28 19:50:00';
        // $date = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp,'UTC');
        // return $date;

        $query = Shipment::query()->whereBetween('delivered_date', [$date_from, $date_to]);


        $all_shipments = ShipmentHelper::searchShipment($request, $query);
        $vendor_shipments = $all_shipments->get();

        $data['shipments'] = array();
        $data['barcodes'] = array();
        foreach ($vendor_shipments as $shipment) {
            $data['shipments'][] = ShipmentHelper::ShipmentViewPrintInvoicePdf($shipment->id);
            $data['barcodes'][] = ShipmentHelper::generateBarCode($shipment->shipment_no);
        }
        return view('admin.shipment.print_multi_sticker', $data);
    }

    /////////////////////////////////
    public function multi_invoices()
    {
        $data['companies'] = VendorCompany::select('id', 'name')->get();
        $data['emirates'] = Emirates::select('id', 'name')->get();
        return view('admin.shipment.multi_invoices.multi_invoices', $data);
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
        // return  $data['barcodes'][0];

        // return '<h1>مع تحيات القسم البرمجي | يتم العمل على هذه الصفحة ستراها قريياً ❤️</h1>';


        return view('admin.shipment.multi_invoices.print_multi_invoices', $data);
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
        $user = User::where($request->mobile)->first();
        if ($user) {
            return response()->json(['code' => 200, 'user' => $user]);
        } else {
            return response()->json(['code' => 203]);
        }
    }


    public function dailyShipmentRider()
    {
        $data['riders'] = Rider::where('status',1)->select('id', 'name')->get();

        $data['from'] = Carbon::now()->format('Y-m-d 00:00:01');
        $data['to'] = Carbon::now()->format('Y-m-d 23:59:59');

        if (Request()->date) {
            $data['from'] = Carbon::parse(Request()->date)->format('Y-m-d 00:00:01');
            $data['to'] = Carbon::parse(Request()->date)->format('Y-m-d 23:59:59');
        }

        $data['all'] = 0;
        $data['expenses'] = array();
        $data['commissions'] = 0;
        $data['cash_in_hand'] = 0;
        $data['shipments'] = array();
        $data['cod'] = 0;
        $data['tr_to_bank'] = 0;
        $data['tr_to_vendor'] = 0;




        $data['tracking'] = DB::table('trackings')
            ->select('trackings.*')
            ->where('trackings.rider_id', '=', Request()->rider_id)
            ->groupBy('trackings.shipment_id')
            ->orderBy('trackings.shipment_id', 'desc')
            ->whereDate('time', Request()->date)
            ->get();



        if (count($data['tracking']) > 0) {

            foreach ($data['tracking'] as $track) {
                $last_track_same_shipment = Tracking::where('shipment_id', $track->shipment_id)->orderBy('id', 'desc')->whereDate('time', Request()->date)->first();
                // return $last_track_same_shipment;
                if ($last_track_same_shipment->rider_id == Request()->rider_id) {
                    $data['shipments'][] = $last_track_same_shipment;
                }
            }

            // return $data['shipments'];


            // $data['all_shipments'] = Shipment::whereIn('id', collect($data['shipments'])->pluck('shipment_id'))->get();
            $data['all_shipments'] = $data['shipments'];





            $companies_id = VendorCompany::whereIn('id', collect($data['all_shipments'])->pluck('company_id'))->pluck('id');

            $data['vendor_count_shipments'] = array();
            foreach ($companies_id as $company_id) {




                $data['vendor_count_shipments'][] = [
                    'vendor' => VendorCompany::where('id', $company_id)->first()->name,
                    'count' => collect($data['all_shipments'])->where('company_id', $company_id)->count(),
                    'shipments' => collect($data['all_shipments'])->where('company_id', $company_id)->groupBy('status_id'),
                    // 'statuses'=>ShipmentStatuses::whereIn('id',collect($data['all_shipments'])->where('company_id',$company_id)->pluck('status_id'))->select('id','name')->get(),
                ];
            }



            // return $data['vendor_count_shipments'][0]['shipments'][2];
            // return $data['operation']=[
            //     'vendors'=> VendorCompany::whereIn('id',$companies_id)->select('id','name')->get(),
            //     'count' =
            // ];
            // return $data['all_shipments'];

            $data['all'] = count(collect($data['shipments']));
            $data['in_progress'] =  count(collect($data['shipments'])->where('status_id', 2));
            $data['delayed'] = count(collect($data['shipments'])->where('status_id', 4));
            $data['transferred'] = count(collect($data['shipments'])->where('status_id', 5));
            $data['canceled'] = count(collect($data['shipments'])->where('status_id', 6));
            $data['damaged'] = count(collect($data['shipments'])->where('status_id', 7));
            $data['delivered'] = count(collect($data['shipments'])->where('status_id', 3));
            $data['returned_to_store'] =  count(collect($data['shipments'])->where('status_id', 9));



            $data['done_shipments'] = Tracking::whereIn('id', collect($data['shipments'])->pluck('id'))->whereIn('status_id', [3, 9])->count();

            //cash in rider hand
            $all_delivered = Tracking::whereIn('id', collect($data['shipments'])->pluck('id'))->whereIn('status_id', [3, 9])->pluck('shipment_id');

            $data['cod'] =  Payment::whereIn('shipment_id', $all_delivered)->where('rider_id', Request()->rider_id)
                // ->where('is_rider_has', 1)
                ->where('payment_method_id', 1)
                ->sum('amount');
            $data['tr_to_bank'] =  Payment::whereIn('shipment_id', $all_delivered)->where('rider_id', Request()->rider_id)
                // ->where('is_bank_has', 1)
                ->where('payment_method_id', 2)
                ->sum('amount');
            $data['tr_to_vendor'] =  Payment::whereIn('shipment_id', $all_delivered)->where('rider_id', Request()->rider_id)
                // ->where('is_vendor_has', 1)
                ->where('payment_method_id', 3)
                ->sum('amount');



            // حساب عمولة المندوب
            // 1- 10 => 0.75
            // 11 - 20 => 1
            // 21 - 30 => 1.5



            $count_deliverd =  $data['done_shipments'];


            $prize = 0;
            if ((collect($data['shipments'])->count() > $all_delivered->count()) && (count($all_delivered) > 19)) {
                $prize = 25;
            }

            $full_prize = 0;
            if ((collect($data['shipments'])->count() == $all_delivered->count()) && (count($all_delivered) > 19)) {
                $full_prize = 30;
            }


            if ($count_deliverd >= 1 && $count_deliverd <= 10) {
                $data['commissions'] = ($count_deliverd * 0.75);
            } elseif ($count_deliverd >= 11 && $count_deliverd <= 20) {
                // count_deliverd - 10

                $sub_10 = $count_deliverd - 10;

                $first_10_shipment = (10 * 0.75);
                $second_10_shipment = ($sub_10 * 1);
                $data['commissions'] = $first_10_shipment + $second_10_shipment +  $prize + $full_prize;
            } elseif ($count_deliverd >= 21 && $count_deliverd <= 30) {

                // count_deliverd - 20
                $sub_20 = $count_deliverd - 20;

                $first_10_shipment = (10 * 0.75);
                $second_10_shipment = (10 * 1);
                $third_10_shipment = ($sub_20  * 1.5);

                $data['commissions'] = $first_10_shipment + $second_10_shipment + $third_10_shipment +  $prize + $full_prize;
            } elseif ($count_deliverd >= 31) {

                // count_deliverd - 30
                $sub_30 = $count_deliverd - 30;

                $first_10_shipment = (10 * 0.75);
                $second_10_shipment = (10 * 1);
                $third_10_shipment = (10  * 1.5);
                $fourth_10_shipment = ($sub_30  * 1.5);

                $data['commissions'] = $first_10_shipment + $second_10_shipment + $third_10_shipment + $fourth_10_shipment +  $prize + $full_prize;
            }
        }

        $recived_shipments = RecivedShipment::where('rider_id',Request()->rider_id)->where('is_approved', 1)->whereDate('date',Carbon::parse(Request()->date)->format('Y-m-d'))->select('count_of_shipments')->get();
        $data['recived_shipments_count'] = $recived_shipments->sum('count_of_shipments');
        $data['recived_shipments_prize'] = $data['recived_shipments_count'] * 0.35;

        // expenses
        $data['expenses'] = Expense::whereBetween('date', [Request()->date, Request()->date])->where('rider_id', Request()->rider_id)->where('payment_type', 1)
            ->orderBy('date')
            ->groupBy('expense_type')
            ->selectRaw('sum(value) as sum , expense_type')
            ->pluck('sum', 'expense_type');

            $data['expenses_sim'] = Expense::whereBetween('date', [Request()->date, Request()->date])->where('rider_id', Request()->rider_id)->where('payment_type', 2)
            ->orderBy('date')
            ->groupBy('expense_type')
            ->selectRaw('sum(value) as sum , expense_type')
            ->pluck('sum', 'expense_type');

        $data['sum_expenses'] = Expense::whereBetween('date', [Request()->date, Request()->date])
            ->where('rider_id', Request()->rider_id)
            ->where('payment_type', 1)
            ->sum('value');

        // return $data ;
        if (request()->input('action') == "report") {
            $data['rider'] = Rider::where('id', Request()->rider_id)->first()->name;
            return view('admin.shipment.reports.daily_report', $data);
        } else {
            return view('admin.shipment.daily_shipments_rider', $data);
        }
    }


    public function assignToRider()
    {
        $data['riders'] = Rider::select('id', 'name')->get();
        $data['shipments'] = Shipment::whereIn('status_id', [2, 4, 5])->where('rider_id', Null)->get();
        return view('admin.shipment.assign_to_rider', $data);
    }

    public function assignShipments(Request $request)
    {
        $shipments = Shipment::whereIn('id', $request->shipments)->get();
        $shipments->each->update([
            'rider_id' => $request->rider_id,
        ]);
        return response()->json(['code' => 200]);
    }


    public function assignToRiderByScan()
    {
        $date_from = Carbon::now()->format('y-m-d');
        $date_to = Carbon::now()->format('y-m-d');
        $data['shipments'] = array();
        if (request()->rider_id) {
            $data['shipments'] = Shipment::where('rider_id', request()->rider_id)->whereBetween('delivered_date', [$date_from, $date_to])->with('Client')->get();
        }
        $data['riders'] = Rider::where('status', 1)->select('id', 'name')->get();
        $data['shipment_statuses'] = ShipmentStatuses::whereIn('id', [1, 2, 6, 7, 8, 9, 10])->select('id', 'name')->get();
        return view('admin.shipment.scan_to_rider', $data);
    }

    public function assignToRiderByScanQr(Request $request)
    {
        $rider_id = Null;
        if ($request->rider_id == 0) {
            $rider_id = Null;
        } else {
            $rider_id = $request->rider_id;
        }
        $shipment = Shipment::where('shipment_no', $request->shipment_no)->with('Client')->with('emirate')->with('city')->with('Company')->with('paymentMethod')->first();
        if ($shipment->status_id == 3 || $shipment->status_id == 6 || $shipment->status_id == 7 || $shipment->status_id == 8) {
            toastr()->warning('عذرا دورة حياة الشحنة منتهية');
            return redirect()->back();
        }
        if ($shipment && $shipment->rider_id != $rider_id) {

            $shipment->update([
                'rider_id' => $rider_id,
                'status_id' => 2,
                'delivered_date' => Carbon::now()->format('Y-m-d')
            ]);


            $fees_type = FeesType::where('id', $shipment->fees_type_id)->first()->name;
            $payment_method = PaymentMethods::where('id', $shipment->payment_method_id)->first()->name;


            $rider = $shipment->rider_id;
            $action = ' اسناد الشحنة بالقارئ من قبل المسؤول';
            Tracking::create([
                'shipment_id' => $shipment->id,
                'user_id' => Auth::guard('admin')->user()->id ?? Auth::id(),
                'status_id' => $shipment->status_id,
                'rider_id' => $rider,
                'guard' => 'admin',
                'notes' => Auth::guard('admin')->user()->name,
                'time' => Carbon::now()->format('y-m-d h:m'),
                'action' => $action,
                'shipment_amount' => $shipment->shipment_amount,
                'delivery_fees' => $shipment->delivery_fees,
                'delivery_extra_fees' => $shipment->delivery_extra_fees,
                'company_id' => $shipment->company_id,
                'notes' => $shipment->shipment_notes
            ]);
            toastr()->success('done');
            return redirect()->back();
        } else {
            toastr()->warning('something has not done');
            return redirect()->back();
        }
    }

    public function shipments_remove_rider(Request $request)
    {
        $shipment = Shipment::where('shipment_no', $request->shipment_no)->first();
        if ($shipment) {
            $shipment->update([
                'rider_id' => Null,
                'status_id' => 10,
                'delivered_date' => Carbon::now()->format('Y-m-d')
            ]);
            $guard = 'admin';
            $action = 'ازالة السائق من الشحنة';
            $rider = null;
            ShipmentHelper::shipmentTracking($shipment, $guard, $action, $rider);

            toastr()->success('removed');
            return redirect()->back();
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
        Excel::import(new EmployeeShipmetnImport, request()->file('file'));
        toastr()->success('File has been uploaded successfully!', 'Congrats');
        return redirect()->back();
    }

    public function downloadfile()
    {
        $filepath = public_path('build/assets/shipments.xlsx');
        return Response::download($filepath);
    }


public function trackingDelete($id){
    Tracking::where('id', $id)->forceDelete();
    toastr()->success('deleted successfully');
    return redirect()->back();
}

    // public function operation(){
    //     $rider= Rider::where('id',Request()->rider_id)->first()->name;
    //     return Excel::download(new operationReportExport, $rider.'_'. Carbon::today() .'xlsx');
    // }
}
