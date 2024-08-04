<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\AccountTree;
use App\Models\AccountingEntries;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class JournalsExport implements FromView
{
    public function view(): View
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
        $data['entries'] = $query->orderBy('id', 'desc')->get();



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



        return view('exports.reports.journals', [
            'entries' => $data['entries'],
            'total_credit' => $data['totals']['total_credit'],
            'total_debit' => $data['totals']['total_debit'],
            'total_balance' => $data['totals']['total_balance'],
        ]);
    }
}
