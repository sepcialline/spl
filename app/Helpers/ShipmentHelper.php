<?php

namespace App\Helpers;

use App\Events\TrackingEvent;
use App\Models\Admin;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Cities;
use App\Models\Branches;
use App\Models\Company;
use App\Models\Emirates;
use App\Models\FeesType;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\Tracking;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Models\PaymentMethods;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\Rider;
use App\Models\ShipmentContent;
use App\Models\ShipmentStatuses;
use App\Models\Warehouse;
use App\Models\WarehouseLog;
use App\Notifications\VendorCreateShipment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;


class ShipmentHelper
{

    public static function states($request)
    {

        $rider_should_recive = 0;
        $vendor_due = 0;
        $specialline_due = 0;

        // COD payment method
        if ($request['payment_method_id'] == 1) {
            if ($request['fees_type_id'] == 1) { // on client

                $rider_should_recive = $request['shipment_amount'] + $request['delivery_fees'] + $request['delivery_extra_fees'];
                $vendor_due = $request['shipment_amount'];
                $specialline_due = $request['delivery_fees'] + $request['delivery_extra_fees'];
            }
            if ($request['fees_type_id'] == 2) { // On Vendor

                $rider_should_recive = $request['shipment_amount'];
                $vendor_due = $request['shipment_amount'] - ($request['delivery_fees'] + $request['delivery_extra_fees']);
                $specialline_due = $request['delivery_fees'] + $request['delivery_extra_fees'];
            }
            if ($request['fees_type_id'] == 3) { // free
                $rider_should_recive = $request['shipment_amount'];
                $vendor_due = $request['shipment_amount'];
                $specialline_due = 0;
            }
        }

        // Specialline Transfer To Bank
        if ($request['payment_method_id'] == 2) {
            if ($request['fees_type_id'] == 1) { // on client
                $rider_should_recive = $request['delivery_fees'] + $request['delivery_extra_fees'];
                $vendor_due = $request['shipment_amount'];
                $specialline_due = $request['delivery_fees'] + $request['delivery_extra_fees'];
            }
            if ($request['fees_type_id'] == 2) { // On Vendor
                $rider_should_recive = 0;
                $vendor_due = $request['shipment_amount'] - ($request['delivery_fees'] + $request['delivery_extra_fees']);
                $specialline_due = $request['delivery_fees'] + $request['delivery_extra_fees'];
            }
            if ($request['fees_type_id'] == 3) { // free
                $rider_should_recive = 0;
                $vendor_due = $request['shipment_amount'];
                $specialline_due = 0;
            }
        }

        // Transfer To Vendor
        if ($request['payment_method_id'] == 3) {
            if ($request['fees_type_id'] == 1) { // on client
                $rider_should_recive = $request['delivery_fees'] + $request['delivery_extra_fees'];
                // $vendor_due = $request['shipment_amount'];
                $vendor_due = 0;
                // $specialline_due = $request['delivery_fees'] + $request['delivery_extra_fees'];
                $specialline_due = $request['delivery_fees'] + $request['delivery_extra_fees'];
            }
            if ($request['fees_type_id'] == 2) { // On Vendor
                $rider_should_recive = 0;
                // $vendor_due = $request['shipment_amount'] - ($request['delivery_fees'] + $request['delivery_extra_fees']);
                $vendor_due = 0;
                $specialline_due = $request['delivery_fees'] + $request['delivery_extra_fees'];
            }
            if ($request['fees_type_id'] == 3) { // free
                $rider_should_recive = 0;
                $vendor_due = 0;
                $specialline_due = 0;
            }
        }

        return [
            'rider_should_recive' => $rider_should_recive,
            'vendor_due' => $vendor_due,
            'specialline_due' => $specialline_due
        ];
    }

    public static function checkUser($request, $guard)
    {
        // $user = User::updateOrCreate(['mobile' => $request['client_phone'], 'name' => ['ar' => $request['client_name'], 'en' => $request['client_name']]], [
        $user = User::create([
            'name' => ['ar' => $request['client_name'], 'en' => $request['client_name']],
            'mobile' => $request['client_phone'],
            'email' => $request['client_email'],
            'photo' => 'avatar.png',
            'password' => Hash::make(123456),
            'emirate_id' => $request['client_emirate_id'],
            'city_id' => $request['client_city_id'],
            'address' => $request['client_address'],
            'created_by' => Auth::guard($guard)->user()->name
        ]);
        return $user;
    }

