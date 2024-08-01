<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarPLate;
use App\Models\VehicleTypes;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(){
        $data['cars'] = CarPLate::get();
        return view('admin.cars.index',$data);
    }

    public function create(){
        return view('admin.cars.create');
    }

    public function store(Request $request){
        CarPLate::create([
            'car_name' => ['ar'=>$request->car_name_ar,'en'=>$request->car_name_en],
            'car_plate' => $request->car_plate
        ]);

        toastr()->success('Car Added Successfully');
        return redirect()->back();
    }
    public function edit($id){
        $data['car'] = CarPLate::find($id);
        return view('admin.cars.edit',$data);
    }

    public function update(Request $request,$id){
        $data['car'] = CarPLate::find($id)->update([
            'car_name' => ['ar'=>$request->car_name_ar,'en'=>$request->car_name_en],
            'car_plate' => $request->car_plate
        ]);

        toastr()->success('Car Updated Successfully');
        return redirect()->back();
    }


    public function delete_car(string $id)
    {
        //
        CarPLate::find($id)->delete();
        return response([], 200);
    }
}
