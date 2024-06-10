<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EmiratePostExport;
use App\Exports\PaymentExport;
use Carbon\Carbon;
use App\Models\Rider;
use App\Models\Cities;
use App\Models\Payment;
use App\Models\Branches;
use App\Models\Emirates;
use App\Models\Settings;
use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Models\PaymentMethods;
use App\Helpers\ShipmentHelper;
use App\Models\ShipmentStatuses;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

class ReportController extends Controller
{


    function __construct()
    {
        $this->middleware(['permission:admin-Transaction-Collect-Rider-Cash'], ['only' => ['paymentsReport']]);
        $this->middleware(['permission:admin-Reports-claim-invoice'], ['only' => ['claimInvoice', 'printClaimInvoice']]);
        $this->middleware(['permission:admin-Reports-emirate-post'], ['only' => ['emirate_post', 'emirate_post_export']]);
    }

    public function paymentsReport()
    {
        $data['companies'] = VendorCompany::where('status', 1)->select('id', 'name')->get();
        $data['riders'] = Rider::select('id', 'name')->get();
        $data['payment_methods'] = PaymentMethods::select('id', 'name')->get();
        $data['shipment_status'] = ShipmentStatuses::select('id', 'name')->get();
        $data['emirates'] = Emirates::select('id', 'name')->get();
        $data['cities'] = Cities::select('id', 'name')->get();
        $data['branches'] = Branches::select('id', 'branch_name')->get();
        $date_from = Carbon::today()->format('Y-m-d');
        $date_to = Carbon::today()->format('Y-m-d');

        if (request()->date_from) {
            $date_from = Carbon::parse(request()->date_from)->format('Y-m-d');
        }
        if (request()->date_to) {
            $date_to = Carbon::parse(request()->date_to)->format('Y-m-d');
        }

        $query = Payment::query();

        $request = request();
        $last_30_days = '';
        $all_payments = ShipmentHelper::searchPayments($request, $query);
        $last_30_days = ShipmentHelper::searchPayments($request, $query)->whereBetween('date', [Carbon::parse($date_to)->subDay(30)->format('Y-m-d'), $date_to]);
        $data['payments_last_30_days'] = $last_30_days->pluck('id');


        // return $all_payments->whereBetween('date', [Carbon::parse($date_to)->subDay(1)->format('Y-m-d'), $date_to])->get();
        // return $all_payments->get();

        $data['from'] = $date_from;
        $data['to'] = $date_to;
        $data['vendor_amount_due'] = 0;


        $data['payments'] = $all_payments->whereBetween('date', [$date_from, $date_to])->get();



        // $data['cash_on_delivery'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 1)->sum('amount');
        $data['cash_on_delivery'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 1)->sum('amount');
        // $data['cod_sp_income'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 1)->where('amount', '>', 0)->sum('delivery_fees');
        $data['cod_sp_income'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 1)->where('amount', '>', 0)->sum('delivery_fees');
        $data['cod_vendor_balance'] = $data['cash_on_delivery'] - $data['cod_sp_income'];


        // $data['transfer_to_Bank'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 2)->sum('amount');
        $data['transfer_to_Bank'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 2)->sum('amount');
        // $data['tr_bank_sp_income'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 2)->where('amount', '>', 0)->sum('delivery_fees');
        $data['tr_bank_sp_income'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 2)->where('amount', '>', 0)->sum('delivery_fees');
        $data['tr_bank_vendor_balance'] = $data['transfer_to_Bank'] - $data['tr_bank_sp_income'];

        // $data['transfer_to_vendor_company'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', $all_payments->pluck('id'))->where('due_amount', '<', 0)->sum('due_amount');
        $data['transfer_to_vendor_company'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('due_amount', '<', 0)->sum('due_amount');


        // $data['total'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->sum('amount');
        $data['total'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', '!=', 3)->sum('amount');
        $data['net_income'] =  $data['cod_sp_income'] +  $data['tr_bank_sp_income'] + (- ($data['transfer_to_vendor_company']));
        $data['vendor_account'] =  ($data['cod_vendor_balance']) +  ($data['tr_bank_vendor_balance']) - (- ($data['transfer_to_vendor_company']));




        // calc vandor due
        $query = Shipment::query()->whereBetween('delivered_date', [$date_from, $date_to]);

        $request = request();

        $all_shipments = ShipmentHelper::searchShipment($request, $query);



        $data['shipments_vendor_due'] = $all_shipments
            ->where('status_id', 3)
            // ->where('is_rider_has', 0)
            ->where('is_vendor_get_due', 0)
            ->where('deleted_at', Null)
            ->get();


        // $data['companies_id'] =collect($data['payments'])->groupBy('company_id')->pluck('company_id');
        $data['companies_id'] = Payment::whereIn('id', collect($data['payments'])->pluck('id'))->groupBy('company_id')->pluck('company_id');
        $data['companies_id_30'] = Payment::whereIn('id', $data['payments_last_30_days'])->groupBy('company_id')->pluck('company_id');
        $data['vendor_amount_due'] =  Payment::whereIn('shipment_id',  $data['shipments_vendor_due']->pluck('id'))->sum('due_amount');


        ########### table summary ############################################################################

        $data['table_summary_vendors'] = array();

        foreach ($data['companies_id'] as $company_id) {

            $data['payments_table_summary'] = Payment::whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->whereBetween('date', [$date_from, $date_to])->get();



            // $data['cash_on_delivery_table_summary'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->where('deleted_at', Null)->where('payment_method_id', 1)->sum('amount');
            $data['cash_on_delivery_table_summary'] = Payment::whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->where('deleted_at', Null)->where('payment_method_id', 1)->sum('amount');
            // $data['cod_sp_income_table_summary'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->where('deleted_at', Null)->where('payment_method_id', 1)->where('amount', '>', 0)->sum('delivery_fees');
            $data['cod_sp_income_table_summary'] = Payment::whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->where('deleted_at', Null)->where('payment_method_id', 1)->where('amount', '>', 0)->sum('delivery_fees');
            $data['cod_vendor_balance_table_summary'] = $data['cash_on_delivery_table_summary'] - $data['cod_sp_income_table_summary'];


            // $data['transfer_to_Bank_table_summary'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->where('deleted_at', Null)->where('payment_method_id', 2)->sum('amount');
            $data['transfer_to_Bank_table_summary'] = Payment::whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->where('deleted_at', Null)->where('payment_method_id', 2)->sum('amount');
            // $data['tr_bank_sp_income_table_summary'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->where('deleted_at', Null)->where('payment_method_id', 2)->where('amount', '>', 0)->sum('delivery_fees');
            $data['tr_bank_sp_income_table_summary'] = Payment::whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->where('deleted_at', Null)->where('payment_method_id', 2)->where('amount', '>', 0)->sum('delivery_fees');
            $data['tr_bank_vendor_balance_table_summary'] = $data['transfer_to_Bank_table_summary'] - $data['tr_bank_sp_income_table_summary'];

            // $data['transfer_to_vendor_company_table_summary'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->where('due_amount', '<', 0)->sum('due_amount');
            $data['transfer_to_vendor_company_table_summary'] = Payment::whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->where('due_amount', '<', 0)->sum('due_amount');



            $name = VendorCompany::where('id', $company_id)->first()->name;

            $data['table_summary_vendors'][] = [
                'vendor_name' => $name,
                'count' => $data['payments']->where('company_id', $company_id)->count(),
                'due_amount' => ($data['cod_vendor_balance_table_summary']) +  ($data['tr_bank_vendor_balance_table_summary']) - (- ($data['transfer_to_vendor_company_table_summary']))
            ];
        }


        // return $data;
        ############# end table summary ###########################################################################

        ############# last 30 days vendor Balance #################################################################



        $data['last_30_days_vendor_account'] = Payment::whereIn('id', $data['payments_last_30_days'])
            ->groupBy('date')
            ->get();
        $days = array();
        $sum_days_30_2_with_days = array();
        $days_30_1 = array();
        $days_30_1_with_days = array();
        $days_30_2 = array();
        $days_30_2_with_days = array();
        foreach ($data['last_30_days_vendor_account'] as $day) {
            $pay1 = Payment::whereIn('id', $data['payments_last_30_days'])->where('due_amount', '<', 0)->where('is_vendor_get_due', 0)->whereDate('date', $day->date)->sum('due_amount');
            $pay2 = Payment::whereIn('id', $data['payments_last_30_days'])->whereDate('date', $day->date)->where('is_vendor_get_due', 0)->where('due_amount', '>', 0)->sum('due_amount');
            $days_30_1[] = abs($pay1);
            $days_30_2[] = $pay2;
            $days[] = $day->date;
            $days_30_1_with_days[] =  $pay1;
            $days_30_2_with_days[] = $pay2;
            $sum_days_30_2_with_days[] = $day->date . '( ' . $pay2 - abs($pay1) . ' AED )';
        }

        $data['days'] = $days;
        $data['days_30_1'] = $days_30_1_with_days;
        $data['days_30_2'] = $days_30_2_with_days;
        $data['sum_days_30'] = $sum_days_30_2_with_days;
        // return [array_sum($days_30_2) - array_sum($days_30_1)];
        // return $data['last_30_days_vendor_account'];

        $data['last_30_days_vendor_account'] = array_sum($days_30_2) - array_sum($days_30_1);
        ###########################################################################################################



        ###################### summary branches ####################################################################

        $branches_ids = $all_payments->groupBy('branch_created')->pluck('branch_created');
        $data['summary_branches'] = array();

        // // $summary_branches_payments = ShipmentHelper::searchPayments($request, $query)->get();

        foreach ($branches_ids as $branch) {
            $vendors_ids = $all_payments->groupBy('company_id')->where('branch_created',$branch)->pluck('company_id');
            foreach ($vendors_ids as $vendor){
                $payment_vendor_in = ShipmentHelper::searchPayments($request, $query)->where('company_id',$vendor)->where('in_out',0)->get();
                $payment_vendor_out = ShipmentHelper::searchPayments($request, $query)->where('company_id',$vendor)->where('in_out',1)->get();


            $data['summary_branches'][] =[
                'branch_name'=>Branches::where('id',$branch)->first()->branch_name,
                'vendor'=> VendorCompany::where('id',$vendor)->first()->name,
                'inside_payments'=> count($payment_vendor_in),
                // 'inside_payments_delivery_fees'=>ShipmentHelper::searchPayments($request, $query)->where('branch_created',$branch)->where('in_out',0)->sum('delivery_fees') / 0,
                // 'inside_payments_delivery_fees'=>0,
                'outside_payments'=> count($payment_vendor_out),
                'outside_payments_delivery_fees'=>ShipmentHelper::searchPayments($request, $query)->where('branch_created',$branch)->where('in_out',1)->sum('delivery_fees') / 2,
            ];
            }

        }

        // return $data['summary_branches'];

        ###########################################################################################################


        if (request()->input('action') == 'report') {
            return view('admin.shipment.reports.payment_report', $data);
        } else {
            return view('admin.shipment.reports.payments', $data);
        }
    }

    public function paymentsReportBranches(){
        $data['branches'] = Branches::where('is_main',0)->select('id','branch_name')->orderBy('id','asc')->get();
        $data['from'] = Carbon::now()->format('Y-m-d');
        $data['to'] = Carbon::now()->format('Y-m-d');

        if(Request()->date_from){
            $data['from'] = Carbon::parse(Request()->date_from)->format('Y-m-d');
        }
        if(Request()->date_to){
            $data['to'] = Carbon::parse(Request()->date_to)->format('Y-m-d');
        }

        $data['payments'] = Payment::where('branch_created',Request()->branch)->get();

        if(request()->input('action') == 'search_action'){
            return $data['payments'];
        }
        // return $data['payments'];
        return view('admin.shipment.reports.payment_branches',$data);
    }


    public function claimInvoice()
    {
        $data['emirates'] = Emirates::select('id', 'name')->get();
        $data['companies'] = VendorCompany::select('id', 'name')->get();

        return view('admin.shipment.reports.claim_invoice', $data);
    }

    public function printClaimInvoice(Request $request)
    {
        $date_from = Carbon::today()->format('Y-m-d');
        $date_to = Carbon::today()->format('Y-m-d');


        if (request()->date_from) {
            $date_from = Carbon::parse(request()->date_from)->format('Y-m-d');
        }
        if (request()->date_to) {
            $date_to = Carbon::parse(request()->date_to)->format('Y-m-d');
        }

        $data['company'] = VendorCompany::where('id', $request->company_id)->first();
        $data['setting'] = Settings::first();
        // اذا مو مقسمة هات مستحقات سبيشل لاين مضروبة بعدد المرات
        // $data['no_split_shipments'] = Shipment::select('company_id', 'specialline_due', DB::raw('COUNT(*) as count'))
        //     ->whereBetween('delivered_date', [$date_from, $date_to])
        //     ->where('company_id', $request->company_id)
        //     ->where('is_split_payment', 0)
        //     ->where('status_id', 3)
        //     ->where('is_rider_has', 0)
        //     ->where('is_vendor_has', 1)
        //     ->where('deleted_at', Null)
        //     ->where('payment_method_id', 3)
        //     ->where('specialline_due', '<>', 0)
        //     ->groupBy('specialline_due')
        //     ->get();

        // // اذا مقسمة هات مستحقات سبيشل لاين ناقص الدفعات المحولة لسبيشل لاين أو مسلنمة كاش
        // $all_split_shipments = Shipment::select('id', 'company_id', 'specialline_due', DB::raw('COUNT(*) as count'))
        // ->whereBetween('delivered_date', [$date_from, $date_to])
        // ->where('company_id', $request->company_id)
        // ->where('is_split_payment', 1)
        // ->where('status_id', 3)
        // ->where('is_rider_has', 0)
        // ->where('is_vendor_has', 1)
        // ->where('deleted_at', Null)
        // ->where('payment_method_id', 3)
        // ->where('specialline_due', '<>', 0)
        // ->get();

        // $data['split_shipments'] = [];
        // foreach ($all_split_shipments as $shipment) {
        //     $payment_to_cash = Payment::where('shipment_id', $shipment->id)->where('payment_method_id', 1)->first()->amount ?? 0;
        //     $payment_to_sp = Payment::where('shipment_id', $shipment->id)->where('payment_method_id', 2)->first()->amount ?? 0;

        //     $due = $shipment->specialline_due - ($payment_to_cash + $payment_to_sp);
        //     if ($due > 0) {
        //         $data['split_shipments'][] = [
        //             'company_id' => $shipment->company_id,
        //             'specialline_due' => $due,
        //             'count' => 1
        //         ];
        //     }
        // }

        $data['shipments'] = array();
        $data['payments'] = Payment::where('company_id', $request->company_id)
            ->whereBetween('date', [$date_from, $date_to])
            ->where('is_rider_has', 0)
            ->where('payment_method_id', 3)->where('is_vendor_get_due', 1)
            ->where('is_spl_get_due', 0)->where('is_split', 0)
            ->where('deleted_at', Null)
            ->get();


        $data['claims'] = Shipment::whereIn('id', $data['payments']->pluck('shipment_id'))

            ->select('id', 'company_id', 'specialline_due', DB::raw('COUNT(*) as count'))
            ->where('specialline_due', '<>', 0)
            ->groupBy('specialline_due')
            ->get();

        // return $data;
        return view('admin.shipment.reports.print_claim', $data);
    }

    public function emirate_post()
    {
        return view('admin.emirate_post.index');
    }

    public function emirate_post_export(Request $request)
    {
        return Excel::download(new EmiratePostExport, '' . Carbon::today()->toDateString() . '.csv');
    }
    public function payments_export(Request $request)
    {
        return Excel::download(new PaymentExport, '' . Carbon::today()->toDateString() . '.csv');
    }
}
