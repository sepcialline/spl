<?php

namespace App\Http\Controllers\Employee\Expenses;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpensesController extends Controller
{

    function __construct()
    {
        // $this->middleware(['permission:employee-Expense-show-page,employee'], ['only' => ['index']]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $expenses = Expense::get();
        $data = array();
        foreach ($expenses as $expense) {
            $exp = Expense::where('id', $expense->id)->first();
            if ($exp->rider?->branch_id == Auth::guard('employee')->user()->branch_id) {
                $data[] = $exp;
            }
        }
        return view('employee.expenses.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
