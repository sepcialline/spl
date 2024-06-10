<?php

namespace App\Http\Controllers\Admin\GoogleMapSettings;

use App\Http\Controllers\Controller;
use App\Models\MapSetting;
use Illuminate\Http\Request;

class GoogleMapSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function map_settings()
    {
        //
        $data=MapSetting::first();
        return view('admin.google_map_settings.map', compact('data'));
    }

    public function updateMapConfig(Request $request){
       // return $request->all();
        $data = MapSetting::first();
        if($data == null){
            $map=new MapSetting();
            $map->server_key=$request->server_key;
            $map->client_key=$request->client_key;

            $map->save();
            toastr()->success('Success');

         }else{
            $data->server_key=$request->server_key;
            $data->client_key=$request->client_key;

            $data->save();
            toastr()->success('Success');

         }


        return redirect()->back();
    }
}
