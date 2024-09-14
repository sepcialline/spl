<?php

namespace App\Http\Controllers\API\VendorApi;

use Carbon\Carbon;
use App\Models\Emirates;
use App\Models\Shipment;
use App\Models\Tracking;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Helpers\ShipmentHelper;
use App\Models\ShipmentContent;
use App\Models\ShipmentStatuses;
use App\Http\Controllers\Controller;
use App\Http\Resources\GetEmiratesResource;
use App\Http\Resources\GetShipemtsResource;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Resources\GetShipmentStatusResource;
use App\Http\Resources\GetShipmentDetailsResource;

class ShipmentController extends Controller
{
    public function shipment_summary($company_id)
    {

        $date = Carbon::now()->format('Y-m-d');

        if (Request()->date) {
            $date = Carbon::parse(Request()->date)->format('Y-m-d');
        }

        $query_for_all_without_delay = Shipment::query()->where('company_id', $company_id)
            ->where('delivered_date', $date)->where('deleted_at', Null);

        $query_that_delay_to_next_day = Shipment::Where('delivered_date', Carbon::parse($date)->addDays(1))->where('status_id', 4)->where('company_id', $company_id)->where('deleted_at', Null);

        $all_shipments_without_delay = clone $query_for_all_without_delay;
        $all_shipments_that_delay_to_next_day = clone $query_that_delay_to_next_day;
        $delivered_shipments = clone $all_shipments_without_delay;
        $canceled_shipment = clone $all_shipments_without_delay;


        $all =  $all_shipments_without_delay->count() + $all_shipments_that_delay_to_next_day->count();

        $delivered =  $delivered_shipments->where('status_id', 3)->count();

        $canceled =  $canceled_shipment->where('status_id', 6)->count();

        $delayed = Tracking::where('company_id', $company_id)->whereBetween('time', [Carbon::parse($date)->format('Y-m-d 00:00:01'), Carbon::parse($date)->format('Y-m-d 23:59:59')])->where('status_id', 4)->groupBy('shipment_id')->count();

        if ($all > 0) {
            return response()->json([
                'code' => 200,
                'message' => 'Successfully get shipments summary information',
                'all' => $all ?? 0,
                'delivered_percentage' =>  number_format((float) ($delivered * 100) / $all, 2),
                'delivered_count' => $delivered,
                'canceled_percentage' =>   number_format((float) ($canceled * 100) / $all, 2),
                'canceled_count' => $canceled,
                'delayed_percentage' =>   number_format((float) ($delayed * 100) / $all, 2),
                'delayed_count' => $delayed
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'there is no shipments in this date ' . $date,
                'all' => number_format((float) 0, 2),
                'delivered' => number_format((float) 0, 2),
                'delivered_count' => $delivered,
                'canceled' => number_format((float) 0, 2),
                'canceled_count' => $canceled,
                'delayed' => number_format((float) 0, 2),
                'delayed_count' => $delayed
            ], 404);
        }
    }

    public function shipment_status_list()
    {
        $status_list = ShipmentStatuses::where('status', 1)->get();

        $data = GetShipmentStatusResource::collection($status_list);

        if ($data) {
            return response()->json([
                'code' => 200,
                'message' => 'Successfully get shipment status list',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'No shipment status found.',
            ], 404);
        }
    }
    public function emirate_list()
    {
        $emirates_list = Emirates::get();

        $data = GetEmiratesResource::collection($emirates_list);

        if ($data) {
            return response()->json([
                'code' => 200,
                'message' => 'Successfully get Emirates list',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'No Emirates found.',
            ], 404);
        }
    }


