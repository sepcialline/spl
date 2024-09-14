<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Rider;
use App\Models\Cities;
use App\Models\Company;
use App\Models\Payment;
use App\Models\Branches;
use App\Models\Emirates;
use App\Models\Settings;
use App\Models\Shipment;
use App\Models\AccountTree;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Exports\PaymentExport;
use App\Models\PaymentMethods;
use App\Helpers\ShipmentHelper;
use App\Http\Middleware\Branch;
use App\Models\ShipmentStatuses;
use App\Models\AccountingEntries;
use App\Exports\EmiratePostExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
        $data['branches'] = Branches::where('is_main', 0)->select('id', 'branch_name')->get();
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
        $last_balance_days = ''; // it change to all payments not just last 30 days
        $all_payments = ShipmentHelper::searchPayments($request, clone  $query);
        $last_balance_days = ShipmentHelper::searchPayments($request, clone  $query)->where('date', '<=', $date_to);


        // return $all_payments->whereBetween('date', [Carbon::parse($date_to)->subDay(1)->format('Y-m-d'), $date_to])->get();
        // return $all_payments->get();

        $data['from'] = $date_from;
        $data['to'] = $date_to;
        $data['vendor_amount_due'] = 0;


        $data['payments'] = $all_payments->whereBetween('date', [$date_from, $date_to])->get();

        $data['summary_accounts'] = array();

        $sum_cod = 0;
        $sum_tr_bank = 0;
        $sum_tr_vendor = 0;
        $sum_cod_sp_income = 0;
        $sum_tr_bank_sp_income = 0;
        $sum_transfer_to_vendor_company = 0;
        $sum_cod_vendor_balance = 0;
        $sum_tr_bank_vendor_balance = 0;
        $total = 0;
        $net_income = 0;
        $vendor_account = 0;

        foreach ($data['branches']->pluck('id') as $branch) {


            $data['summary_accounts'][] = [
                'branch_name' => $data['branch_name'] = Branches::where('id', $branch)->first()->branch_name,
                'cash_on_delivery' => $data['cash_on_delivery'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('branch_created', $branch)->where('payment_method_id', 1)->sum('amount'),
                'cod_sp_income' => $data['cod_sp_income'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('branch_created', $branch)->where('payment_method_id', 1)->sum('delivery_fees'),
                'cod_vendor_balance' => $data['cod_vendor_balance'] = $data['cash_on_delivery'] - $data['cod_sp_income'],


                'transfer_to_Bank' => $data['transfer_to_Bank'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('branch_created', $branch)->where('payment_method_id', 2)->sum('amount'),
                'tr_bank_sp_income' => $data['tr_bank_sp_income'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('branch_created', $branch)->where('payment_method_id', 2)->sum('delivery_fees'),
                'tr_bank_vendor_balance' => $data['tr_bank_vendor_balance'] = $data['transfer_to_Bank'] - $data['tr_bank_sp_income'],

                'transfer_to_vendor_company' => $data['transfer_to_vendor_company'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('branch_created', $branch)->where('payment_method_id', 3)->sum('due_amount'),

            ];

            $sum_cod = $data['cash_on_delivery'] + $sum_cod;
            $sum_tr_bank = $data['transfer_to_Bank'] + $sum_tr_bank;
            $sum_tr_vendor = $data['transfer_to_vendor_company'] + ($sum_tr_vendor);

            $sum_cod_sp_income =   $data['cash_on_delivery'] + $sum_cod_sp_income;
            $sum_tr_bank_sp_income = $data['transfer_to_Bank']  + $sum_tr_bank_sp_income;
            $sum_transfer_to_vendor_company = $data['transfer_to_vendor_company']  + $sum_transfer_to_vendor_company;
            $sum_cod_vendor_balance =  $data['cod_vendor_balance'] + $sum_cod_vendor_balance;
            $sum_tr_bank_vendor_balance =  $data['tr_bank_vendor_balance'] + $sum_tr_bank_vendor_balance;

            $total = $total +  Payment::whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('branch_created', $branch)->where('payment_method_id', '!=', 3)->sum('amount');
            $vendor_account = ($sum_cod_vendor_balance) +  ($sum_tr_bank_vendor_balance) - (- ($sum_transfer_to_vendor_company));
            $net_income = $total - $vendor_account;
        }


        $data['total'] = $total;
        $data['net_income'] = $net_income;
        $data['vendor_account'] = $vendor_account;

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
        $data['vendor_amount_due'] =  Payment::whereIn('shipment_id',  $data['shipments_vendor_due']->pluck('id'))->sum('due_amount');


        ########### table summary ############################################################################

        $data['table_summary_vendors'] = array();

        foreach ($data['companies_id'] as $company_id) {

            $data['payments_table_summary'] = Payment::whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->whereBetween('date', [$date_from, $date_to])->get();



            $data['cash_on_delivery_table_summary'] = Payment::whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->where('deleted_at', Null)->where('payment_method_id', 1)->sum('amount');
            $data['cod_sp_income_table_summary'] = Payment::whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->where('deleted_at', Null)->where('payment_method_id', 1)->sum('delivery_fees');
            $data['cod_vendor_balance_table_summary'] = $data['cash_on_delivery_table_summary'] - $data['cod_sp_income_table_summary'];


            $data['transfer_to_Bank_table_summary'] = Payment::whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->where('deleted_at', Null)->where('payment_method_id', 2)->sum('amount');
            $data['tr_bank_sp_income_table_summary'] = Payment::whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->where('deleted_at', Null)->where('payment_method_id', 2)->sum('delivery_fees');
            $data['tr_bank_vendor_balance_table_summary'] = $data['transfer_to_Bank_table_summary'] - $data['tr_bank_sp_income_table_summary'];

            $data['transfer_to_vendor_company_table_summary'] = Payment::whereIn('id', collect($data['payments'])->pluck('id'))->where('company_id', $company_id)->where('payment_method_id', 3)->sum('due_amount');




            $name = VendorCompany::where('id', $company_id)->first()->name;

            $data['table_summary_vendors'][] = [
                'vendor_name' => $name,
                'count' => $data['payments']->where('company_id', $company_id)->count(),
                'due_amount' => ($data['cod_vendor_balance_table_summary']) +  ($data['tr_bank_vendor_balance_table_summary']) - (- ($data['transfer_to_vendor_company_table_summary']))
            ];
        }




        if (Request()->company_id && Request()->company_id != 0) {
            $last_balance_days->where('company_id', Request()->company_id);
        }
        $data['last_balance'] = $last_balance_days->where('is_vendor_get_due', 0)->sum('due_amount');
        ###########################################################################################################




        ###########################################################################################################
        if (request()->input('action') == 'export') {
            return Excel::download(new PaymentExport, '' . Carbon::today()->toDateString() . '.xlsx');
        }

        if (request()->input('action') == 'report') {
            return view('admin.shipment.reports.payment_report', $data);
        } else {
            return view('admin.shipment.reports.payments', $data);
        }
    }

    public function paymentsReportBranches()
    {
        $data['branches'] = Branches::where('is_main', 0)->select('id', 'branch_name')->orderBy('id', 'asc')->get();
        $data['from'] = Carbon::now()->format('Y-m-d');
        $data['to'] = Carbon::now()->format('Y-m-d');

        if (Request()->date_from) {
            $data['from'] = Carbon::parse(Request()->date_from)->format('Y-m-d');
        }
        if (Request()->date_to) {
            $data['to'] = Carbon::parse(Request()->date_to)->format('Y-m-d');
        }

        $data['payments'] = Payment::where('branch_created', Request()->branch)->get();

        if (request()->input('action') == 'search_action') {
            return $data['payments'];
        }
        // return $data['payments'];
        return view('admin.shipment.reports.payment_branches', $data);
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
        return Excel::download(new EmiratePostExport, '' . Carbon::today()->toDateString() . '.xlsx');
    }
    public function payments_export(Request $request)
    {
        return Excel::download(new PaymentExport, '' . Carbon::today()->toDateString() . '.xlsx');
    }



    public function posted_journal_voucher(Request $request)
    {
        // استخدم eager loading لتحميل العلاقات المرتبطة مسبقاً
        $payments = Payment::where('posted_journal_voucher', 0)
            ->whereNull('deleted_at')
            ->where('date', '>=', Carbon::parse('2024-08-01'))
            ->with(['shipment', 'company'])
            ->limit(300)
            ->get();

        // احدث رقم قيد
        $latestAccountingEntry =  AccountingEntries::where('journal_type_id', 4)->select('number', 'journal_type_id')->latest()->first();


        $voucher_nmber = $latestAccountingEntry ? $latestAccountingEntry->number + 1 : 10000001;

        foreach ($payments as $payment) {
            $shipment = $payment->shipment;
            $vendor_account = $payment->company;
            $branch_delivered_id = $payment->branch_created;

            $vendor_account = VendorCompany::where('id', $payment->company_id)->first();
            $branch_rev_created = Branches::where('id', $shipment->company->branch_id)->first() ?? Branches::where('id', 2)->first();
            $branch_rev_delivered = Branches::where('id', $branch_delivered_id)->first();
            $cash_account = AccountTree::where('is_cash', 1)->first();
            $bank_account = AccountTree::where('is_bank', 1)->first();


            $branch_rev_created_name = AccountTree::where('account_code', $branch_rev_created->revenuse_account)->first();
            $branch_rev_delivered_name = AccountTree::where('account_code', $branch_rev_delivered->revenuse_account)->first();
            $branch_created_vat_on_sales = AccountTree::where('account_code', $branch_rev_created->vat_on_sales)->first();
            $branch_delivered_vat_on_de_sales = AccountTree::where('account_code', $branch_rev_delivered->vat_on_sales)->first();
            $vendor_account_name = AccountTree::where('account_code', $vendor_account->account_number)->first();



            // استعلامات للفرع المنشئ والفرع المستلم
            $branch_rev_created = Branches::find($shipment->branch_created);
            $branch_rev_delivered = Branches::find($payment->branch_created);

            $cash_account = AccountTree::where('is_cash', 1)->first();
            $bank_account = AccountTree::where('is_bank', 1)->first();

            if ($vendor_account && $branch_rev_created && $cash_account && $bank_account) {
                // حسابات الفرع المنشئ والفرع المستلم
                $created_delivered_branch = [];
                if ($shipment->company->branch_id != $payment->branch_created) {
                    $created_delivered_branch = [
                        '0' => [ // created branch
                            'code' => $branch_rev_created->revenuse_account,
                            'name' => ['ar' => $branch_rev_created_name->getTranslation('account_name', 'ar'), 'en' => $branch_rev_created_name->getTranslation('account_name', 'en')],
                            'vat' => $branch_rev_created->vat_on_sales,
                            'vat_name' => ['ar' => $branch_created_vat_on_sales->getTranslation('account_name', 'ar'), 'en' => $branch_created_vat_on_sales->getTranslation('account_name', 'en')]
                        ],
                        '1' => [ // delivered branch
                            'code' => $branch_rev_delivered->revenuse_account,
                            'name' => ['ar' => $branch_rev_delivered_name->getTranslation('account_name', 'ar'), 'en' => $branch_rev_delivered_name->getTranslation('account_name', 'en')],
                            'vat' => $branch_rev_delivered->vat_on_sales,
                            'vat_name' => ['ar' => $branch_delivered_vat_on_de_sales->getTranslation('account_name', 'ar'), 'en' => $branch_created_vat_on_sales->getTranslation('account_name', 'en')]
                        ],
                    ];
                } else {
                    $created_delivered_branch = [
                        '0' => [ // created branch and delivered
                            'code' => $branch_rev_created->revenuse_account,
                            'name' => ['ar' => $branch_rev_created_name->getTranslation('account_name', 'ar'), 'en' => $branch_rev_created_name->getTranslation('account_name', 'en')],
                            'vat' => $branch_rev_created->vat_on_sales,
                            'vat_name' => ['ar' => $branch_created_vat_on_sales->getTranslation('account_name', 'ar'), 'en' => $branch_created_vat_on_sales->getTranslation('account_name', 'en')]
                        ],
                    ];
                }

                // حسابات الضرائب والإيرادات
                foreach ($created_delivered_branch as $key => $value) {
                    ShipmentHelper::accounting_entries(
                        $debit_account_number = null,
                        $debit_account_name = null,
                        $credit_account_number = $created_delivered_branch[$key]['code'],
                        $credit_account_name = $created_delivered_branch[$key]['name'],
                        $statment = null,
                        $amount_debit = null,
                        $amount_credit = round(($payment->delivery_fees / (1.05)) / count($created_delivered_branch), 2),
                        $voucher_nmber,
                        $payment,
                        $shipment,
                        null,
                        'admin',
                        $compound_entry_with = null,
                        $journal_type_id = 4,
                        null,
                        null,
                        $payment->date
                    );
                    ShipmentHelper::accounting_entries(
                        $debit_account_number = null,
                        $debit_account_name = null,
                        $credit_account_number = $created_delivered_branch[$key]['vat'],
                        $credit_account_name = $created_delivered_branch[$key]['vat_name'],
                        $statment = null,
                        $amount_debit = null,
                        $amount_credit = round(($payment->delivery_fees - ($payment->delivery_fees / (1.05))) / count($created_delivered_branch), 2),
                        $voucher_nmber,
                        $payment,
                        $shipment,
                        null,
                        'admin',
                        $compound_entry_with = null,
                        $journal_type_id = 4, // sell voucher
                        null,
                        null,
                        $payment->date
                    );
                }

                // معالجة حسب طريقة الدفع
                if ($payment->payment_method_id == 1) { // cod

                    /*
                             * tow journal voucher
                             * ---- compound_entry_with ----
                             * 1-1  debit vendor account | credit rev branch (delivery fees) (25 |  (25*100)/1.05)
                             * 1-2 vat op (debit - credit (1statmtnet) ) credit قيد مركب
                             * 25 vendor debit | 23,95 rev credit
                             * 0 vendor debit | 1.05 vat output credit
                             *
                             *
                             *
                             * 2 - debit cash | credit vendor account (  due_amount )
                             *
                             *  3-
                             *
                             * المبلغ قبل الضريبة = المبلغ بعد الضريبة ÷ (1 + نسبة الضريبة)
                             * المبلغ بعد الضريبة = 25 (المبلغ الإجمالي المدفوع)
                             * نسبة الضريبة = 5% = 0.05
                             */

                    $enrty1 = ShipmentHelper::accounting_entries(
                        $debit_account_number = $vendor_account_name->account_code,
                        $debit_account_name = ['ar' => $vendor_account_name->getTranslation('account_name', 'ar'), 'en' => $vendor_account_name->getTranslation('account_name', 'en')],
                        $credit_account_number =  Null,
                        $credit_account_name = Null,
                        $statment = Null,
                        $amount_debit = round($payment->delivery_fees, 2),
                        $amount_credit = Null,
                        $voucher_nmber,
                        $payment,
                        $shipment,
                        null, // cost_center
                        'admin',
                        $compound_entry_with = Null,
                        $journal_type_id = 4,  // sell voucher
                        Null,
                        Null,
                        $payment->date
                    );



                    // rev with vat




                    $enrty4 = ShipmentHelper::accounting_entries(
                        $debit_account_number = $cash_account->account_code,  //cash
                        $debit_account_name = ['ar' => $cash_account->getTranslation('account_name', 'ar'), 'en' => $cash_account->getTranslation('account_name', 'en')], //cash
                        $credit_account_number = Null, //vendor account
                        $credit_account_name = Null, //vendor account
                        $statment = Null,
                        $amount_debit = round($payment->amount, 2),
                        $amount_credit = Null,
                        $voucher_nmber,
                        $payment,
                        $shipment,
                        null, // cost_center
                        'admin',
                        $compound_entry_with = Null,
                        $journal_type_id = 4,  // sell voucher
                        Null,
                        Null,
                        $payment->date
                    );
                    $enrty5 = ShipmentHelper::accounting_entries(
                        $debit_account_number = Null,  //cash
                        $debit_account_name = Null, //cash
                        $credit_account_number =  $vendor_account_name->account_code, //vendor account
                        $credit_account_name =  ['ar' => $vendor_account_name->getTranslation('account_name', 'ar'), 'en' => $vendor_account_name->getTranslation('account_name', 'en')], //vendor account
                        $statment = Null,
                        $amount_debit = Null,
                        $amount_credit = round($payment->amount, 2),
                        $voucher_nmber,
                        $payment,
                        $shipment,
                        null, // cost_center
                        'admin',
                        $compound_entry_with = Null,
                        $journal_type_id = 4,  // sell voucher
                        Null,
                        Null,
                        $payment->date
                    );
                } elseif ($payment->payment_method_id == 2) { // Tr-T-Sp
                    /*
                             * tow journal voucher
                             *
                             * 1-  debit vendor account | credit rev branch (delivery fees)
                             * 2 - debit bank | credit vendor account (  due_amount )
                             */
                    $enrty1 = ShipmentHelper::accounting_entries(
                        $debit_account_number = $vendor_account_name->account_code,
                        $debit_account_name = ['ar' => $vendor_account_name->getTranslation('account_name', 'ar'), 'en' => $vendor_account_name->getTranslation('account_name', 'en')],
                        $credit_account_number =  Null,
                        $credit_account_name = Null,
                        $statment = Null,
                        $amount_debit = round($payment->delivery_fees, 2),
                        $amount_credit = Null,
                        $voucher_nmber,
                        $payment,
                        $shipment,
                        null, // cost_center
                        'admin',
                        $compound_entry_with = Null,
                        $journal_type_id = 4,  // sell voucher
                        Null,
                        Null,
                        $payment->date
                    );


                    // rev with vat
                    $enrty4 = ShipmentHelper::accounting_entries(
                        $debit_account_number = $bank_account->account_code,  // bank
                        $debit_account_name = ['ar' => $bank_account->getTranslation('account_name', 'ar'), 'en' => $bank_account->getTranslation('account_name', 'en')], // bank
                        $credit_account_number =  Null, // vendor account
                        $credit_account_name = Null, // vendor account
                        $statment = Null,
                        $amount_debit = round($payment->amount, 2),
                        $amount_credit = Null,
                        $voucher_nmber,
                        $payment,
                        $shipment,
                        null, // cost_center
                        'admin',
                        $compound_entry_with = Null,
                        $journal_type_id = 4,  // sell voucher
                        Null,
                        Null,
                        $payment->date
                    );
                    $enrty5 = ShipmentHelper::accounting_entries(
                        $debit_account_number = Null,  // bank
                        $debit_account_name = Null, // bank
                        $credit_account_number =  $vendor_account_name->account_code, // vendor account
                        $credit_account_name = ['ar' => $vendor_account_name->getTranslation('account_name', 'ar'), 'en' => $vendor_account_name->getTranslation('account_name', 'en')], // vendor account
                        $statment = Null,
                        $amount_debit = Null,
                        $amount_credit = round($payment->amount, 2),
                        $voucher_nmber,
                        $payment,
                        $shipment,
                        null, // cost_center
                        'admin',
                        $compound_entry_with = Null,
                        $journal_type_id = 4,  // sell voucher
                        Null,
                        Null,
                        $payment->date
                    );
                } elseif ($payment->payment_method_id == 3) { // Tr-T-vendor
                    /*
                             * one journal voucher
                             * 1-   from vendor account | to rev branch (delivery fees)
                             */

                    ShipmentHelper::accounting_entries(
                        $debit_account_number = $vendor_account_name->account_code,  // vendor account
                        $debit_account_name =  ['ar' => $vendor_account_name->getTranslation('account_name', 'ar'), 'en' => $vendor_account_name->getTranslation('account_name', 'en')], //vendor account
                        $credit_account_number =  Null, //branch rev account
                        $credit_account_name = Null, //branch rev account
                        $statment = Null,
                        $amount_debit = round($payment->delivery_fees, 2),
                        $amount_credit = Null,
                        $voucher_nmber,
                        $payment,
                        $shipment,
                        null, // cost_center
                        'admin',
                        $compound_entry_with = Null,
                        $journal_type_id = 4,  // sell voucher
                        Null,
                        Null,
                        $payment->date
                    );

                    // rev with vat
                }


                // تحديث الحالة
                $payment->update(['posted_journal_voucher' => 1]);

                // تحديث الرقم التالي للقيد
                $voucher_nmber++;
            }
        }

        return redirect()->back();
    }


    public function companies_balance()
    {
        // جلب بيانات المجموعات
        // $data['companies'] = VendorCompany::where('status', 1)->select('id', 'name')->get();
        // $data['riders'] = Rider::select('id', 'name')->get();
        // $data['payment_methods'] = PaymentMethods::select('id', 'name')->get();
        // $data['shipment_status'] = ShipmentStatuses::select('id', 'name')->get();
        // $data['emirates'] = Emirates::select('id', 'name')->get();
        // $data['cities'] = Cities::select('id', 'name')->get();
        // $data['branches'] = Branches::where('is_main', 0)->select('id', 'branch_name')->get();

        // تعيين التاريخ الافتراضي
        $data['from'] = Carbon::now()->subYear()->format('Y-m-d'); // افتراضياً من سنة مضت
        $data['to'] = Carbon::now()->format('Y-m-d'); // افتراضياً اليوم

        // تعديل التاريخ بناءً على المدخلات
        if (request()->has('date_from')) {
            $data['from'] = Carbon::parse(request()->date_from)->format('Y-m-d');
        }

        if (request()->has('date_to')) {
            $data['to'] = Carbon::parse(request()->date_to)->format('Y-m-d');
        }

        // بناء الاستعلام
        $data['balances'] =DB::table('payments')
        ->select(
            DB::raw('SUM(payments.due_amount) AS due_amount'),
            DB::raw('JSON_UNQUOTE(JSON_EXTRACT(vendor_companies.name, "$.en")) AS vendor_name_en'),
            DB::raw('JSON_UNQUOTE(JSON_EXTRACT(vendor_companies.name, "$.ar")) AS vendor_name_ar'),
            'vendor_companies.vendor_rate'
        )
        ->join('vendor_companies', 'payments.company_id', '=', 'vendor_companies.id')
        ->whereBetween('payments.date', [$data['from'],$data['to']])
        ->whereNull('payments.deleted_at')
        ->where('payments.is_vendor_get_due', 0)
        ->groupBy('payments.company_id')
        ->having('due_amount', '!=', 0)
        ->get();


        return view('admin.shipment.reports.companies_balance', $data);
    }
}
