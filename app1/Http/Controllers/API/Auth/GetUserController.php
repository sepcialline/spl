<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetUserController extends Controller
{

    public function index()
    {
        $user = Rider::where('id', Auth::id())->with('branch')->first();
        $message = ['success' => 0, 'message' => 'Success Authentication'];
        return response(compact('user', 'message'));
    }
}