    public function shipments(Request $request)
    {
        try {

            // التحقق من القيم
            $validated = $request->validate([
                'company_id' => 'required|numeric',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // تخصيص الاستجابة عند فشل التحقق
            return response()->json([
                'code' => 400,
                'message' => 'Validation failed',
                'errors' => $e->errors()  // إضافة تفاصيل الأخطاء
            ], 400);
        }

        $company_id = $request->input('company_id');
        $page_size = $request->input('page_size', 5);
        $page = $request->input('page', 1);

        $date = Carbon::now()->format('Y-m-d');

        if ($request->has('date')) {
            $date = Carbon::parse($request->input('date'))->format('Y-m-d');
        }

        // استعلام shipments العادية
        $query = Shipment::query()->where('delivered_date', $date)->where('company_id', $company_id);

        // استعلام tracking->shipment لدمج الشحنات ذات العلاقة
        $query_delayes = Tracking::whereBetween('time', [Carbon::parse($date)->format('Y-m-d 00:00:01'), Carbon::parse($date)->format('Y-m-d 23:59:59')])
            ->where('status_id', 4)
            ->where('company_id', $company_id)
            ->with('shipment');

        // إضافة الفلترة بناءً على status_id
        if ($request->has('status_id') && $request->input('status_id') != 0) {
            $query->where('status_id', $request->input('status_id'));
        }

        // إضافة الفلترة بناءً على emirate_id
        if ($request->has('emirate_id') && $request->input('emirate_id') != 0) {
            $query->where('delivered_emirate_id', $request->input('emirate_id'));
            $query_delayes->whereHas('shipment', function ($q) use ($request) {
                $q->where('delivered_emirate_id', $request->input('emirate_id'));
            });
        }

        // جلب الشحنات من كلا الاستعلامين
        $shipments = $query->get();
        $trackingShipments = $query_delayes->get()->pluck('shipment');

        // دمج الشحنات العادية مع الشحنات المرتبطة بالتتبع
        $combinedShipments = $shipments->merge($trackingShipments);

        // حساب إجمالي عدد العناصر بعد الدمج
        $total = $combinedShipments->count();

        // تطبيق التصفح باستخدام LengthAwarePaginator
        $paginatedResults = new LengthAwarePaginator(
            $combinedShipments->forPage($page, $page_size),
            $total,
            $page_size,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $data = GetShipemtsResource::collection($paginatedResults);

        if ($data->count() > 0) {
            return response()->json([
                'code' => 200,
                'message' => 'Successfully get shipments list',
                'data' => $data->response()->getData(true)
            ], 200);
        }

        return response()->json([
            'code' => 404,
            'message' => 'No shipments found',
            'data' => []
        ], 404);
    }

    public function search(Request $request)
    {
        try {

            // التحقق من القيم
            $validated = $request->validate([
                'company_id' => 'required|numeric',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // تخصيص الاستجابة عند فشل التحقق
            return response()->json([
                'code' => 400,
                'message' => 'Validation failed',
                'errors' => $e->errors()  // إضافة تفاصيل الأخطاء
            ], 400);
        }

        $query = Shipment::query();

        $query_shipments = ShipmentHelper::searchShipment($request, $query);

        // if (isset($request->search) && !empty($request->search)) {
        //     $query->where('shipment_no', 'like', '%' . $request->search  . '%');
        //     $query->orWhere('shipment_refrence', 'like', '%' . $request->search  . '%');
        //     $query->orWhereHas('Client', function ($q) use ($request) {
        //         return $q->where('mobile', 'like', '%' . $request->search  . '%');
        //     });
        //     // $query->orWhereHas('Client', function ($q) use ($request) {
        //     //     return $q->where('name', 'like', '%' . $request->search  . '%');
        //     // });
        // }

        $shipments = $query_shipments->get();
        if ($shipments->count() > 0) {
            $data =  GetShipemtsResource::collection($query_shipments->paginate(5));
            return response()->json([
                'code' => 200,
                'message' => 'Successfully search shipments',
                'data' => $data->response()->getData(true)
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'No shipments found',
                'data' => []
            ], 404);
        }
    }

    public function get_shipment_details($id)
    {
        $data['shipment'] = Shipment::find($id);
        $shipment_company = VendorCompany::where('id', $data['shipment']->company_id)->first();

        if ($shipment_company->has_stock == 1) {  //  اذا كان التاجر لديه ستوك
            $data['shipment_content'] = ShipmentContent::where('shipment_id', $data['shipment']->id)
                ->with('product', function ($q) {
                    return $q->select('id', 'name')->get();
                })->select('id', 'product_id', 'quantity')->get();
            if (count($data['shipment_content']) > 0) {
                $data['has_stock'] = 1;
            } else { // اذا كان التاجر لديه ستوك لكن الشحنة مافيها منتجات من الستوك
                $data['has_stock'] = 0;
                $data['shipment_content'] = Null;
            }
        } else {
            $data['has_stock'] = 0;
            $data['shipment_content'] = ShipmentContent::where('shipment_id', $data['shipment']->id)->first()->content_text ?? Null;
        }
        if ($data['shipment']) {
            $data = new GetShipmentDetailsResource($data);
            return response()->json([
                'code' => 200,
                'message' => 'Successfully get shipment details',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'No shipment found.',
            ], 404);
        }
    }
}
