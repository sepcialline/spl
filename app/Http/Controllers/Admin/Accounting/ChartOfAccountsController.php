<?php

namespace App\Http\Controllers\Admin\Accounting;

use App\Http\Controllers\Controller;
use App\Models\COA;
use App\Models\COALevelI;
use App\Models\COALevelII;
use Illuminate\Http\Request;

class ChartOfAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Dashboard()
    {
        return view('admin.account.dashboard');
    }

    public function index()
    {
        // $data['data'] = COA::all();

        // return view('admin.account.index', $data);
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
    public function storeLevelI(Request $request)
    {

        $validated = $request->validate([
            'code' => 'required|unique:c_o_a_level_i_s,code',
            'english_name' => 'required',
            'arabic_name' => 'required',
        ], [
            'code.required' => __("admin.this_field_is_required"),
            'english_name.required' => __("admin.this_field_is_required"),
            'arabic_name.required' => __("admin.this_field_is_required"),
        ]);

        $data = COALevelI::Create([
            'coa_id' => $request->coa_id,
            'code' => $validated['code'],
            'name' => ['en' => $validated['english_name'], 'ar' => $validated['arabic_name']]
        ]);

        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }
    public function storeLevelII(Request $request)
    {

        $validated = $request->validate([
            'code' => 'required|unique:c_o_a_level_i_i_s,code',
            'english_name' => 'required',
            'arabic_name' => 'required',
        ], [
            'code.required' => __("admin.this_field_is_required"),
            'english_name.required' => __("admin.this_field_is_required"),
            'arabic_name.required' => __("admin.this_field_is_required"),
        ]);

        $data = COALevelII::Create([
            'coa_i_id' => $request->coa_i_id,
            'code' => $validated['code'],
            'name' => ['en' => $validated['english_name'], 'ar' => $validated['arabic_name']]
        ]);

        toastr()->success(__('admin.msg_success_add'));
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
    public function updateLevelI(Request $request)
    {
        $validated = $request->validate([
            'coa_id' => 'required',
            'code' => 'required',
            'english_name' => 'required',
            'arabic_name' => 'required',
        ], [
            'coa_id.required' => __("admin.this_field_is_required"),
            'code.required' => __("admin.this_field_is_required"),
            'english_name.required' => __("admin.this_field_is_required"),
            'arabic_name.required' => __("admin.this_field_is_required"),
        ]);

        $data = COALevelI::where('id', $request->coa_i_id)->first();
        $data->update([
            'coa_id' => $request->coa_id,
            'code' => $validated['code'],
            'name' => ['en' => $validated['english_name'], 'ar' => $validated['arabic_name']]
        ]);

        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }

    public function updateLevelII(Request $request)
    {
        $validated = $request->validate([
            'coa_i_id' => 'required',
            'code' => 'required',
            'english_name' => 'required',
            'arabic_name' => 'required',
        ], [
            'coa_i_id.required' => __("admin.this_field_is_required"),
            'code.required' => __("admin.this_field_is_required"),
            'english_name.required' => __("admin.this_field_is_required"),
            'arabic_name.required' => __("admin.this_field_is_required"),
        ]);

        $data = COALevelII::where('id', $request->coa_i_id)->first();
        $data->update([
            'coa_id' => $request->coa_id,
            'code' => $validated['code'],
            'name' => ['en' => $validated['english_name'], 'ar' => $validated['arabic_name']]
        ]);

        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyLevelI($id)
    {
        $data = COALevelI::where('id', $id)->first();
        if ($data) {
            $data->delete();
            if ($data->delete()) {
                toastr()->success(__('admin.msg_success_delete'));
            } else {

                toastr()->error(__('admin.msg_something_error'));
            }
            return redirect()->back();
        }
    }

    public function destroyLevelII($id)
    {
        $data = COALevelII::where('id', $id)->first();
        if ($data) {
            $data->delete();
            if ($data->delete()) {
                toastr()->success(__('admin.msg_success_delete'));
            } else {

                toastr()->error(__('admin.msg_something_error'));
            }
            return redirect()->back();
        }
    }
}
