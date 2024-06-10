<?php

namespace App\Http\Controllers\API;

use App\Events\RiderLocationUpdated;
use App\Http\Controllers\Controller;
use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiderLocationController extends Controller
{
    public function update(Request $request)
    {

        $request->validate([
            'lat' => 'required',
            'lng' => 'required'
        ]);


        $rider = Rider::where('id', Auth::id())->first();

        $rider->update([
            'lat' => $request->lat,
            'lng' => $request->lng,
        ]);
        event(new RiderLocationUpdated($rider->lat, $rider->lng));
        return $rider;


        // $rider = Rider::where('id', Auth::id())->update([
        //     'lat' => $request->lat,
        //     'lng' => $request->lng
        // ]);

        // if($rider->lat != Null && $rider->lng != Null){
        //
        // }
        return response()->json(['code' => 200, 'msg' => 'location update succsessfully']);
    }
}
