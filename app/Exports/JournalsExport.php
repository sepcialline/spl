<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Branches;
use App\Models\CarPLate;
use App\Models\AccountTree;
use App\Models\AccountingEntries;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Http\Controllers\Admin\Accounting\AccountTreeController;

class JournalsExport implements FromView
{
    public function view(): View
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


        return view('exports.reports.journals', [
            'entries' => $data['entries'],
            'total_credit' => $data['totals']['total_credit'],
            'total_debit' => $data['totals']['total_debit'],
            'total_balance' => $data['totals']['total_balance'],
            'account_totals' => $account_totals,
            'total_last_balande' => round($total_balance_last_balance)
        ]);
    }
}
