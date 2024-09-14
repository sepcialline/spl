<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index($company_id)
    {
        $data['requests'] = ServiceRequest::orderBy('id', 'desc')->where('company_id', $company_id)->paginate(50);
        $data['company_id'] = $company_id;
        return view('vendor.services.index', $data);
    }

    public function create($company_id)
    {
        $data['services'] = Service::get();
        $data['company_id'] = $company_id;
        return view('vendor.services.create', $data);
    }

    public function store(Request $request)
    {
        $service_ids = $request->services;

        $number = 1000000;
        $last_number = ServiceRequest::latest()->first();
        if ($last_number) {
            $number = $number + 1;
        } else {
            $number = $number;
        }
        foreach ($service_ids as $service_id) {
            ServiceRequest::create([
                'request_number' => $number,
                'company_id' => $request->company_id,
                'service_id' => $service_id,
                'status' => 1, //  قيد الموافقة
                'created_date' => Carbon::now(),
                'created_by' => Auth::guard('vendor')->user()->id,
                'guard_created' => 'vendor',
            ]);
        }
        return redirect()->route('vendor.services.index', $request->company_id)->with(__('admin.msg_success_add'));
    }
}


// Route::get('/services/edit/{id}','edit')->name('services.edit');
// Route::post('/services/update','update')->name('services.update');
// Route::get('/services/show/{id}','show')->name('services.show');
