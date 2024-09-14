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
use App\Http\Middleware\Branch;
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
        $data['branches'] = Branches::where('is_main', 0)->select('id', 'branch_name')->get();
        $data['cost_centers'] = CarPLate::select('id', 'car_name', 'car_plate')->get();
        $data['final_accounts'] = ['1' => 'الميزانية', '2' => ' الأرباح والخسائر'];
        $from = Carbon::now()->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');

        $query = AccountingEntries::query();
        if (Request()->from) {
            $from = Carbon::parse(Request()->from)->format('Y-m-d');
        }
        if (Request()->to) {
            $to = Carbon::parse(Request()->to)->format('Y-m-d');
        }



        if (Request()->branch_id) {
            $query->where('branch_id', Request()->branch_id);
        }
        if (Request()->cost_center) {
            $query->where('cost_center', Request()->cost_center);
        }





        if (Request()->account && Request()->account != 0) {
            $accountId = AccountTree::where('account_code', Request()->account)->first()->id;
            $accountCodes = $this->getAllChildAccounts($accountId);
            $query->where(function ($q) use ($accountCodes) {
                $q->whereIn('debit_account_number', $accountCodes)
                    ->orWhereIn('credit_account_number', $accountCodes);
            });
        }

        if (Request()->search) {
            $query->where('number', Request()->search);
        }
        if (Request()->journal_type_id && Request()->journal_type_id != 0) {
            $query->where('journal_type_id', Request()->journal_type_id);
        }

        if (!Request()->search || !Request()->journal_type_id) {
            $query->whereBetween('transaction_date', [$from, $to]);
        }

        if (Request()->final_accounts && Request()->final_accounts != 0) {

            $accountIds = AccountTree::where('account_final', Request()->final_accounts)->pluck('id');
            foreach ($accountIds as $accountId) {
                $accountCodes = $this->getAllChildAccounts($accountId);
                $query->where(function ($q) use ($accountCodes) {
                    $q->whereIn('debit_account_number', $accountCodes)
                        ->orWhereIn('credit_account_number', $accountCodes);
                });
            }
        }

        // $data['journals'] = $query->orderBy('id', 'desc')->groupBy('number')->pluck('number');
        $data['entries'] = $query->orderBy('id', 'desc')->get();

        $query_total = AccountingEntries::query();
        $total_q = (clone $query_total)->whereBetween('transaction_date', [$from, $to]);
        $last_balance_q = (clone $query_total)->where('transaction_date', '<', $from);

        if (Request()->branch_id) {
            $total_q->where('branch_id', Request()->branch_id);
            $last_balance_q->where('branch_id', Request()->branch_id);
        }
        if (Request()->cost_center) {
            $total_q->where('cost_center', Request()->cost_center);
            $last_balance_q->where('cost_center', Request()->cost_center);
        }



        if (Request()->account && Request()->account != 0) {
            $accountId = AccountTree::where('account_code', Request()->account)->first()->id;
            $accountCodes = $this->getAllChildAccounts($accountId);
            $total_q->where(function ($q) use ($accountCodes) {
                $q->whereIn('debit_account_number', $accountCodes)
                    ->orWhereIn('credit_account_number', $accountCodes);
            });
            $last_balance_q->where(function ($q) use ($accountCodes) {
                $q->whereIn('debit_account_number', $accountCodes)
                    ->orWhereIn('credit_account_number', $accountCodes);
            });
        }

        if (Request()->search) {
            $total_q->where('number', Request()->search);
            $last_balance_q->where('number', Request()->search);
        }

        $entries_total = $total_q->get();
        $entries_total_last_balance = $last_balance_q->get();

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
        $account_totals_last_balance = $entries_total_last_balance->groupBy('debit_account_number')->map(function ($entries_total_last_balance, $accountNumber) {
            $total_debit = $entries_total_last_balance->sum('amount_debit');
            $total_credit = $entries_total_last_balance->sum('amount_credit');
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

        $total_sums_last_balance = $account_totals_last_balance->reduce(function ($carry, $item) {
            $carry['total_debit'] += $item['total_debit'];
            $carry['total_credit'] += $item['total_credit'];
            $carry['total_balance'] += $item['balance'];
            return $carry;
        }, ['total_debit' => 0, 'total_credit' => 0, 'total_balance' => 0]);

        $total_debit = round($total_sums['total_debit'], 2);
        $total_credit = round($total_sums['total_credit'], 2);
        $total_balance = round($total_sums['total_balance'], 2);

        $total_debit_last_balance = round($total_sums_last_balance['total_debit'], 2);
        $total_credit_last_balance = round($total_sums_last_balance['total_credit'], 2);
        $total_balance_last_balance = round($total_sums_last_balance['total_balance'], 2);

        $data['totals'] = [
            'account_totals' => $account_totals,
            'total_debit' => round($total_debit, 2),
            'total_credit' => round($total_credit, 2),
            'total_balance' => round($total_balance, 2),
            'total_last_balande' => round($total_balance_last_balance)
        ];



        if (Request()->action == 'export') {
            return Excel::download(new JournalsExport, 'journals_' . $from . 'to' . $to . '.xlsx');
        }

        return view('admin.transactions.vouchers.journals', $data);
    }



    public function getAllChildAccounts($accountId)
    {
        $account = AccountTree::with('allChildrenAccounts')->find($accountId);
        $allChildAccounts = $this->extractChildAccounts($account);
        return $allChildAccounts;
    }

    private function extractChildAccounts($account)
    {
        $childAccounts = collect([$account->account_code]);
        foreach ($account->childrenAccounts as $child) {
            $childAccounts = $childAccounts->merge($this->extractChildAccounts($child));
        }
        return $childAccounts;
    }




    //ميزان المراجعة
    public function balance_review()
    {

        $data['accounts'] = [];
        $data['report_sources'] = JounalType::select('id', 'name')->get();
        $data['show_options'] = [
            '0' => ['id' => '0', 'name' => 'basic - حساب رئيسي'],
            '1' => ['id' => '1', 'name' => 'secondary - حساب فرعي'],
        ];


        if (Request()->action == "search") {
            $query = AccountTree::query();

            if (request()->show_options) {
                $query->whereIn('account_type', Request()->show_options);
            }
            $data['accounts_entries'] = array();
            $data['accounts'] = $query->get('account_code')->map(function ($q) {

                $query_cd = AccountingEntries::query();

                if (Request()->report_sources) {
                    $query_cd->whrereIn('journal_type_id', Request()->report_sources);
                }

                $total_debit = (clone $query_cd)
                    ->where('debit_account_number', $q)
                    ->sum('amount_debit');

                $total_credit = (clone $query_cd)
                    ->where('credit_account_number', $q)
                    ->sum('amount_credit');

                if (($total_credit != 0) && ($total_credit != 0)) {
                    return [
                        'account_code' => $q->account_code,
                        'account_name' => AccountTree::where('account_code', $q->account_code)->first()->account_name ?? '-',
                        'total_debit' => $total_debit,
                        'total_credit' => $total_credit,
                        'balance' => $total_debit - $total_credit,
                    ];
                }
            });
        }



        return view('admin.transactions.vouchers.balance_review', $data);
    }




    //سند يومية
    public function journalVoucher()
    {
        $data['accounts'] = AccountTree::get();
        $data['cars'] = CarPLate::select('id', 'car_name', 'car_plate')->get();

        $number = 10000001;


        $lastNumber = AccountingEntries::where('journal_type_id', 1)
            ->select('number', 'journal_type_id')
            ->latest()
            ->first();

        if ($lastNumber) {
            $number = $lastNumber->number + 1;
        } else {
            $number = $number;
        }

        $data['number'] = $number;

        $data['branchs'] = Branches::where('is_main', 0)->select('branch_name', 'id')->get();
        return view('admin.transactions.vouchers.journal_voucher', $data);
    }

    public function storeJournalVoucher(Request $request)
    {
        return $request;
        // return $request;
        // تحديد رقم القيد الافتراضي
        $voucher_nmber = 10000001;

        // الحصول على أحدث قيد في الدفتر لتحديد الرقم التالي
        $account = AccountingEntries::where('journal_type_id', 1)
            ->select('number', 'journal_type_id')
            ->latest()
            ->first();
        if ($account) {
            $voucher_nmber = $account->number + 1;
        }

        // التحقق من صحة البيانات المدخلة في الريكويست
        $validatedData = $request->validate([
            'account_id.*' => 'required|exists:account_trees,id',
            'credit.*' => 'nullable|numeric',
            'debit.*' => 'nullable|numeric',
            'statment.*' => 'nullable|string',
            'branch_id.*' => 'nullable|exists:branches,id',
            'cost_center.*' => 'nullable|exists:car_p_lates,id',
            'date' => 'required|date',
        ]);

        // التعامل مع كل سطر من الريكويست بشكل ديناميكي
        foreach ($request->account_id as $key => $account_id) {

            // التحقق من وجود قيمة للمدين أو الدائن
            $isCredit = !empty($request->credit[$key]);
            $isDebit = !empty($request->debit[$key]);

            // الحصول على معلومات الحساب
            $account = AccountTree::findOrFail($account_id);

            // إنشاء السطر الأول (مدين)
            if ($isDebit) {
                ShipmentHelper::accounting_entries(
                    $debit_account_number = $account->account_code,
                    $debit_account_name = [
                        'ar' => $account->getTranslation('account_name', 'ar'),
                        'en' => $account->getTranslation('account_name', 'en')
                    ],
                    $credit_account_number = null,
                    $credit_account_name = null,
                    $statment = $request->statment[$key] ?? null,
                    $amount_debit = $request->debit[$key],
                    $amount_credit = null,
                    $voucher_nmber,
                    $payment = null,
                    $shipment = !empty($request->shipment_refrence[$key]) ?
                        Shipment::where('shipment_refrence', $request->shipment_refrence[$key])
                        ->orderBy('updated_at', 'desc')
                        ->first() : null,
                    $cost_center = $request->cost_center[$key] ?? null,
                    $guard = 'admin',
                    $compound_entry_with = null,
                    $journal_type_id = 1, // daily
                    $request->branch_id[$key] ?? null,
                    $request->statment_for_journal ?? null,
                    Carbon::parse($request->date)->format('Y-m-d')
                );
            }

            // إنشاء السطر الثاني (دائن)
            if ($isCredit) {
                ShipmentHelper::accounting_entries(
                    $debit_account_number = null,
                    $debit_account_name = null,
                    $credit_account_number = $account->account_code,
                    $credit_account_name = [
                        'ar' => $account->getTranslation('account_name', 'ar'),
                        'en' => $account->getTranslation('account_name', 'en')
                    ],
                    $statment = $request->statment[$key] ?? null,
                    $amount_debit = null,
                    $amount_credit = $request->credit[$key],
                    $voucher_nmber,
                    $payment = null,
                    $shipment = !empty($request->shipment_refrence[$key]) ?
                        Shipment::where('shipment_refrence', $request->shipment_refrence[$key])
                        ->orderBy('updated_at', 'desc')
                        ->first() : null,
                    $cost_center = $request->cost_center[$key] ?? null,
                    $guard = 'admin',
                    $compound_entry_with = null,
                    $journal_type_id = 1, // daily
                    $request->branch_id[$key] ?? null,
                    $request->statment_for_journal ?? null,
                    Carbon::parse($request->date)->format('Y-m-d')
                );
            }
        }

        toastr()->success(__('admin.msg_success_add'));
        if ($request->save_type == 'save_print') {
            return redirect()->route('admin.account.print_journal_voucher', $voucher_nmber);
        } else {
            return redirect()->back();
        }
    }

    public function editJournalVoucher(Request $request)
    {
        $data['accounts'] = AccountTree::get();
        $data['cars'] = CarPLate::select('id', 'car_name', 'car_plate')->get();
        $data['journals'] = AccountingEntries::where('journal_type_id', 1)->where('number', $request->number)->get();
        $data['branchs'] = Branches::where('is_main', 0)->select('branch_name', 'id')->get();

        if ($data['journals'] && count($data['journals']) > 0) {
            $data['number'] = $data['journals'][0]->number;
        } else {
            $number = 10000001;


            $lastNumber = AccountingEntries::where('journal_type_id', 1)
                ->select('number', 'journal_type_id')
                ->latest()
                ->first();

            if ($lastNumber) {
                $number = $lastNumber->number + 1;
            } else {
                $number = $number;
            }

            $data['number'] = $number;

            return redirect()->route('admin.account.journal_voucher', $data);
        }
        return view('admin.transactions.vouchers.edit_journal_voucher', $data);
    }

    public function updateJournalVoucher(Request $request)
    {
        $validatedData = $request->validate([
            'account_id.*' => 'required|exists:account_trees,id',
            'credit.*' => 'nullable|numeric',
            'debit.*' => 'nullable|numeric',
            'statment.*' => 'nullable|string',
            'branch_id.*' => 'nullable|exists:branches,id',
            'cost_center.*' => 'nullable|exists:car_p_lates,id',
            'date' => 'required|date',
        ]);

        $currentVoucherEntries = AccountingEntries::where('number', $request->number)->get();
        $currentEntriesIds = $currentVoucherEntries->pluck('id')->toArray();
        $updatedEntriesIds = [];

        foreach ($request->account_id as $key => $account_id) {
            $isCredit = !empty($request->credit[$key]);
            $isDebit = !empty($request->debit[$key]);

            $account = AccountTree::findOrFail($account_id);

            if (isset($request->entry_id[$key])) {
                $entry = AccountingEntries::findOrFail($request->entry_id[$key]);
                $entry->update([
                    'debit_account_number' => $isDebit ? $account->account_code : null,
                    'debit_account_name' => $isDebit ? $account->getTranslation('account_name', 'ar') : null,
                    'credit_account_number' => $isCredit ? $account->account_code : null,
                    'credit_account_name' => $isCredit ? $account->getTranslation('account_name', 'ar') : null,
                    'statment' => $request->statment[$key] ?? null,
                    'amount_debit' => $isDebit ? $request->debit[$key] : null,
                    'amount_credit' => $isCredit ? $request->credit[$key] : null,
                    'cost_center' => $request->cost_center[$key] ?? null,
                    'branch_id' => $request->branch_id[$key] ?? null,
                    'transaction_date' => Carbon::parse($request->date)->format('Y-m-d'),
                    'statment_for_journal'=>$request->statment_for_journal
                ]);
                $updatedEntriesIds[] = $entry->id;
            } else {
                $newEntry = AccountingEntries::create([
                    'debit_account_number' => $isDebit ? $account->account_code : null,
                    'debit_account_name' => $isDebit ? $account->getTranslation('account_name', 'ar') : null,
                    'credit_account_number' => $isCredit ? $account->account_code : null,
                    'credit_account_name' => $isCredit ? $account->getTranslation('account_name', 'ar') : null,
                    'statment' => $request->statment[$key] ?? null,
                    'amount_debit' => $isDebit ? $request->debit[$key] : null,
                    'amount_credit' => $isCredit ? $request->credit[$key] : null,
                    'number' => $request->number, //
                    'journal_type_id' => 1, // daily
                    'cost_center' => $request->cost_center[$key] ?? null,
                    'branch_id' => $request->branch_id[$key] ?? null,
                    'transaction_date' => Carbon::parse($request->date)->format('Y-m-d'),
                    'created_by' => Auth::guard('admin')->user()->name,
                    'statment_for_journal'=>$request->statment_for_journal
                ]);
                $updatedEntriesIds[] = $newEntry->id;
            }
        }

        $entriesToDelete = array_diff($currentEntriesIds, $updatedEntriesIds);
        AccountingEntries::whereIn('id', $entriesToDelete)->delete();

        toastr()->success(__('admin.msg_success_update'));
        return redirect()->back();
    }

    public function printJournalVoucher($number)
    {
        $data['journals'] = AccountingEntries::where('number', $number)->where('journal_type_id', 1)->get();

        return view('admin.transactions.vouchers.print_journal_voucher', $data);
    }


    public function reciptVoucher()
    {
        $data['accounts'] = AccountTree::get();
        $data['cars'] = CarPLate::select('id', 'car_name', 'car_plate')->get();

        $number = 10000001;


        $lastNumber = AccountingEntries::where('journal_type_id', 2)
            ->select('number', 'journal_type_id')
            ->latest()
            ->first();

        if ($lastNumber) {
            $number = $lastNumber->number + 1;
        } else {
            $number = $number;
        }

        $data['number'] = $number;


        return view('admin.transactions.vouchers.recipt_voucher', $data);
    }

    public function storeReciptVoucher(Request $request)
    {
        $voucher_nmber = 10000001;

        $account = AccountingEntries::where('journal_type_id', 2)->select('number', 'journal_type_id')->latest()->first();
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
                $journal_type_id = 2, // recipt
                Null,
                Null,
                $request->date
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
                $journal_type_id = 2, // recipt
                Null,
                Null,
                $request->date
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
                $journal_type_id = 2, // recipt
                Null,
                Null,
                $request->date
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
                $journal_type_id = 2, // recipt
                Null,
                Null,
                $request->date
            );
        }





        toastr()->success(__('admin.msg_success_add'));
        if ($request->save_type == 'save_print') {
            return redirect()->route('admin.account.print_recipt_voucher', $voucher_nmber);
        } else {
            return redirect()->back();
        }
    }

    public function printReciptVoucher($number)
    {
        $data['vouchers'] = AccountingEntries::where('number', $number)->where('journal_type_id', 2)->get();
        $data['credit_amount'] = abs($data['vouchers'][0]['amount_credit'] - $data['vouchers'][1]['amount_credit']); // send credit amount or debit amount to numberToWord Function
        // $data['debit_amount'] = abs($data['vouchers'][0]['amount_debit'] - $data['vouchers'][1]['amount_debit']);  // send credit amount or debit amount to numberToWord Function

        $data['voucher'] = null;
        if ($data['vouchers'][0]['credit_account_number'] != 0) {
            $data['voucher'] = $data['vouchers'][0];
            $data['account'] = AccountTree::where('account_code', $data['vouchers'][0]['credit_account_number'])->first();
        } else {
            $data['voucher'] =  $data['vouchers'][1];
            $data['account'] = AccountTree::where('account_code', $data['vouchers'][1]['credit_account_number'])->first();
        }

        $data['credit_en'] = $this->numberToWordEn($data['credit_amount']);
        $data['credit_ar'] = $this->numberToWordAr($data['credit_amount']);
        return view('admin.transactions.vouchers.print_recipt_voucher', $data);
    }

    public function editReciptVoucher(Request $request)
    {
        $data['accounts'] = AccountTree::get();
        $data['cars'] = CarPLate::select('id', 'car_name', 'car_plate')->get();
        $data['journals'] = AccountingEntries::where('journal_type_id', 2)->where('number', $request->number)->get();

        if ($data['journals'] && count($data['journals']) > 0) {
            $data['number'] = $data['journals'][0]->number;
        } else {
            $number = 10000001;


            $lastNumber = AccountingEntries::where('journal_type_id', 2)
                ->select('number', 'journal_type_id')
                ->latest()
                ->first();

            if ($lastNumber) {
                $number = $lastNumber->number + 1;
            } else {
                $number = $number;
            }

            $data['number'] = $number;
            return redirect()->route('admin.account.recipt_voucher', $data);
        }
        return view('admin.transactions.vouchers.edit_recipt_voucher', $data);
    }

    public function paymentVoucher()
    {
        $data['accounts'] = AccountTree::get();
        $data['cars'] = CarPLate::select('id', 'car_name', 'car_plate')->get();

        $number = 10000001;


        $lastNumber = AccountingEntries::where('journal_type_id', 3)
            ->select('number', 'journal_type_id')
            ->latest()
            ->first();

        if ($lastNumber) {
            $number = $lastNumber->number + 1;
        } else {
            $number = $number;
        }

        $data['number'] = $number;


        return view('admin.transactions.vouchers.payment_voucher', $data);
    }



    public function editPaymentVoucher(Request $request)
    {
        $data['accounts'] = AccountTree::get();
        $data['cars'] = CarPLate::select('id', 'car_name', 'car_plate')->get();
        $data['journals'] = AccountingEntries::where('journal_type_id', 3)->where('number', $request->number)->get();

        if ($data['journals'] && count($data['journals']) > 0) {
            $data['number'] = $data['journals'][0]->number;
        } else {
            $number = 10000001;


            $lastNumber = AccountingEntries::where('journal_type_id', 3)
                ->select('number', 'journal_type_id')
                ->latest()
                ->first();

            if ($lastNumber) {
                $number = $lastNumber->number + 1;
            } else {
                $number = $number;
            }

            $data['number'] = $number;
            return redirect()->route('admin.account.payment_voucher', $data);
        }
        return view('admin.transactions.vouchers.edit_payment_voucher', $data);
    }



    public function storePaymentVoucher(Request $request)
    {
        $voucher_nmber = 10000001;

        $account = AccountingEntries::where('journal_type_id', 3)->select('number', 'journal_type_id')->latest()->first();
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
                $cost_center = $request->cost_center ? $request->cost_center : null,
                $guard = 'admin',
                $compound_entry_with = Null,
                $journal_type_id = 3, // payment
                $brnach_id = $request->in_branch ? $request->in_branch : null,
                Null,
                $request->date
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
                $cost_center = $request->cost_center ? $request->cost_center : null,
                $guard = 'admin',
                $compound_entry_with = Null,
                $journal_type_id = 3, // payment
                $brnach_id = $request->in_branch ? $request->in_branch : null,
                null,
                $request->date
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
                $cost_center = $request->cost_center ? $request->cost_center : null,
                $guard = 'admin',
                $compound_entry_with = Null,
                $journal_type_id = 3, // payment
                $brnach_id = $request->in_branch ? $request->in_branch : null,
                null,
                $request->date
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
                $cost_center = $request->cost_center ? $request->cost_center : null,
                $guard = 'admin',
                $compound_entry_with = Null,
                $journal_type_id = 3, // payment
                $brnach_id = $request->in_branch ? $request->in_branch : null,
                null,
                $request->date
            );
        }


        toastr()->success(__('admin.msg_success_add'));
        if ($request->save_type == 'save_print') {
            return redirect()->route('admin.account.print_payment_voucher', $voucher_nmber);
        } else {
            return redirect()->back();
        }
    }

    public function printPaymentVoucher($number)
    {
        $data['vouchers'] = AccountingEntries::where('number', $number)->where('journal_type_id', 3)->get();
        // $data['credit_amount'] = abs($data['vouchers'][0]['amount_credit'] - $data['vouchers'][1]['amount_credit']); // send credit amount or debit amount to numberToWord Function
        $data['debit_amount'] = abs($data['vouchers'][0]['amount_debit'] - $data['vouchers'][1]['amount_debit']);  // send credit amount or credit amount to numberToWord Function

        $data['voucher'] = null;
        if ($data['vouchers'][0]['debit_account_number'] != 0) {
            $data['voucher'] = $data['vouchers'][0];
            $data['account'] = AccountTree::where('account_code', $data['vouchers'][0]['debit_account_number'])->first();
        } else {
            $data['voucher'] =  $data['vouchers'][1];
            $data['account'] = AccountTree::where('account_code', $data['vouchers'][1]['debit_account_number'])->first();
        }

        $data['debit_en'] = $this->numberToWordEn($data['debit_amount']);
        $data['debit_ar'] = $this->numberToWordAr($data['debit_amount']);

        return view('admin.transactions.vouchers.print_payment_voucher', $data);
    }

    public function updatePaymentVoucher(Request $request)
    {
        // الحصول على المعرفات من الطلب
        $ids = $request->id;
        $accounts = $request->account_id;
        $credits = $request->credit;
        $debits = $request->debit;

        // جمع كل بيانات الحسابات المطلوبة في استعلام واحد
        $accountIds = array_unique(array_merge($accounts)); // دمج جميع المعرفات الفريدة
        $accountData = AccountTree::whereIn('id', $accountIds)->get()->keyBy('id');

        foreach ($ids as $key => $id) {
            // التحقق من وجود الحساب بناءً على المعرف
            $accountId = $accounts[$key] ?? null;
            $account = $accountId ? $accountData->get($accountId) : null;

            // إعداد البيانات للتحديث
            $updateData = [
                'number' => $request->number,
                'statment' => $request->statment,
                'amount_debit' => $debits[$key] ?? null,
                'amount_credit' => $credits[$key] ?? null,
                'transaction_date' => Carbon::parse($request->date)->format('Y-m-d'),
                'journal_type_id' => 3,
                'updated_by' => Auth::guard('admin')->user()->name,
                'cost_center' => $request->cost_center,
                'statment_for_journal' => $request->statment,
            ];

            // تعيين معلومات الحساب في حالة وجودها
            if ($debits[$key] !== null && $account) {
                $updateData['debit_account_number'] = $account->account_code;
                $updateData['debit_account_name'] = $account->account_name;
            } else {
                $updateData['debit_account_number'] = null;
                $updateData['debit_account_name'] = null;
            }

            if ($credits[$key] !== null && $account) {
                $updateData['credit_account_number'] = $account->account_code;
                $updateData['credit_account_name'] = $account->account_name;
            } else {
                $updateData['credit_account_number'] = null;
                $updateData['credit_account_name'] = null;
            }

            // تنفيذ التحديث
            AccountingEntries::where('id', $id)->update($updateData);
        }

        // عرض رسالة النجاح
        toastr()->success(__('admin.msg_success_update'));
        return redirect()->back();
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
        $num = (string) ((int) $num);

        if ((int) $num && ctype_digit($num)) {
            $words = array();

            $num = str_replace(array(',', ' '), '', trim($num));

            $list1 = array(
                '',
                'واحد',
                'اثنان',
                'ثلاثة',
                'أربعة',
                'خمسة',
                'ستة',
                'سبعة',
                'ثمانية',
                'تسعة',
                'عشرة',
                'أحد عشر',
                'اثنا عشر',
                'ثلاثة عشر',
                'أربعة عشر',
                'خمسة عشر',
                'ستة عشر',
                'سبعة عشر',
                'ثمانية عشر',
                'تسعة عشر'
            );

            $list2 = array(
                '',
                'عشرة',
                'عشرون',
                'ثلاثون',
                'أربعون',
                'خمسون',
                'ستون',
                'سبعون',
                'ثمانون',
                'تسعون'
            );

            $list3 = array(
                '',
                'ألف',
                'مليون',
                'مليار',
                'تريليون',
                'كوادرليون',
                'كوينتليون',
                'سكستيليون',
                'سبتيليون',
                'أوكتليون',
                'نونليون',
                'ديكيليون',
                'أنديسيليون',
                'دوديسيليون',
                'تريديسيليون',
                'كوادروديكيليون',
                'كوينديكيليون',
                'سكستي ديكيليون',
                'سبتي ديكيليون',
                'أوكتو ديكيليون',
                'نوفيم ديكيليون',
                'فيجينتيليون'
            );

            $num_length = strlen($num);
            $levels = (int) (($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);

            foreach ($num_levels as $num_part) {
                $levels--;
                $hundreds = (int) ($num_part / 100);
                if ($hundreds == 1) {
                    $hundreds = " .مائة";
                } else if ($hundreds == 2) {
                    $hundreds = "مئتان";
                } else if ($hundreds > 1) {
                    $hundreds = " " . $list1[$hundreds] . " .مائة";
                } else {
                    $hundreds = "";
                }

                $tens = (int) ($num_part % 100);
                $singles = '';

                if ($tens < 20) {
                    $tens = ($tens ? ' ' . $list1[$tens] : '');
                } else {
                    $tens = (int) ($tens / 10);
                    $tens = ' ' . $list2[$tens];
                    $singles = (int) ($num_part % 10);
                    $singles = ' ' . $list1[$singles];
                }

                // دمج الأجزاء
                $parts = array_filter([$hundreds, $tens, $singles]);
                $word_part = implode(' و', $parts);

                $words[] = $word_part . (($levels && (int) ($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
            }

            // دمج الأجزاء النهائية
            $words = implode(' و', array_filter($words));
            $words = trim($words, ' و');

            return $words;
        } else if (!((int) $num)) {
            return 'صفر';
        }
        return '';
    }



    public function numberToWordEn($num = '')
    {
        $num = (string) ((int) $num);

        if ((int) $num && ctype_digit($num)) {
            $words = array();

            $num = str_replace(array(',', ' '), '', trim($num));

            $list1 = array(
                '',
                'one',
                'two',
                'three',
                'four',
                'five',
                'six',
                'seven',
                'eight',
                'nine',
                'ten',
                'eleven',
                'twelve',
                'thirteen',
                'fourteen',
                'fifteen',
                'sixteen',
                'seventeen',
                'eighteen',
                'nineteen'
            );

            $list2 = array(
                '',
                'ten',
                'twenty',
                'thirty',
                'forty',
                'fifty',
                'sixty',
                'seventy',
                'eighty',
                'ninety'
            );

            $list3 = array(
                '',
                'thousand',
                'million',
                'billion',
                'trillion',
                'quadrillion',
                'quintillion',
                'sextillion',
                'septillion',
                'octillion',
                'nonillion',
                'decillion',
                'undecillion',
                'duodecillion',
                'tredecillion',
                'quattuordecillion',
                'quindecillion',
                'sexdecillion',
                'septendecillion',
                'octodecillion',
                'novemdecillion',
                'vigintillion'
            );

            $num_length = strlen($num);
            $levels = (int) (($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);

            foreach ($num_levels as $num_part) {
                $levels--;
                $hundreds = (int) ($num_part / 100);
                $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred ' : '');
                $tens = (int) ($num_part % 100);
                $singles = '';

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

            $words = implode(' and', array_filter($words));
            $words = trim($words);

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

    public function post_voucher(Request $request)
    {


        $entries = AccountingEntries::where('number', $request->number)
            ->where('journal_type_id', $request->type)
            ->get();

        if ($entries->isNotEmpty()) {
            $entries->each(function ($entry) use ($request) {
                $entry->update(['is_posted' => $request->post_value, 'updated_by' => Auth::guard('admin')->user()->name]);
            });

            toastr()->success('change successfully');
        } else {
            toastr()->warning('No entries found');
        }

        return redirect()->back();
    }


    public function cacl()
    {
        $data['accounts_tree'] = AccountTree::select('id', 'account_name', 'account_code')->get();
        return view('admin.transactions.vouchers.make_calc.calc', $data);
    }
    public function calculate(Request $request)
    {
        $data['accounts_tree'] = AccountTree::select('id', 'account_name', 'account_code')->get();
        $accounts = $request->input('accounts');
        // return $request;
        $numbers = array();
        $operations = $request->input('operations');

        if ($accounts) {
            foreach ($accounts as $account) {
                $query_total = AccountingEntries::query();
                $last_balance_q = (clone $query_total);
                if ($account) {
                    $accountId = AccountTree::where('account_code', $account)->first()->id;
                    $accountCodes = $this->getAllChildAccounts($accountId);

                    $last_balance_q->where(function ($q) use ($accountCodes) {
                        $q->whereIn('debit_account_number', $accountCodes)
                            ->orWhereIn('credit_account_number', $accountCodes);
                    });
                }
                $entries_total_last_balance = $last_balance_q->get();
                $account_totals_last_balance = $entries_total_last_balance->groupBy('debit_account_number')->map(function ($entries_total_last_balance, $accountNumber) {
                    $total_debit = $entries_total_last_balance->sum('amount_debit');
                    $total_credit = $entries_total_last_balance->sum('amount_credit');
                    return [
                        'account_number' => $accountNumber,
                        'total_debit' => $total_debit,
                        'total_credit' => $total_credit,
                        'balance' => $total_debit - $total_credit,
                    ];
                });
                $total_sums_last_balance = $account_totals_last_balance->reduce(function ($carry, $item) {
                    $carry['total_debit'] += $item['total_debit'];
                    $carry['total_credit'] += $item['total_credit'];
                    $carry['total_balance'] += $item['balance'];
                    return $carry;
                }, ['total_debit' => 0, 'total_credit' => 0, 'total_balance' => 0]);
                $numbers[] =  abs(round($total_sums_last_balance['total_balance'], 2));
            }
        }

        // ابدأ بالرقم الأول
        $data['result'] = $numbers[0];
        // dd($numbers);
        // تنفيذ العمليات بناءً على المدخلات
        for ($i = 1; $i < count($numbers); $i++) {
            switch ($operations[$i - 1]) {
                case '+':
                    $data['result'] += $numbers[$i];
                    break;
                case '-':
                    $data['result'] -= $numbers[$i];
                    break;
                case '*':
                    $data['result'] *= $numbers[$i];
                    break;
                case '/':
                    if ($numbers[$i] != 0) {
                        $data['result'] /= $numbers[$i];
                    } else {
                        return view('calculate', ['result' => 'Division by zero error']);
                    }
                    break;
                default:
                    return view('calculate', ['result' => 'Invalid Operation']);
            }
        }


        return view('admin.transactions.vouchers.make_calc.calc', $data);
    }

    public function delete(Request $request){
        $vouchers = AccountingEntries::where('number',$request->number)->where('journal_type_id',$request->type)->get();
        if($vouchers && count($vouchers) > 0){
            foreach($vouchers as $voucher){
                $voucher->delete();
            }
        }
        toastr()->success(__('admin.msg_success_delete'));
        return redirect()->back();
    }
}