    public static function storeShipment($request, $user, $guard, $rider_should_recive, $vendor_due, $specialline_due, $ref)
    {
        $shipment_no = 10000001;
        $shipment_refrence = 10001;

        // $sh = Shipment::orderby('shipment_no','desc')->select('shipment_no')->first()->shipment_no;
        // $ref = Shipment::orderby('shipment_refrence','desc')->select('shipment_refrence')->first()->shipment_refrence;

        // if ($sh) {
        //     $shipment_no = $sh->shipment_no + 1;
        // } else {
        //     $shipment_no = $shipment_no;
        // }
        // if ($ref) {
        //     $shipment_refrence = $ref->shipment_refrence + 1;
        // } else {
        //     $shipment_refrence = $shipment_refrence;
        // }

        $shipment = new Shipment();

        if (isset($request->shopify_order_id)) {
            $shipment->shopify_order_id = $request->shopify_order_id;
        }
        $shipment_sh =  Shipment::orderby('shipment_no', 'desc')->select('shipment_no')->first();
        // $shipment->shipment_no =  $shipment_no;
        $shipment->shipment_no =  $shipment_sh ?  $shipment_sh->shipment_no + 1  : '10000001';
        $shipment->is_split_payment = 0;
        // $shipment->shipment_refrence = $ref . '' . $request['shipment_refrence'];
        $shipment->shipment_refrence =  $request['shipment_refrence'] ?? rand(100000, 999999);
        $shipment->delivered_date = $request['delivered_date'];
        $shipment->created_date = Carbon::today()->format('y-m-d');
        if ($guard == 'vendor') {
            $shipment->status_id = 1; // pending approval;
        } else {
            $shipment->status_id = 10; // new;
        }
        $shipment->company_id = $request['company_id'];
        $shipment->rider_id = Null;
        $shipment->user_id = $user->id;
        $shipment->shipment_amount = $request['shipment_amount'];
        $shipment->delivery_fees = $request['delivery_fees'];

        $shipment->delivery_extra_fees = $request['delivery_extra_fees'];

        $shipment->rider_should_recive = $rider_should_recive;
        $shipment->vendor_due = $vendor_due;
        $shipment->specialline_due = $specialline_due;

        $shipment->payment_method_id = $request['payment_method_id'];
        $shipment->fees_type_id = $request['fees_type_id'];
        $shipment->branch_created = $request['branch_created_id'];
        $shipment->branch_destination = $request['branch_destination_id'];
        $shipment->delivered_emirate_id = $user->emirate_id;
        $shipment->delivered_city_id = $user->city_id;
        $shipment->delivered_address = $user->address;

        $shipment->shipment_notes = $request['shipment_notes'];
        $shipment->created_by = Auth::guard($guard)->user()->name;

        $shipment->is_external_order = $request['is_external_order'] ? 1 : 0;
        $shipment->Including_vat = $request['Including_vat'] ? 1 : 0;



        $shipment->save();
        if ($shipment->save()) {
            if ($guard == 'vendor') {
                // make notification to admin
                // $admins = Admin::get();

                // $message = [
                //     'company' => Company::where('id',$request->company_id)->first()->name,
                //     'details' => __('admin.vendor_create_shipment')
                // ];

                // Notification::send($admins, new VendorCreateShipment($message));
            }
            return $shipment;
        }
    }

    public static function updateShipment($request, $user, $guard, $rider_should_recive, $vendor_due, $specialline_due)
    {
        $shipment = Shipment::where('id', $request->shipment_id)->first();

        // if ($request->is_external_order) {
        //     $is_external_order = 1;
        // } else {
        //     $is_external_order = 0;
        // }
        $shipment->update([
            'shipment_refrence' => $request->shipment_refrence,
            'delivered_date' => $request->delivered_date,
            'company_id' => $request->company_id,
            'user_id' => $user->id,
            'shipment_amount' => $request->shipment_amount,
            'delivery_fees' => $request->delivery_fees,
            'delivery_extra_fees' => $request->delivery_extra_fees,

            'rider_should_recive' => $rider_should_recive,
            'vendor_due' => $vendor_due,
            'specialline_due' => $specialline_due,

            'payment_method_id' => $request->payment_method_id,
            'fees_type_id' => $request->fees_type_id,
            'branch_created' => $request->branch_created_id,
            'branch_destination' => $request->branch_destination_id,

            'delivered_emirate_id' => $request->client_emirate_id,
            'delivered_city_id' => $request->client_city_id,
            'delivered_address' => $request->client_address,

            'shipment_notes' => $request->shipment_notes ?? $shipment->shipment_notes,
            'updated_by' => Auth::guard($guard)->user()->name,
            'is_external_order' =>  $request->is_external_order ? 1 : 0
        ]);

        if ($shipment->update()) {
            return $shipment;
        }
    }

