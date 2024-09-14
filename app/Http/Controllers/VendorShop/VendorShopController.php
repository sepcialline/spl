<?php

namespace App\Http\Controllers\VendorShop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorShopController extends Controller
{
    public function show_shop($company_id){
        return view('vendors_shop.index');
    }
}
