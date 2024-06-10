<?php

namespace App\Http\Controllers\API\Expenses;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Expense::where('rider_id', Auth::id())->with('rider')->with('expense')->with('plate')->with('paymentType')
        ->wheredate('date',Carbon::now()->format('Y-m-d'))->get();
        $message = ['success' => 0, 'message' => 'Success'];
        return response(compact('data', 'message'), 200);
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
        $expense = new Expense();

        try {
            //code...
            if ($request->hasFile('file')) {
                $img = $request->file != null ? time() . '_' . $request->file->getClientOriginalName() : $request->logo_en;
                //$data->	logo_en=$img;
                $request->file->move(public_path('build/assets/img/uploads/documents'), $img);
                $expense->photo = $img;
                //return response('ok', 200);
            } else {
                $message = ['success' => 1, 'message' => 'Error'];
                return response(compact('message'), 200);
                //return 'hi';
            }
            $data = $request->data;
            $expense->rider_id = Auth::id();
            $expense->date = $data['date'];
            $expense->expense_type = $data['expense_type'];
            $expense->car_plate = $data['car_plate'];
            $expense->value = $data['value'];
            $expense->payment_type = $data['payment_type'];
            $expense->notes = $data['notes'];
            $expense->save();
            $message = ['success' => 0, 'message' => 'Success'];
            return response(compact('message'), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
        //$request->all();
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
