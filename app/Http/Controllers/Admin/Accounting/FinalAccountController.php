<?php

namespace App\Http\Controllers\Admin\Accounting;

use PDO;
use Carbon\Carbon;
use App\Models\Branches;
use App\Models\CarPLate;
use App\Models\AccountTree;
use Illuminate\Http\Request;
use App\Exports\JournalsExport;
use App\Models\AccountingEntries;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class FinalAccountController extends Controller
{
    public function getAccountReport(Request $request)
    {
        if ($request->action == "search") {
            $data['from'] = $request->from ? Carbon::parse($request->from)->format('Y-m-d') : Carbon::now()->format('Y-m-d');
            $data['to'] = $request->to ? Carbon::parse($request->to)->format('Y-m-d') : Carbon::now()->format('Y-m-d');
    
            $accountFinalType = $request->input('account_final_type');
            $level = $request->input('level');
    
            $accountTreesQuery = AccountTree::query()->orderBy('account_parent','asc');
    
            if ($level) {
                $accountTreesQuery->where('account_level', '>=', $level);
            }
    
            if ($accountFinalType == 1) {
                $accountTreesQuery->where('account_final', 1);
            } elseif ($accountFinalType == 2) {
                $accountTreesQuery->where('account_final', 2);
            }
    
            $accountTrees = $accountTreesQuery->get();
    
            // جمع المدين والدائن لكل حساب
            $debitEntries = DB::table('accounting_entries')
                ->whereBetween('transaction_date', [$data['from'], $data['to']])
                ->select('debit_account_number as account_number', DB::raw('SUM(amount_debit) as total_debit'))
                ->groupBy('debit_account_number')
                ->pluck('total_debit', 'account_number');
    
            $creditEntries = DB::table('accounting_entries')
                ->whereBetween('transaction_date', [$data['from'], $data['to']])
                ->select('credit_account_number as account_number', DB::raw('SUM(amount_credit) as total_credit'))
                ->groupBy('credit_account_number')
                ->pluck('total_credit', 'account_number');
    
            // معالجة الحسابات الأبناء وجمعهم
            $data['accounts'] = $accountTrees->map(function ($accountTree) use ($debitEntries, $creditEntries) {
                $accountNumber = $accountTree->account_code;
    
                // جمع مجموع الأبناء بشكل تراكمي
                $totals = $this->calculateAccountTotals($accountTree, $debitEntries, $creditEntries);
    
                // جمع المدين والدائن للحساب الرئيسي والأبناء
                $totalDebit = ($debitEntries[$accountNumber] ?? 0) + $totals['children_debit_sum'];
                $totalCredit = ($creditEntries[$accountNumber] ?? 0) + $totals['children_credit_sum'];
    
                return [
                    'account_name' => $accountTree->account_name,
                    'account_number' => $accountNumber,
                    'total_debit' => $totalDebit,
                    'total_credit' => $totalCredit,
                    // 'children_debit_sum' => $totals['children_debit_sum'], // مجموع الأبناء المدين
                    // 'children_credit_sum' => $totals['children_credit_sum'], // مجموع الأبناء الدائن
                    'has_children' => $accountTree->childrenAccounts()->exists(),
                ];
            });
    
            $data['total_debit'] = $data['accounts']->sum('total_debit');
            $data['total_credit'] = $data['accounts']->sum('total_credit');
    
            // حساب الربح أو الخسارة
            $data['profit_losses'] = '';
            if ($request->account_final_type && $request->account_final_type == 1) {
                if ($data['total_debit'] > $data['total_credit']) {
                    $data['profit_losses'] = "<span class='text-danger'>" . __('admin.losses') . "</span>";
                } elseif ($data['total_debit'] < $data['total_credit']) {
                    $data['profit_losses'] = "<span class='text-success'>" . __('admin.profit') . "</span>";
                } else {
                    $data['profit_losses'] = "<span class='text-dark'>" . __('admin.draw') . "</span>";
                }
            }
    
            if ($request->account_final_type && $request->account_final_type == 2) {
                // معالجة إضافية إذا لزم الأمر
            }
    
            return view('admin.transactions.final_accounts.report', $data);
        } else {
            $data = [];
            $data['accounts'] = [];
            return view('admin.transactions.final_accounts.report', $data);
        }
    }
    
    private function calculateAccountTotals($accountTree, $debitEntries, $creditEntries)
    {
        // جمع مجموع المدين والدائن للأبناء بشكل تراكمي
        $childrenDebitSum = $accountTree->childrenAccounts->reduce(function ($carry, $child) use ($debitEntries, $creditEntries) {
            $totals = $this->calculateAccountTotals($child, $debitEntries, $creditEntries);
            $childDebit = $debitEntries[$child->account_code] ?? 0;
            return $carry + $childDebit + $totals['children_debit_sum'];
        }, 0);
    
        $childrenCreditSum = $accountTree->childrenAccounts->reduce(function ($carry, $child) use ($debitEntries, $creditEntries) {
            $totals = $this->calculateAccountTotals($child, $debitEntries, $creditEntries);
            $childCredit = $creditEntries[$child->account_code] ?? 0;
            return $carry + $childCredit + $totals['children_credit_sum'];
        }, 0);
    
        return [
            'children_debit_sum' => $childrenDebitSum,
            'children_credit_sum' => $childrenCreditSum,
        ];
    }
    
}
