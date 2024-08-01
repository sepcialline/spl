<?php

namespace App\Http\Controllers\Admin\City;

use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Cities;
use App\Models\Emirates;
use Illuminate\Http\Request;

class CityController extends Controller
{

    function __construct()
    {
        $this->middleware(['permission:admin-City-Show-Page'], ['only' => ['index']]);
        $this->middleware(['permission:admin-City-add'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:admin-City-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:admin-City-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Cities::get();
        //echo $data;
        return view('admin.cities.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $emirates = Emirates::get();

        return view('admin.cities.create', compact('emirates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate(
            [
                'city_english_name' => 'required|max:255',
                'city_arabic_name' => 'required|max:255',
                'emirates' => 'required|max:255',
            ],
            [
                'city_english_name.required' => __('admin.this_field_is_required'),
                'city_arabic_name.required' => __('admin.this_field_is_required'),
                'emirates.required' => __('admin.this_field_is_required'),
            ]
        );

        $city = new Cities();
        $city->name     = ['ar' => $request->city_arabic_name, 'en' => $request->city_english_name];
        $city->emirate_id = $request->emirates;

        $city->save();

        return redirect()->back();
        //        echo json_encode($request->all());
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

        $data = Cities::query()->find($id);
        $data->emirates = Emirates::get();
        //echo $data;
        return view('admin.cities.update', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate(
            [
                'city_english_name' => 'required|max:255',
                'city_arabic_name' => 'required|max:255',
                'emirates' => 'required|max:255',
            ],
            [
                'city_english_name.required' => __('admin.this_field_is_required'),
                'city_arabic_name.required' => __('admin.this_field_is_required'),
                'emirates.required' => __('admin.this_field_is_required'),
            ]
        );

        $city =  Cities::find($id);
        $city->name     = ['ar' => $request->city_arabic_name, 'en' => $request->city_english_name];
        $city->emirate_id = $request->emirates;

        $city->save();

        return redirect()->back();
    }


    public function updateCity(Request $request)
    {
        //
        echo 'hello';
        $validated = $request->validate(
            [
                'city_english_name' => 'required|max:255',
                'city_arabic_name' => 'required|max:255',
                'emirates' => 'required|max:255',
            ],
            [
                'city_english_name.required' => __('admin.this_field_is_required'),
                'city_arabic_name.required' => __('admin.this_field_is_required'),
                'emirates.required' => __('admin.this_field_is_required'),
            ]
        );

        // $city =  Cities::find($request->id);
        // $city->name	 = ['ar'=>$request->city_arabic_name,'en'=>$request->city_english_name];
        // $city->emirate_id=$request->emirates;

        // $city->save();

        //return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Cities::find($id)->delete();
        return back();
    }

    public function delete_city(string $id)
    {
        //
        Cities::find($id)->delete();
        return response([], 200);
    }
}
