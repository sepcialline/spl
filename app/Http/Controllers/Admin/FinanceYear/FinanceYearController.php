<?php

namespace App\Http\Controllers\Admin\FinanceYear;

use App\Http\Controllers\Controller;
use App\Models\FinanceYear;
use Illuminate\Http\Request;

class FinanceYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data=FinanceYear::get();
       //echo $data;
         return view('admin.finance_year.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.finance_year.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'finance_year' => 'required|max:255',
            'finance_month' => 'required|max:255',
        ],
        [
            'finance_year.required' => __('admin.this_field_is_required'),
            'finance_month.required' => __('admin.this_field_is_required'),
        ]);

        $finance = new FinanceYear();
        $finance->year	 = $request->finance_year;
        $finance->month=$request->finance_month;

        $finance->save();
       // return response($finance);
        return redirect()->back();
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

    //update status
    public function updateStatus(Request $request, String $id )
    {

        try {
            //code...
            $finance = FinanceYear::find($id);

            $finance->status = $request->status;

            $result=$finance->save();

            return response($finance,200);

            //return redirect()->back();
        } catch (\Throwable $th) {
            return $th;
        }

        //$branchStatus->update(['status'=>'1']);
        //return redirect::to('administrator/logo/view');

    }

    public function delete_finance_year(string $id)
    {
        //
        FinanceYear::find($id)->delete();
        return response([],200);
    }
}