    public static function shipmentContentFromStock($shipment, $request, $guard)
    {
        foreach ($request->product_ids as $key => $value) {
            $shipment_content = new ShipmentContent();
            $shipment_content->shipment_id = $shipment->id;
            $shipment_content->product_id = $value;
            $shipment_content->quantity = $request->qtys[$key];
            $shipment_content->created_by = Auth::guard($guard)->user()->name;
            $shipment_content->save();

            if ($shipment_content->save()) {
                $ProductDetails = ProductDetails::where('product_id', $value)->where('branch_id', $request->branch_created_id)->first();
                $ProductDetails->update([
                    'quantity' => $ProductDetails->quantity - $request->qtys[$key]
                ]);

                WarehouseLog::create([
                    'product_id' => $value,
                    'branch_id' => Auth::guard($guard)->user()->branch_id,
                    'company_id' => $request->company_id,
                    'quantity' => $request->qtys[$key],
                    'date' => Carbon::now()->format('Y-m-d'),
                    'operation_id' => 2,
                    'dispatch_ref_no' => $shipment->shipment_refrence,
                    'added_by' => Auth::guard($guard)->user()->id,
                    'notes' => 'اضافة منتجات للشحنة المذكورة في الرقم المرجعي للعملية',
                ]);
            }
        }
    }
    public static function shipmentContentText($shipment, $request, $guard)
    {
        $shipment_content = new ShipmentContent();
        $shipment_content->shipment_id = $shipment->id;
        $shipment_content->content_text = $request->content_text;
        $shipment_content->created_by = Auth::guard($guard)->user()->name;
        $shipment_content->save();
    }

    public static function shipmentTracking($shipment, $guard, $action, $rider)
    {
        $now = Carbon::now();
        $tz = 'Asia/Dubai';
        $start = Carbon::createFromTimeString('00:01', $tz);
        $end = Carbon::createFromTimeString('04:00', $tz);

        $time = $now;

        if ($now->between($start, $end)) {
            $time  = Carbon::today($tz)->subday(1)->format('Y-m-d 11:59:59');
        } else {
            $time = $time;
        }

        if ($shipment->status_id == 4) {
            $date_time =  $time;
        } else {
            $date_time = $shipment->delivered_date;
        }

        $fees_type = FeesType::where('id', $shipment->fees_type_id)->first()->name;
        $payment_method = PaymentMethods::where('id', $shipment->payment_method_id)->first()->name;

        $Tracking = Tracking::create([
            'shipment_id' => $shipment->id,
            'user_id' => Auth::guard($guard)->user()->id ?? Auth::id(),
            'status_id' => $shipment->status_id,
            'rider_id' =>  $rider,
            'guard' => $guard,
            // 'time' => $shipment->delivered_date ?? Carbon::now()->format('y-m-d h:m'),
            'time' => ($guard == 'rider') ? $time : $date_time,
            'action' => $action . ' | ' . $fees_type . ' ' . $payment_method,
            'shipment_amount' => $shipment->shipment_amount,
            'delivery_fees' => $shipment->delivery_fees,
            'delivery_extra_fees' => $shipment->delivery_extra_fees,
            'company_id' => $shipment->company_id,
            'notes' => $shipment->shipment_notes
        ]);

        event(new TrackingEvent($Tracking));
    }


    public static function searchShipment($request, $query)
    {

        // if ($request->company_id && !in_array(0, $request->company_id)) {
        if ($request->company_id && $request->company_id != 0) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->rider_id && $request->rider_id != 0) {
            $query->where('rider_id', $request->rider_id);
        }

        if ($request->payment_method_id && $request->payment_method_id != 0) {
            $query->where('payment_method_id', $request->payment_method_id);
        }

        if ($request->status_id && $request->status_id != 0) {
            $query->where('status_id', $request->status_id);
        }

        if ($request->emirate_id && $request->emirate_id != 0) {
            $query->where('delivered_emirate_id', $request->emirate_id);
        }

        if ($request->city_id && $request->city_id != 0) {
            $query->where('delivered_city_id', $request->city_id);
        }

        if ($request->branch_created && $request->branch_created != 0) {
            $query->where('branch_created', $request->branch_created);
        }

        if ($request->branch_destination && $request->branch_destination != 0) {
            $query->where('branch_destination', $request->branch_destination);
        }
        if (isset($request->search) && !empty($request->search)) {
            $query->where('shipment_no', 'like', '%' . $request->search  . '%');
            $query->orWhere('shipment_refrence', 'like', '%' . $request->search  . '%');
            $query->orWhereHas('Client', function ($q) use ($request) {
                return $q->where('mobile', 'like', '%' . $request->search  . '%');
            });
            $query->orWhereHas('Client', function ($q) use ($request) {
                return $q->where('name', 'like', '%' . $request->search  . '%');
            });
        }

        // $query->orderBy('delivered_emirate_id')->orderBy('delivered_city_id')->orderBy('delivered_address');
        $query->orderBy('company_id')->orderBy('id');

