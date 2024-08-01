<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MapSetting;
use App\Models\Rider;
use Illuminate\Http\Request;

class RiderLocationController extends Controller
{
    public function index()
    {
        $data['riders'] = Rider::select('id','name','lat','lng')->where('id',25)->first();
        $data['maps'] = MapSetting::first();
        // return $data;
        return view('admin.RiderLocation.index', $data);
    }

    public function show(){
        $data['riders'] = Rider::select('id','name','lat','lng')->get();
        return response()->json($data['riders']);
    }
}
