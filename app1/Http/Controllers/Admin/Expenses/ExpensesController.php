<?php

namespace App\Http\Controllers\Admin\Expenses;

use App\Models\Rider;
use App\Models\Expense;
use App\Models\CarPLate;
use App\Models\ExpenseType;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $date_from = Carbon::now()->format('y-m-d');
        $date_to = Carbon::now()->format('y-m-d');
        if (request()->date_from) {
            $date_from = Carbon::parse(request()->date_from)->format('y-m-d');
        }

        if (request()->date_to) {
            $date_to = Carbon::parse(request()->date_to)->format('y-m-d');
        }

        $query = Expense::query()->whereBetween('date', [$date_from, $date_to]);

        if (Request()->rider_id && Request()->rider_id != 0) {
            $query->where('rider_id', Request()->rider_id);
        }
        if (Request()->payment_type_id && Request()->payment_type_id != 0) {
            $query->where('payment_type', Request()->payment_type_id);
        }
        if (Request()->expense_type_id && Request()->expense_type_id != 0) {
            $query->where('expense_type', Request()->expense_type_id);
        }
        if (Request()->date) {
            $query->whereBetween('date', [Carbon::parse(Request()->from_date)->format('Y-m-d'), Carbon::parse(Request()->to_date)->format('Y-m-d')]);
        }
        $data['riders'] = Rider::select('id', 'name')->get();
        $data['payment_types'] = PaymentType::select('id', 'name')->get();
        $data['expense_types'] = ExpenseType::select('id', 'name')->get();
        $data['data'] = $query->orderBy('id', 'desc')->paginate(30);
        $data['data']->appends(request()->query());
        return view('admin.expenses.index',  $data)->with('data',$data['data']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['riders'] = Rider::where('status', 1)->select('id', 'name')->get();
        $data['car_plates'] = CarPLate::select('id', 'car_name', 'car_plate')->get();
        $data['expense_types'] = ExpenseType::select('id', 'name')->get();
        $data['payment_types'] = PaymentType::select('id', 'name')->get();
        return view('admin.expenses.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //return $request->data;
        $expense = new Expense();

        //code...
        if ($request->hasFile('file')) {
            $img = $request->file != null ? time() . '_' . $request->file->getClientOriginalName() : $request->logo_en;
            //$data->	logo_en=$img;
            $request->file->move(public_path('build/assets/img/uploads/documents'), $img);
            $expense->photo = $img;
            //return response('ok', 200);
        } else {
            $expense->photo = 'no';
            //return 'hi';
        }
        $data = $request->data;
        $expense->rider_id = $request->rider_id;
        $expense->date = $request->date;
        $expense->expense_type = $request->expense_type_id;
        $expense->car_plate = $request->car_plate_id;
        $expense->value = $request->amount;
        $expense->payment_type = $request->payment_type_id;
        $expense->notes = $request->notes ?? 'by Admin';
        $expense->save();

        toastr()->success(__('admin.msg_success_add'));


        return redirect()->back();

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
        $data['expense'] = Expense::where('id', $id)->first();
        $data['riders'] = Rider::where('status', 1)->select('id', 'name')->get();
        $data['car_plates'] = CarPLate::select('id', 'car_name', 'car_plate')->get();
        $data['expense_types'] = ExpenseType::select('id', 'name')->get();
        $data['payment_types'] = PaymentType::select('id', 'name')->get();
        return view('admin.expenses.update', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        // return $request;
        $expense = Expense::where('id', $request->id)->first();
        //code...
        if ($request->hasFile('file')) {
            $img = $request->file != null ? time() . '_' . $request->file->getClientOriginalName() : $request->logo_en;
            //$data->	logo_en=$img;
            $request->file->move(public_path('build/assets/img/uploads/documents'), $img);
            $expense->photo = $img;
            //return response('ok', 200);
        } else {
            $expense->photo =  $expense->photo;
            //return 'hi';
        }
        $expense->rider_id = $request->rider_id;
        $expense->date = $request->date;
        $expense->expense_type = $request->expense_type_id;
        $expense->car_plate = $request->car_plate_id;
        $expense->value = $request->amount;
        $expense->payment_type = $request->payment_type_id;
        $expense->notes = $request->notes ?? 'by Admin';
        $expense->save();

        toastr()->success(__('admin.msg_success_update'));


        return redirect()->route('admin.expenses_index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
