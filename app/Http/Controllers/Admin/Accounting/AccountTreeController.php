<?php

namespace App\Http\Controllers\Admin\Accounting;

use App\Exports\JournalsExport;
use PDO;
use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Branches;
use App\Models\CarPLate;
use App\Models\Shipment;
use App\Models\JounalType;
use App\Models\AccountTree;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Helpers\ShipmentHelper;
use App\Models\AccountingEntries;
use Illuminate\Support\Facades\DB;
use Rmunate\Utilities\SpellNumber;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AccountTreeController extends Controller
{

    function __construct()
    {
        $this->middleware(['permission:admin-Chart-Of-Accounts-showPage'], ['only' => ['index', 'store', 'edit']]);
        $this->middleware(['permission:admin-Transaction-Show-Journals'], ['only' => ['journals']]);
        $this->middleware(['permission:admin-Transaction-Journal-Voucher'], ['only' => ['journalVoucher', 'storeJournalVoucher']]);
        $this->middleware(['permission:admin-Transaction-Recipt-Voucher'], ['only' => ['reciptVoucher', 'storeReciptVoucher', 'printReciptVoucher']]);
        $this->middleware(['permission:admin-Transaction-Journal-Voucher'], ['only' => ['paymentVoucher', 'storePaymentVoucher', 'printPaymentVoucher']]);
    }

    public function index()
    {
        $data['accounts'] = AccountTree::where('account_parent', Null)->with('childrenAccounts')->get();
        return view('admin.account.index', $data);
    }

    public function getParent(Request $request)
    {
        $level = $request->level - 1;
        return AccountTree::where('account_level', $level)->select('id', 'account_name', 'account_code')->get();
    }

    public function store(Request $request)
    {
        $id = null;
        if ($request->id != Null) {
            $id = $request->id;
            $request->validate([
                'code' => 'required|unique:account_trees,account_code,' . $id,
            ]);
        } else {
            $request->validate([
                'code' => 'required|unique:account_trees,account_code',
            ]);
        }

        $account = AccountTree::updateOrCreate(
            ['account_code' => $request->code],
            [
                'account_level' => $request->level,
                'account_code' => $request->code,
                'account_name' => ['ar' => $request->name_ar, 'en' => $request->name_en],
                'account_type' => $request->type,
                'account_parent' => $request->parent,
                'account_dc_type' => $request->account_dc_type,
                'account_final' => $request->account_final
            ]
        );


        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }



    public function edit($id)
    {
        $data['account'] = AccountTree::where('id', $id)->first();
        $data['accounts_trees'] = AccountTree::select('id', 'account_name', 'account_code')->get();
        return view('admin.account.edit', $data);
    }

    public function update(Request $request)
    {
        $account = AccountTree::find($request->id)->update(
            [
                'account_level' => $request->level,
                'account_code' => $request->code,
                'account_name' => ['ar' => $request->name_ar, 'en' => $request->name_en],
                'account_type' => $request->type,
                'account_parent' => $request->parent,
                'account_dc_type' => $request->account_dc_type,
                'account_final' => $request->account_final
            ]
        );


        toastr()->success(__('admin.msg_success_add'));
        return redirect()->route('admin.account.index');
    }

    // السندات

    public function journals()
    {

        $data['accounts'] = AccountTree::select('id', 'account_name', 'account_code')->get();
        $from = Carbon::now()->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');

        $query =
            AccountingEntries::query();
        if (Request()->from) {
            $from = Carbon::parse(Request()->from)->format('Y-m-d');
        }
        if (Request()->to) {
            $to = Carbon::parse(Request()->to)->format('Y-m-d');
        }


        $query->whereBetween('transaction_date', [$from, $to]);

        if (Request()->account && Request()->account != 0) {
            $query->where('debit_account_number', Request()->account)->orWhere('credit_account_number', Request()->account);
        }
        if (Request()->search) {
            $query->where('number', Request()->search);
        }


        // // $data['journals'] = $query->orderBy('id','desc')->groupBy('number')->pluck('number');
        $data['entries'] = $query->orderBy('id', 'desc')->paginate(50);



        $query_total = AccountingEntries::query();

        if (Request()->from || Request()->to) {
            $from = Request()->from ? Carbon::parse(Request()->from)->format('Y-m-d') : Carbon::now()->format('Y-m-d');
            $to = Request()->to ? Carbon::parse(Request()->to)->format('Y-m-d') : Carbon::now()->format('Y-m-d');
            $query_total->whereBetween('transaction_date', [$from, $to]);
        }

        if (Request()->account && Request()->account != 0) {
            $query_total->where(function ($query) {
                $query->where('debit_account_number', Request()->account)
                    ->orWhere('credit_account_number', Request()->account);
            });
        }

        if (Request()->search) {
            $query_total->where('number', Request()->search);
        }




        $entries_total = $query_total->get();

        $account_totals = $entries_total->groupBy('debit_account_number')->map(function ($entries_total, $accountNumber) {
            $total_debit = $entries_total->sum('amount_debit');
            $total_credit = $entries_total->sum('amount_credit');
            return [
                'account_number' => $accountNumber,
                'total_debit' => $total_debit,
                'total_credit' => $total_credit,
                'balance' => $total_debit - $total_credit,
            ];
        });

        $total_sums = $account_totals->reduce(function ($carry, $item) {
            $carry['total_debit'] += $item['total_debit'];
            $carry['total_credit'] += $item['total_credit'];
            $carry['total_balance'] += $item['balance'];
            return $carry;
        }, ['total_debit' => 0, 'total_credit' => 0, 'total_balance' => 0]);

        $total_debit = round($total_sums['total_debit'], 2);
        $total_credit = round($total_sums['total_credit'], 2);
        $total_balance = round($total_sums['total_balance'], 2);

        // Print or return the results as needed
        $data['totals'] = [
            'account_totals' => $account_totals,
            'total_debit' => round($total_debit, 2),
            'total_credit' => round($total_credit, 2),
            'total_balance' => round($total_balance, 2),
        ];

        if (Request()->action == 'export') {
            return Excel::download(new JournalsExport, 'journals_' . $from . 'to' . $to . '.xlsx');
        }



        return view('admin.transactions.vouchers.journals', $data);
    }


    //ميزان المراجعة
    public function balance_review()
    {
        $data['accounts'] = AccountTree::select('id', 'account_name', 'account_code')->get();
        $from = Carbon::now()->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');

        $query =
            AccountingEntries::query();
        if (Request()->from) {
            $from = Carbon::parse(Request()->from)->format('Y-m-d');
        }
        if (Request()->to) {
            $to = Carbon::parse(Request()->to)->format('Y-m-d');
        }


        $query->whereBetween('transaction_date', [$from, $to]);

        if (Request()->account && Request()->account != 0) {
            $query->where('debit_account_number', Request()->account)->orWhere('credit_account_number', Request()->account);
        }
        if (Request()->search) {
            $query->where('number', Request()->search);
        }


        // // $data['journals'] = $query->orderBy('id','desc')->groupBy('number')->pluck('number');
        $data['entries'] = $query->orderBy('id', 'desc')->paginate(50);



        $query_total = AccountingEntries::query();

        if (Request()->from || Request()->to) {
            $from = Request()->from ? Carbon::parse(Request()->from)->format('Y-m-d') : Carbon::now()->format('Y-m-d');
            $to = Request()->to ? Carbon::parse(Request()->to)->format('Y-m-d') : Carbon::now()->format('Y-m-d');
            $query_total->whereBetween('transaction_date', [$from, $to]);
        }

        if (Request()->account && Request()->account != 0) {
            $query_total->where(function ($query) {
                $query->where('debit_account_number', Request()->account)
                    ->orWhere('credit_account_number', Request()->account);
            });
        }

        if (Request()->search) {
            $query_total->where('number', Request()->search);
        }

        $entries_total = $query_total->get();

        $data['account_totals'] = $entries_total->groupBy('debit_account_number')->map(function ($entries_total, $accountNumber) {
            $total_debit = $entries_total->sum('amount_debit');
            $total_credit = $entries_total->sum('amount_credit');
            return [
                'account_number' => AccountTree::where('account_code', $accountNumber)->first(),
                'total_debit' => $total_debit,
                'total_credit' => $total_credit,
                'balance' => $total_debit - $total_credit,
            ];
        });

        // return $data['account_totals'];
        return view('admin.transactions.vouchers.balance_review', $data);
    }

    //سند يومية
    public function journalVoucher()
    {
        $data['accounts'] = AccountTree::doesntHave('childrenAccounts')->select('id', 'account_name', 'account_code')->get();
        $data['cars'] = CarPLate::select('car_name', 'car_plate')->get();
        return view('admin.transactions.vouchers.journal_voucher', $data);
    }

    public function storeJournalVoucher(Request $request)
    {

        foreach ($request['debit_account_id'] as $key => $account_id) {


            $voucher_nmber = 10000001;

            $account = AccountingEntries::select('number')->latest()->first();
            if ($account) {
                $voucher_nmber = $account->number + 1;
            } else {
                $voucher_nmber = $voucher_nmber;
            }



            $debit[$key] = AccountTree::where('id', $account_id)->first();
            $credit[$key] = AccountTree::where('id', $request['credit_account_id'][$key])->first();

            $first_line = ShipmentHelper::accounting_entries(
                $debit_account_number = $debit[$key]->account_code,
                $debit_account_name =  ['ar' => $debit[$key]->getTranslation('account_name', 'ar'), 'en' => $debit[$key]->getTranslation('account_name', 'en')],
                $credit_account_number = Null,
                $credit_account_name = Null,
                $statment = $request->statments[$key] ?? Null,
                $amount_debit = $request->debit_amount[$key],
                $amount_credit = Null,
                $voucher_nmber,
                $payment = Null,
                $shipment = $request->shipment_refrence[$key] ? Shipment::where('shipment_refrence', $request->shipment_refrence[$key])->orderBy('updated_at', 'desc')->first() : Null,
                $cost_center = $request->cost_centers[$key] ? CarPLate::where('id', $request->cost_centers[$key])->first()->id : null,
                $guard = 'admin',
                $compound_entry_with = Null,
                $journal_type_id = 1 // daily
            );
            $second_line = ShipmentHelper::accounting_entries(
                $debit_account_number = Null,
                $debit_account_name =  Null,
                $credit_account_number = $credit[$key]->account_code,
                $credit_account_name = ['ar' => $credit[$key]->getTranslation('account_name', 'ar'), 'en' => $credit[$key]->getTranslation('account_name', 'en')],
                $statment = $request->statments[$key] ?? Null,
                $amount_debit = Null,
                $amount_credit = $request->credit_amount[$key],
                $voucher_nmber,
                $payment = Null,
                $shipment = $request->shipment_refrence[$key] ? Shipment::where('shipment_refrence', $request->shipment_refrence[$key])->orderBy('updated_at', 'desc')->first() : null,
                $cost_center = $request->cost_centers[$key] ? CarPLate::where('id', $request->cost_centers[$key])->first()->id : null,
                $guard = 'admin',
                $compound_entry_with = Null,
                $journal_type_id = 1 // daily
            );
        }

        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }


    public function reciptVoucher()
    {
        $data['accounts'] = AccountTree::get();
        $data['cars'] = CarPLate::select('id', 'car_name', 'car_plate')->get();
        return view('admin.transactions.vouchers.recipt_voucher', $data);
    }


    public function storeReciptVoucher(Request $request)
    {
        $voucher_nmber = 10000001;

        $account = AccountingEntries::select('number')->latest()->first();
        if ($account) {
            $voucher_nmber = $account->number + 1;
        } else {
            $voucher_nmber = $voucher_nmber;
        }

        // give me debit array if first line debit is null => account is credite && same thing for credit account
        $credites = $request->credit;
        $debits = $request->debit;
        // return $request;
        if ($credites[0] == Null && $debits[0] != null) {
            $credit = AccountTree::where('id', $request->account_id[1])->first();
            $debit = AccountTree::where('id', $request->account_id[0])->first();


            $first_line = ShipmentHelper::accounting_entries(
                $debit_account_number = $debit->account_code,
                $debit_account_name =  ['ar' => $debit->getTranslation('account_name', 'ar'), 'en' => $debit->getTranslation('account_name', 'en')],
                $credit_account_number = Null,
                $credit_account_name = Null,
                $statment = $request->statment,
                $amount_debit = $debits[0],
                $amount_credit = Null,
                $voucher_nmber,
                $payment = Null,
                $shipment = $request->shipment_refrence ? Shipment::where('shipment_refrence', $request->shipment_refrence)->orderBy('updated_at', 'desc')->first() : Null,
                $cost_center = $request->cost_center ? CarPLate::where('id', $request->cost_center)->first()->id : null,
                $guard = 'admin',
                $compound_entry_with = Null,
                $journal_type_id = 2 // recipt
            );
            $second_line = ShipmentHelper::accounting_entries(
                $debit_account_number = Null,
                $debit_account_name =  Null,
                $credit_account_number = $credit->account_code,
                $credit_account_name = ['ar' => $credit->getTranslation('account_name', 'ar'), 'en' => $credit->getTranslation('account_name', 'en')],
                $statment = $request->statment,
                $amount_debit = Null,
                $amount_credit = $credites[1],
                $voucher_nmber,
                $payment = Null,
                $shipment = $request->shipment_refrence ? Shipment::where('shipment_refrence', $request->shipment_refrence)->orderBy('updated_at', 'desc')->first() : null,
                $cost_center = $request->cost_center ? CarPLate::where('id', $request->cost_center)->first()->id : null,
                $guard = 'admin',
                $compound_entry_with = Null,
                $journal_type_id = 2 // recipt
            );
        }

        if ($credites[0] != Null && $debits[0] == null) {
            $credit = AccountTree::where('id', $request->account_id[0])->first();
            $debit = AccountTree::where('id', $request->account_id[1])->first();
            $first_line = ShipmentHelper::accounting_entries(
                $debit_account_number = Null,
                $debit_account_name =  Null,
                $credit_account_number = $credit->account_code,
                $credit_account_name = ['ar' => $credit->getTranslation('account_name', 'ar'), 'en' => $credit->getTranslation('account_name', 'en')],
                $statment = $request->statment,
                $amount_debit = Null,
                $amount_credit = $credites[0],
                $voucher_nmber,
                $payment = Null,
                $shipment = $request->shipment_refrence ? Shipment::where('shipment_refrence', $request->shipment_refrence)->orderBy('updated_at', 'desc')->first() : null,
                $cost_center = $request->cost_center ? CarPLate::where('id', $request->cost_center)->first()->id : null,
                $guard = 'admin',
                $compound_entry_with = Null,
                $journal_type_id = 2 // recipt
            );
            $second_line = ShipmentHelper::accounting_entries(
                $debit_account_number = $debit->account_code,
                $debit_account_name =  ['ar' => $debit->getTranslation('account_name', 'ar'), 'en' => $debit->getTranslation('account_name', 'en')],
                $credit_account_number = Null,
                $credit_account_name = Null,
                $statment = $request->statment,
                $amount_debit = $debits[1],
                $amount_credit = Null,
                $voucher_nmber,
                $payment = Null,
                $shipment = $request->shipment_refrence ? Shipment::where('shipment_refrence', $request->shipment_refrence)->orderBy('updated_at', 'desc')->first() : Null,
                $cost_center = $request->cost_center ? CarPLate::where('id', $request->cost_center)->first()->id : null,
                $guard = 'admin',
                $compound_entry_with = Null,
                $journal_type_id = 2 // recipt
            );
        }





        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }

    public function printReciptVoucher($number)
    {
        $data['voucher'] = AccountingEntries::where('number', $number)->where('credit', '!=', 0)->first();
        $data['account'] = AccountTree::where('account_code', $data['voucher']->account_number)->first();

        $data['credit_en'] = $this->numberToWordEn($data['voucher']->credit);
        $data['credit_ar'] = $this->numberToWordAr($data['voucher']->credit);
        return view('admin.transactions.vouchers.print_recipt_voucher', $data);
    }

    public function paymentVoucher()
    {
        $data['accounts'] = AccountTree::get();
        $data['cars'] = CarPLate::select('car_name', 'car_plate')->get();

        return view('admin.transactions.vouchers.payment_voucher', $data);
    }


    public function storePaymentVoucher(Request $request)
    {
        $voucher_nmber = 10000001;

        $account = AccountingEntries::select('number')->latest()->first();
        if ($account) {
            $voucher_nmber = $account->number + 1;
        } else {
            $voucher_nmber = $voucher_nmber;
        }

        // give me debit array if first line debit is null => account is credite && same thing for credit account
        $credites = $request->credit;
        $debits = $request->debit;
        // return $request;
        if ($credites[0] == Null && $debits[0] != null) {
            $credit = AccountTree::where('id', $request->account_id[1])->first();
            $debit = AccountTree::where('id', $request->account_id[0])->first();


            $first_line = ShipmentHelper::accounting_entries(
                $debit_account_number = $debit->account_code,
                $debit_account_name =  ['ar' => $debit->getTranslation('account_name', 'ar'), 'en' => $debit->getTranslation('account_name', 'en')],
                $credit_account_number = Null,
                $credit_account_name = Null,
                $statment = $request->statment,
                $amount_debit = $debits[0],
                $amount_credit = Null,
                $voucher_nmber,
                $payment = Null,
                $shipment = $request->shipment_refrence ? Shipment::where('shipment_refrence', $request->shipment_refrence)->orderBy('updated_at', 'desc')->first() : Null,
                $cost_center = $request->cost_center ? CarPLate::where('id', $request->cost_center)->first()->id : null,
                $guard = 'admin',
                $compound_entry_with = Null,
                $journal_type_id = 3 // payment
            );
            $second_line = ShipmentHelper::accounting_entries(
                $debit_account_number = Null,
                $debit_account_name =  Null,
                $credit_account_number = $credit->account_code,
                $credit_account_name = ['ar' => $credit->getTranslation('account_name', 'ar'), 'en' => $credit->getTranslation('account_name', 'en')],
                $statment = $request->statment,
                $amount_debit = Null,
                $amount_credit = $credites[1],
                $voucher_nmber,
                $payment = Null,
                $shipment = $request->shipment_refrence ? Shipment::where('shipment_refrence', $request->shipment_refrence)->orderBy('updated_at', 'desc')->first() : null,
                $cost_center = $request->cost_center ? CarPLate::where('id', $request->cost_center)->first()->id : null,
                $guard = 'admin',
                $compound_entry_with = Null,
                $journal_type_id = 3 // payment
            );
        }

        if ($credites[0] != Null && $debits[0] == null) {
            $credit = AccountTree::where('id', $request->account_id[0])->first();
            $debit = AccountTree::where('id', $request->account_id[1])->first();
            $first_line = ShipmentHelper::accounting_entries(
                $debit_account_number = Null,
                $debit_account_name =  Null,
                $credit_account_number = $credit->account_code,
                $credit_account_name = ['ar' => $credit->getTranslation('account_name', 'ar'), 'en' => $credit->getTranslation('account_name', 'en')],
                $statment = $request->statment,
                $amount_debit = Null,
                $amount_credit = $credites[0],
                $voucher_nmber,
                $payment = Null,
                $shipment = $request->shipment_refrence ? Shipment::where('shipment_refrence', $request->shipment_refrence)->orderBy('updated_at', 'desc')->first() : null,
                $cost_center = $request->cost_center ? CarPLate::where('id', $request->cost_center)->first()->id : null,
                $guard = 'admin',
                $compound_entry_with = Null,
                $journal_type_id = 3 // payment
            );
            $second_line = ShipmentHelper::accounting_entries(
                $debit_account_number = $debit->account_code,
                $debit_account_name =  ['ar' => $debit->getTranslation('account_name', 'ar'), 'en' => $debit->getTranslation('account_name', 'en')],
                $credit_account_number = Null,
                $credit_account_name = Null,
                $statment = $request->statment,
                $amount_debit = $debits[1],
                $amount_credit = Null,
                $voucher_nmber,
                $payment = Null,
                $shipment = $request->shipment_refrence ? Shipment::where('shipment_refrence', $request->shipment_refrence)->orderBy('updated_at', 'desc')->first() : Null,
                $cost_center = $request->cost_center ? CarPLate::where('id', $request->cost_center)->first()->id : null,
                $guard = 'admin',
                $compound_entry_with = Null,
                $journal_type_id = 3 // payment
            );
        }


        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }

    public function printPaymentVoucher($number)
    {
        $data['voucher'] = AccountingEntries::where('number', $number)->where('debit', '!=', 0)->first();
        $data['account'] = AccountTree::where('account_code', $data['voucher']->account_number)->first();

        $data['debit_en'] = $this->numberToWordEn($data['voucher']->debit);
        $data['debit_ar'] = $this->numberToWordAr($data['voucher']->debit);

        return view('admin.transactions.vouchers.print_payment_voucher', $data);
    }

    // القيود
    public function createdJournal($request, $key, $value, $journal_type, $voucher_nmber)
    {

        $account_entry = new AccountingEntries();
        $account_entry->number = $voucher_nmber;
        $account_entry->account_number = $value->account_code;
        $account_entry->account_name = $value->account_name;
        $account_entry->statment = $request->statment;
        $account_entry->debit = $request->debit[$key];
        $account_entry->credit = $request->credit[$key];
        $account_entry->transaction_date = $request->date;
        $account_entry->is_posted = 0;
        $account_entry->journal_type_id = $journal_type; // قيد يومي
        $account_entry->created_by = Auth::guard('admin')->user()->name;
        $account_entry->save();
        return $account_entry;
    }


    public function numberToWordAr($num = '')
    {
        $num    = (string) ((int) $num);

        if ((int) ($num) && ctype_digit($num)) {
            $words  = array();

            $num    = str_replace(array(',', ' '), '', trim($num));

            $list1  = array(
                '', 'واحد', 'اثنان', 'ثلاثة', 'أربعة', 'خمسة', 'ستة', 'سبعة',
                'ثمانية', 'تسعة', 'عشرة', 'احدى عشر', 'اثنا عشر', 'ثلاثة عشر', 'أربعة عشر',
                'خمسة عشر', 'ستة عشر', 'سبعة عشر', 'ثمانية عشر', 'تسعة عشر'
            );

            $list2  = array(
                '', 'عشرة', 'عشرون', 'ثلاثون', 'اربعون', 'خمسون', 'ستون',
                'سبعون', 'ثمانون', 'تسعون', 'مئة'
            );

            $list3  = array(
                '', 'ألف', 'مليون', 'بيليون', 'تريليون',
                'quadrillion', 'quintillion', 'sextillion', 'septillion',
                'octillion', 'nonillion', 'decillion', 'undecillion',
                'duodecillion', 'tredecillion', 'quattuordecillion',
                'quindecillion', 'sexdecillion', 'septendecillion',
                'octodecillion', 'novemdecillion', 'vigintillion'
            );

            $num_length = strlen($num);
            $levels = (int) (($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num    = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);

            foreach ($num_levels as $num_part) {
                $levels--;
                $hundreds   = (int) ($num_part / 100);
                $hundreds   = ($hundreds ? ' ' . $list1[$hundreds] . ' مئة' . ($hundreds == 1 ? '' : 's') . ' ' : '');
                $tens       = (int) ($num_part % 100);
                $singles    = '';

                if ($tens < 20) {
                    $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
                } else {
                    $tens = (int) ($tens / 10);
                    $tens = ' ' . $list2[$tens] . ' ';
                    $singles = (int) ($num_part % 10);
                    $singles = ' ' . $list1[$singles] . ' ';
                }
                $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
            }
            $commas = count($words);
            if ($commas > 1) {
                $commas = $commas - 1;
            }

            $words  = implode(', ', $words);

            $words  = trim(str_replace(' ,', ',', ucwords($words)), ', ');
            if ($commas) {
                $words  = str_replace(',', ' و', $words);
            }

            return $words;
        } else if (!((int) $num)) {
            return 'Zero';
        }
        return '';
    }
    public function numberToWordEn($num = '')
    {
        $num    = (string) ((int) $num);

        if ((int) ($num) && ctype_digit($num)) {
            $words  = array();

            $num    = str_replace(array(',', ' '), '', trim($num));

            $list1  = array(
                '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven',
                'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
                'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
            );

            $list2  = array(
                '', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty',
                'seventy', 'eighty', 'ninety', 'hundred'
            );

            $list3  = array(
                '', 'thousand', 'million', 'billion', 'trillion',
                'quadrillion', 'quintillion', 'sextillion', 'septillion',
                'octillion', 'nonillion', 'decillion', 'undecillion',
                'duodecillion', 'tredecillion', 'quattuordecillion',
                'quindecillion', 'sexdecillion', 'septendecillion',
                'octodecillion', 'novemdecillion', 'vigintillion'
            );

            $num_length = strlen($num);
            $levels = (int) (($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num    = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);

            foreach ($num_levels as $num_part) {
                $levels--;
                $hundreds   = (int) ($num_part / 100);
                $hundreds   = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ($hundreds == 1 ? '' : 's') . ' ' : '');
                $tens       = (int) ($num_part % 100);
                $singles    = '';

                if ($tens < 20) {
                    $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
                } else {
                    $tens = (int) ($tens / 10);
                    $tens = ' ' . $list2[$tens] . ' ';
                    $singles = (int) ($num_part % 10);
                    $singles = ' ' . $list1[$singles] . ' ';
                }
                $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
            }
            $commas = count($words);
            if ($commas > 1) {
                $commas = $commas - 1;
            }

            $words  = implode(', ', $words);

            $words  = trim(str_replace(' ,', ',', ucwords($words)), ', ');
            if ($commas) {
                $words  = str_replace(',', ' and', $words);
            }

            return $words;
        } else if (!((int) $num)) {
            return 'Zero';
        }
        return '';
    }


    public function bulk_payment(Request $request)
    {



        $Payments = Payment::whereIn('company_id', $request->bulk_company_id)->where('is_vendor_get_due', 0)->whereDate('date', '<=', Carbon::parse($request->till_date)->format('Y-m-d'))->get();
        $Payments->each->update(['is_spl_get_due' => 1, 'is_vendor_get_due' => 1]);
        $shipments = Shipment::whereIn('company_id', $request->bulk_company_id)->where('is_vendor_get_due', 0)->whereDate('delivered_date', '<=', Carbon::parse($request->till_date)->format('Y-m-d'))->get();
        $shipments->each->update(['is_spl_get_due' => 1, 'is_vendor_get_due' => 1]);

        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }
}
