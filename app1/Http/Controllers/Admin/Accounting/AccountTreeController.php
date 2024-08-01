<?php

namespace App\Http\Controllers\Admin\Accounting;

use PDO;
use Carbon\Carbon;
use App\Models\AccountTree;
use Illuminate\Http\Request;
use App\Models\AccountingEntries;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\JounalType;
use App\Models\Payment;
use App\Models\Shipment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Rmunate\Utilities\SpellNumber;

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
        return AccountTree::where('account_level', $level)->select('id', 'account_name')->get();
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
                'account_final' => $request->account_final,
                'is_cash' => $request->cash ? 1 : 0
            ]
        );


        toastr()->success(__('admin.msg_success_add'));
        return redirect()->route('admin.account.index');
    }



    public function edit(Request $request)
    {
        return AccountTree::where('id', $request->id)->first();
    }


    // السندات

    public function journals()
    {

        $data['accounts'] = AccountTree::select('id', 'account_name', 'account_code')->get();
        $from = Carbon::now()->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');

        if (Request()->from) {
            $from = Carbon::parse(Request()->from)->format('Y-m-d');
        }

        if (Request()->to) {
            $to = Carbon::parse(Request()->to)->format('Y-m-d');
        }

        $query =
            AccountingEntries::query()->whereBetween('transaction_date', [$from, $to])
            ->orderBy('number', 'asc')->groupBy('number');

        if (Request()->account && Request()->account != 0) {
            $query->where('account_number', Request()->account);
        }
        $data['journal_numbers'] = $query->get();
        // return   $data['journal_numbers'];
        $data['journals'] = array();
        foreach ($data['journal_numbers'] as $number) {

            $credit = AccountingEntries::where('number', $number->number)->where('credit', '!=', 0)->first();
            $debit = AccountingEntries::where('number', $number->number)->where('debit', '!=', 0)->first();
            $currency = __('admin.currency');
            $data['journals'][] = [
                'number' => $number->number,
                'type' => JounalType::where('id', $number->journal_type_id)->first(),
                'credit' => "$credit->credit  $currency , $credit->account_number $credit->account_name",
                'debit' => "$debit->debit  $currency , $debit->account_number $debit->account_name",
                'statment' => $number->statment,
                'date' => $number->transaction_date
            ];
        }
        $data['sum_credit'] = AccountingEntries::whereIn('number', $data['journal_numbers']->pluck('number'))->whereBetween('transaction_date', [$from, $to])->sum('credit');
        $data['sum_debit'] = AccountingEntries::whereIn('number', $data['journal_numbers']->pluck('number'))->whereBetween('transaction_date', [$from, $to])->sum('debit');
        return view('admin.transactions.vouchers.journals', $data);
        // return $data['journals'];
    }

    //سند يومية
    public function journalVoucher()
    {
        $data['accounts'] = AccountTree::get();
        return view('admin.transactions.vouchers.journal_voucher', $data);
    }

    public function storeJournalVoucher(Request $request)
    {

        $voucher_nmber = 10000001;

        $account = AccountingEntries::select('number')->latest()->first();
        if ($account) {
            $voucher_nmber = $account->number + 1;
        } else {
            $voucher_nmber = $voucher_nmber;
        }

        $accounts = AccountTree::whereIn('id', $request->account_id)->get();

        $data['vouchers'] = [];
        foreach ($accounts as $key => $value) {
            $data['vouchers'][] = $this->createdJournal($request,  $key, $value, $journal_type = 1, $voucher_nmber);
        }

        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }


    public function reciptVoucher()
    {
        $data['accounts'] = AccountTree::get();
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

        $accounts = AccountTree::whereIn('id', $request->account_id)->get();

        $data['vouchers'] = [];
        foreach ($accounts as $key => $value) {
            $data['vouchers'][] = $this->createdJournal($request,  $key, $value, $journal_type = 2, $voucher_nmber);
        }

        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
        // return redirect()->route('admin.account.printRecipt_voucher')->with('ids',$ids);
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

        $accounts = AccountTree::whereIn('id', $request->account_id)->get();

        $data['vouchers'] = [];
        foreach ($accounts as $key => $value) {
            $data['vouchers'][] = $this->createdJournal($request,  $key, $value, $journal_type = 3, $voucher_nmber);
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