        return $query;
    }

    public static function ShipmentViewPrintInvoicePdf($id)
    {
        $data['shipment_company'] = null;
        $data['has_stock'] = null;
        $data['change_statuss'] = [];
        $data['riders'] = Rider::select('id', 'name')->get();
        $data['shipment'] = Shipment::where('id', $id)->first();
        $data['user'] = User::where('id', $data['shipment']->user_id)->first();
        $data['emirates'] = Emirates::select('id', 'name')->get();
        $data['cities'] = Cities::select('id', 'name')->get();
        $data['companies'] = VendorCompany::select('id', 'name')->get();
        $data['payment_methods'] = PaymentMethods::select('id', 'name')->get();
        $data['fees_types'] = FeesType::select('id', 'name')->get();
        $data['branches'] = Branches::where('is_main', 0)->where('status', 1)->select('id', 'branch_name')->get();
        $data['statuss'] = ShipmentStatuses::select('id', 'name')->get();

        if ($data['shipment']->status_id == 1) { // pending approval
            $data['change_statuss'] = ShipmentStatuses::whereIn('id', [10, 6])->get(); // new + canceled
        }

        if ($data['shipment']->status_id == 2) { // In Progress
            if (Auth::guard('admin')->check() && ((Auth::guard('admin')->user()->hasRole('Accountant')) || (Auth::guard('admin')->user()->hasRole('Super Admin')))) {
                $data['change_statuss'] = ShipmentStatuses::whereIn('id', [3, 4, 5, 6, 7, 8, 9])->select('id', 'name')->get();
            } elseif (Auth::guard('employee')->check() || Auth::guard('vendor')->check()) {
                $data['change_statuss'] = ShipmentStatuses::whereIn('id', [4, 5, 6, 7, 8, 9])->select('id', 'name')->get();
            }
            // delivered + delayed +  transfered + canceled + damaged + duplicated  + return to store
        }

        if ($data['shipment']->status_id == 3) { // delivered
            if (Auth::guard('admin')->check() && ((Auth::guard('admin')->user()->hasRole('Accountant')) || (Auth::guard('admin')->user()->hasRole('Super Admin')))) {
                $data['change_statuss'] = ShipmentStatuses::whereIn('id', [2])->get(); // In Progress
            }
        }

        if ($data['shipment']->status_id == 4) { // Delayed
            $data['change_statuss'] = ShipmentStatuses::whereIn('id', [2, 6])->get(); //  In Progress + canceled
        }

        if ($data['shipment']->status_id == 5) { // Transferred
            $data['change_statuss'] = ShipmentStatuses::whereIn('id', [2, 6])->get(); //  In Progress + canceled
        }
        if ($data['shipment']->status_id == 6) { // canceled
            $data['change_statuss'] = ShipmentStatuses::whereIn('id', [2])->get(); //  In Progress
        }

        if ($data['shipment']->status_id == 9) { // retured to store
            $data['change_statuss'] = ShipmentStatuses::whereIn('id', [2, 6])->get(); //  In Progress + canceled
        }

        if ($data['shipment']->status_id == 10) { // New
            $data['change_statuss'] = ShipmentStatuses::whereIn('id', [2, 6])->get(); //  In Progress + canceled
        }

        $data['shipment_company'] = VendorCompany::where('id', $data['shipment']->company_id)->first();

        if ($data['shipment_company']->has_stock == 1) {
            $data['has_stock'] = 1;
            $contents = ShipmentContent::where('shipment_id', $data['shipment']->id)->get();
            if (count($contents) > 0) {
                $data['shipment_content'] = ShipmentContent::where('shipment_id', $data['shipment']->id)->get();
            } else {
                $data['shipment_content'] = [];
            }
        } else {
            $data['has_stock'] = 0;
            $data['shipment_content'] = ShipmentContent::where('shipment_id', $data['shipment']->id)->first();
        }
        return $data;
    }

    public static function generateBarCode($shipment_no)
    {
        $generator = new \Picqer\Barcode\BarcodeGeneratorHTML();
        $barcode = $generator->getBarcode($shipment_no, $generator::TYPE_CODE_128_A);
        return $barcode;
    }

    public static function shipmentChangeStatus($request, $shipment, $guard)
    {
        // dd($request->all());
        $img = Null;
        $rider = null;
        if ($guard == "rider") {
            $rider = Auth::id();
        } else {
            $rider = $shipment->rider_id;
        }

        // dd($request);
        if ($request->hasFile('file')) {
            $img = $request->file != null ? time() . '_' . $request->file->getClientOriginalName() : $request->file;
            $request->file->move(public_path('build/assets/img/uploads/documents'), $img);
        }
        $current_status = $shipment->status_id;
        if ($request->status_id != $current_status) {

            if ($request->status_id == 10) { // change to new
                if ($current_status == 1) { // pending to approval
                    $shipment->update([
                        'branch_created' => $request->branch_created_id,
                        'branch_destination' => $request->branch_destination_id,
                    ]);
                }
            }

            if ($request->status_id == 2) { // change to in Progress
                if ($current_status == 3) { // Current is delivered
                    $payments = Payment::where('shipment_id', $shipment->id)->get(); // delete payments
                    $payments->each->delete();

                    $shipment->update([
                        'is_rider_has' => 0,
                        // 'delivered_date' => Carbon::now()->format('Y-m-d'),
                        'is_vendor_has' => 0,
                        'is_bank_has' => 0,
                        'is_spl_get_due' => 0,
                        'is_vendor_get_due' => 0,
                        'rider_id' => ($request->rider_id != 0) ? $request->rider_id : Null,
                    ]);
                }

                if ($current_status == 4) { // Current is Delayed
                    $shipment->update([
                        'rider_id' => $request->rider_id ?? Auth::user()->id,
                        'delivered_date' => $request->delivered_date ?? Carbon::today()
                    ]);
                }
                if ($current_status == 5) { // Current is transfered
                    $shipment->update([
                        'rider_id' => $request->rider_id ?? Auth::user()->id,
                        'delivered_date' => $request->delivered_date ?? Carbon::today()
                    ]);
                }

                if ($current_status == 10) { // current is new
                    $shipment->update([
                        'rider_id' => $request->rider_id,
                        'delivered_date' => $request->delivered_date ?? Carbon::today()
                    ]);
                }

                if ($current_status == 9) { // current is returned
                    $payments = Payment::where('shipment_id', $shipment->id)->get(); // delete payments
                    $payments->each->delete();

                    $shipment->update([
                        'is_rider_has' => 0,
                        'is_vendor_has' => 0,
                        'is_bank_has' => 0,
                        'is_spl_get_due' => 0,
                        'is_vendor_get_due' => 0,
                        'rider_id' => ($request->rider_id != 0) ? $request->rider_id : Null,
                    ]);
                }
            } // end status 2 change to in progress


            if ($request->status_id == 3) { // change to delivered
                if ($current_status == 2) { // current is In progress
                    $payment_number = rand(1000, 1000000);


                    // 1 COD one payment
                    if ($request->payment_method == 1) {
                        if ($shipment->fees_type_id == 3) {
                            // on free
                            $due_amount = $request->delivered_amount - 0;
                            ShipmentHelper::payShipment($payment_number, $is_split = 0, $shipment, $payment_method = 1, $request,  $image = $img, $is_rider_has = 1, $is_vendor_has = 0, $is_bank_has = 0, $guard, $amount = $request->delivered_amount, $delivery_fees = $shipment->specialline_due, $due_amount, $is_vendor_get_due = 0, $is_spl_get_due = 0);

                            $shipment->update([
                                'is_split_payment' => 0,
                                'branch_delivered' => $request->branch_id ?? Auth::user()->branch_id,
                                'delivered_date' => $request->delivered_date_delivered ?? $shipment->delivered_date,
                                // 'delivered_date' => $request->delivered_date_delivered ?? Carbon::today(),
                                'is_rider_has' => 1,
                                'is_vendor_has' => 0,
                                'is_bank_has' => 0,
                                'is_vendor_get_due' => 0,
                                'is_spl_get_due' => 0,
                            ]);
                        } else {
                            // on customer or on vendor
                            $due_amount = $request->delivered_amount - $shipment->specialline_due;
                            ShipmentHelper::payShipment($payment_number, $is_split = 0, $shipment, $payment_method = 1, $request,  $image = $img, $is_rider_has = 1, $is_vendor_has = 0, $is_bank_has = 0, $guard, $amount = $request->delivered_amount, $delivery_fees = $shipment->specialline_due, $due_amount, $is_vendor_get_due = 0, $is_spl_get_due = 0);

                            $shipment->update([
                                'is_split_payment' => 0,
                                'branch_delivered' => $request->branch_id ?? Auth::user()->branch_id,
                                'delivered_date' => $request->delivered_date_delivered ?? $shipment->delivered_date,
                                // 'delivered_date' => $request->delivered_date_delivered ?? Carbon::today(),
                                'is_rider_has' => 1,
                                'is_vendor_has' => 0,
                                'is_bank_has' => 0,
                                'is_vendor_get_due' => 0,
                                'is_spl_get_due' => 0,
                            ]);
                        }
                    }


                    // 2 TO BANK one payment
                    if ($request->payment_method == 2) {
                        if ($shipment->fees_type_id == 3) {
                            // on free
                            $due_amount = $request->transferred_amount - 0;
                            ShipmentHelper::payShipment($payment_number, $is_split = 0, $shipment, $payment_method = 2, $request,  $image = $img, $is_rider_has = 0, $is_vendor_has = 0, $is_bank_has = 1, $guard, $amount = $request->transferred_amount, $delivery_fees = $shipment->specialline_due, $due_amount, $is_vendor_get_due = 0, $is_spl_get_due = 0);

                            $shipment->update([
                                'is_split_payment' => 0,
                                'branch_delivered' => $request->branch_id ?? Auth::user()->branch_id,
                                'delivered_date' => $request->delivered_date_delivered ?? $shipment->delivered_date,
                                // 'delivered_date' => $request->delivered_date_delivered ?? Carbon::today(),
                                'is_rider_has' => 0,
                                'is_vendor_has' => 0,
                                'is_bank_has' => 1,
                                'is_vendor_get_due' => 0,
                                'is_spl_get_due' => 0,
                            ]);
                        } else {
                            // on customer or on vendor
                            $due_amount = $request->transferred_amount - $shipment->specialline_due;
                            ShipmentHelper::payShipment($payment_number, $is_split = 0, $shipment, $payment_method = 2, $request,  $image = $img, $is_rider_has = 0, $is_vendor_has = 0, $is_bank_has = 1, $guard, $amount = $request->transferred_amount, $delivery_fees = $shipment->specialline_due, $due_amount, $is_vendor_get_due = 0, $is_spl_get_due = 0);
                            $shipment->update([
                                'is_split_payment' => 0,
                                'branch_delivered' => $request->branch_id ?? Auth::user()->branch_id,
                                'delivered_date' => $request->delivered_date_delivered ?? $shipment->delivered_date,
                                // 'delivered_date' => $request->delivered_date_delivered ?? Carbon::today(),
                                'is_rider_has' => 0,
                                'is_vendor_has' => 0,
                                'is_bank_has' => 1,
                                'is_vendor_get_due' => 0,
                                'is_spl_get_due' => 0,
                            ]);
                        }
                    }
                    // 3 TO VENDOR one payment
                    if ($request->payment_method == 3) {
                        if ($shipment->fees_type_id == 3) {
                            // on free
                            $due_amount = 0;
                            ShipmentHelper::payShipment($payment_number, $is_split = 0, $shipment, $payment_method = 3, $request,  $image = $img, $is_rider_has = 0, $is_vendor_has = 0, $is_bank_has = 0, $guard, $amount = $request->transferred_amount, $delivery_fees = $shipment->specialline_due, $due_amount, $is_vendor_get_due = 0, $is_spl_get_due = 0);

                            $shipment->update([
                                'is_split_payment' => 0,
                                'branch_delivered' => $request->branch_id ?? Auth::user()->branch_id,
                                'delivered_date' => $request->delivered_date_delivered ?? $shipment->delivered_date,
                                // 'delivered_date' => $request->delivered_date_delivered ?? Carbon::today(),
                                'is_rider_has' => 0,
                                'is_vendor_has' => 0,
                                'is_bank_has' => 0,
                                'is_vendor_get_due' => 0,
                                'is_spl_get_due' => 0,
                            ]);
                        } else {
                            $due_amount = null;
                            // on customer or on vendor
                            if ($shipment->fees_type_id == 1) {
                                $due_amount = 0;
                            }
                            if ($shipment->fees_type_id == 2) {
                                $due_amount = 0 - $shipment->specialline_due;
                            }
                            ShipmentHelper::payShipment($payment_number, $is_split = 0, $shipment, $payment_method = 3, $request,  $image = $img, $is_rider_has = 0, $is_vendor_has = 1, $is_bank_has = 0, $guard, $amount = $request->transferred_amount, $delivery_fees = $shipment->specialline_due, $due_amount, $is_vendor_get_due = 0, $is_spl_get_due = 0);

                            $shipment->update([
                                'is_split_payment' => 0,
                                'branch_delivered' => $request->branch_id ?? Auth::user()->branch_id,
                                'delivered_date' => $request->delivered_date_delivered ?? $shipment->delivered_date,
                                // 'delivered_date' => $request->delivered_date_delivered ?? Carbon::today(),
                                'is_rider_has' => 0,
                                'is_vendor_has' => 1,
                                'is_bank_has' => 0,
                                'is_vendor_get_due' => 0,
                                'is_spl_get_due' => 0,
                            ]);
                        }
                    }

                    // 0 split => tow payments(1 cod , 2 to company)
                    if ($request->payment_method == 0) {
                        if ($shipment->fees_type_id == 3) {
                            // on free
                            // code
                            $due_amount1 = $request->delivered_amount;
                            ShipmentHelper::payShipment($payment_number, $is_split = 1, $shipment, $payment_method = 1, $request,  $image = $img, $is_rider_has = 1, $is_vendor_has = 0, $is_bank_has = 0, $guard, $amount = $request->delivered_amount, $delivery_fees = 0, $due_amount1, $is_vendor_get_due = 0, $is_spl_get_due = 0);
                            // tr to bank
                            $due_amount2 = $request->transferred_amount;
                            ShipmentHelper::payShipment($payment_number, $is_split = 1, $shipment, $payment_method = 2, $request,  $image = $img, $is_rider_has = 0, $is_vendor_has = 0, $is_bank_has = 1, $guard, $amount = $request->transferred_amount, $delivery_fees = 0, $due_amount2, $is_vendor_get_due = 0, $is_spl_get_due = 0);

                            $shipment->update([
                                'is_split_payment' => 1,
                                'branch_delivered' => $request->branch_id ?? Auth::user()->branch_id,
                                'delivered_date' => $request->delivered_date_delivered ?? $shipment->delivered_date,
                                // 'delivered_date' => $request->delivered_date_delivered ?? Carbon::today(),
                                'is_rider_has' => 1,
                                'is_vendor_has' => 0,
                                'is_bank_has' => 1,
                                'is_vendor_get_due' => 0,
                                'is_spl_get_due' => 0,
                            ]);
                        } else {
                            // on customer or on vendor
                            // code
                            $due_amount1 = $request->delivered_amount - $shipment->specialline_due;
                            ShipmentHelper::payShipment($payment_number, $is_split = 1, $shipment, $payment_method = 1, $request,  $image = $img, $is_rider_has = 1, $is_vendor_has = 0, $is_bank_has = 0, $guard, $amount = $request->delivered_amount,  $delivery_fees = $shipment->specialline_due, $due_amount1, $is_vendor_get_due = 0, $is_spl_get_due = 0);
                            // tr to bank
                            $due_amount2 = $request->transferred_amount - 0;
                            ShipmentHelper::payShipment($payment_number, $is_split = 1, $shipment, $payment_method = 2, $request,  $image = $img, $is_rider_has = 0, $is_vendor_has = 0, $is_bank_has = 1, $guard, $amount = $request->transferred_amount, $delivery_fees = 0, $due_amount2, $is_vendor_get_due = 0, $is_spl_get_due = 0);

                            $shipment->update([
                                'is_split_payment' => 1,
                                'branch_delivered' => $request->branch_id ?? Auth::user()->branch_id,
                                'delivered_date' => $request->delivered_date_delivered ?? $shipment->delivered_date,
                                // 'delivered_date' => $request->delivered_date_delivered ?? Carbon::today(),
                                'is_rider_has' => 1,
                                'is_vendor_has' => 0,
                                'is_bank_has' => 1,
                                'is_vendor_get_due' => 0,
                                'is_spl_get_due' => 0,
                            ]);
                        }
                    }
                }
            }

            if ($request->status_id == 9) { // change to returned
                if ($current_status == 2) { // current is In progress
                    $payment_number = rand(1000, 1000000);
                    $due_amount = 0;
                    if ($request->payment_type == 1) { // customer pay fees
                        $shipment1 = ShipmentHelper::payShipment($payment_number, $is_split = 0, $shipment, $payment_method = 1, $request,  $image = $img, $is_rider_has = 1, $is_vendor_has = 0, $is_bank_has = 0, $guard, $amount = $request->fees_amount ?? $request->delivered_amount, $delivery_fees = $shipment->specialline_due, $due_amount, $is_vendor_get_due = 0, $is_spl_get_due = 0);
                        $shipment->update([
                            'is_split_payment' => 0,
                            'branch_delivered' => $request->fess_branch_id ?? Auth::user()->branch_id,
                            'delivered_date' => $request->delivered_date_delivered ?? $shipment->delivered_date,
                            // 'delivered_date' => $request->delivered_date_delivered ?? Carbon::today(),
                            'is_rider_has' => 1,
                            'is_vendor_has' => 0,
                            'is_bank_has' => 0,
                            'is_vendor_get_due' => 0,
                            'is_spl_get_due' => 0,
                        ]);
                    } else { // vendor should pay fees
                        $due_amount = 0 - $shipment->specialline_due;
                        $shipment1 = ShipmentHelper::payShipment($payment_number, $is_split = 0, $shipment, $payment_method = 3, $request,  $image = $img, $is_rider_has = 0, $is_vendor_has = 1, $is_bank_has = 0, $guard, $amount = $request->fees_amount ?? $request->delivered_amount, $delivery_fees = $shipment->specialline_due, $due_amount, $is_vendor_get_due = 0, $is_spl_get_due = 0);
                        $shipment->update([
                            'is_split_payment' => 0,
                            'branch_delivered' => $request->fess_branch_id ?? Auth::user()->branch_id,
                            'delivered_date' => $request->delivered_date_delivered ?? $shipment->delivered_date,
                            // 'delivered_date' => $request->delivered_date_delivered ?? Carbon::today(),
                            'is_rider_has' => 0,
                            'is_vendor_has' => 1,
                            'is_bank_has' => 0,
                            'is_vendor_get_due' => 0,
                            'is_spl_get_due' => 0,
                        ]);
                    }
                }
            }

            if ($request->status_id == 4) { // change to Delayed
                if ($current_status == 2) {
                    $shipment->update([
                        // 'rider_id' => ($request->rider_id != 0) ? $request->rider_id : Null,
                        'rider_id' => Null,
                        'delivered_date' => ($request->delivered_date) ? $request->delivered_date : Carbon::tomorrow()->format('Y-m-d')
                    ]);
                }
            }

            if ($request->status_id == 5) { // change to transferred
                if ($current_status == 2) {
                    $shipment->update([
                        'rider_id' => ($request->rider_id != 0) ? $request->rider_id : Null,
                        'delivered_emirate_id' => $request->client_emirate_id,
                        'delivered_city_id' => $request->client_city_id,
                        'delivered_address' => $request->client_address
                    ]);
                }
            }


            if ($request->status_id == 6) { // change to cancel
                if ($current_status == 2 || $current_status == 1 || $current_status == 10) {
                    if ($shipment->shipmentContents) {
                        // dd($shipment->shipmentContents);
                        foreach ($shipment->shipmentContents as $contnet) {
                            if (!empty($contnet->product_id)) {
                                $product = ProductDetails::where('product_id', $contnet->product_id)->where('branch_id', $shipment->branch_created)->first();
                                $product->update([
                                    'quantity' => $product->quantity + $contnet->quantity
                                ]);
                                $contnet->delete();

                                WarehouseLog::create([
                                    'product_id' => $contnet->product_id,
                                    'branch_id' => Auth::guard($guard)->user()->branch_id,
                                    'company_id' => $shipment->company_id,
                                    'quantity' => $contnet->quantity,
                                    'date' => Carbon::now()->format('Y-m-d'),
                                    'operation_id' => 1,
                                    'dispatch_ref_no' => $shipment->shipment_refrence,
                                    'added_by' => Auth::guard($guard)->user()->id,
                                    'notes' => 'استرجاع المنتجات بعد الغاء الشحنة ذات الرقم المرجعي المذكور في هذه العملية',
                                ]);
                            }
                        }
                    }
                    if ($shipment->rider_id != Null) {
                        $shipment->update([
                            // 'rider_id' => ($request->rider_id != 0) ? $request->rider_id : Null,
                            'rider_id' =>  Null,
                        ]);
                    }
                }
            }

            $shipment->update([
                'status_id' => $request->status_id,
                'updated_by' => Auth::guard($guard)->user()->name ?? Auth::user()->name,
                'shipment_notes' => $request->notes ?? $shipment->shipment_notes
            ]);

            $status = ShipmentStatuses::where('id', $request->status_id)->first();
            $action = trans('admin.change_status_to') . ' ' . $status->name;
            ShipmentHelper::shipmentTracking($shipment, $guard, $action, $rider);
        } else {
            return 'erro';
        }
    }


    public static function payShipment($payment_number, $is_split, $shipment, $payment_method, $request, $image, $is_rider_has, $is_vendor_has, $is_bank_has, $guard, $amount, $delivery_fees, $due_amount, $is_vendor_get_due, $is_spl_get_due)
    {

        $payment = Payment::create([
            'is_split' => $is_split,
            'payment_number' => $payment_number,
            'image' => $image,
            'shipment_id' => $shipment->id,
            'date' => $request->delivered_date_delivered ?? $shipment->delivered_date,
            'payment_method_id' =>  $payment_method,
            'company_id' => $shipment->company_id,
            'rider_id' => $shipment->rider_id,
            'amount' => $amount,
            'delivery_fees' => $delivery_fees,
            'due_amount' => $due_amount,
            'is_rider_has' => $is_rider_has,
            'is_vendor_has' =>  $is_vendor_has,
            'is_bank_has' => $is_bank_has,
            'is_vendor_get_due' => $is_vendor_get_due,
            'is_spl_get_due' => $is_spl_get_due,
            'branch_created' => $request->branch_id ?? Auth::user()->branch_id,
            'in_out' => $shipment->branch_created == $shipment->branch_delivered ? '0' : '1',
            'created_by' => Auth::guard($guard)->user()->name ?? Auth::user()->name,
        ]);
    }


    public static function searchPayments($request, $query)
    {
        if ($request->company_id && $request->company_id != 0) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->rider_id && $request->rider_id != 0) {
            $query->where('rider_id', $request->rider_id);
        }

        if ($request->payment_method_id && $request->payment_method_id != 0) {
            $query->where('payment_method_id', $request->payment_method_id);
        }

        if ($request->status_id && $request->status_id != 0) {
            $query->where('status_id', $request->status_id);
        }


        if ($request->branch_created && $request->branch_created != 0) {
            $query->where('branch_created', $request->branch_created);
        }



        return $query;
    }
    public static function accounting_entries()
    {
    }
}
