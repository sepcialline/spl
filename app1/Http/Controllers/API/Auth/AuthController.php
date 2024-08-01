<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function login(Request $request)
    {
        try {
            //code...
            if ((Auth::guard('rider')->attempt(["mobile" => $request->mobile, "password" => $request->password]) && Auth::guard('rider')->user()->status == 1) ||
            (Auth::guard('rider')->attempt(["email" => $request->mobile, "password" => $request->password]) && Auth::guard('rider')->user()->status == 1)) {
                $user = Auth::guard('rider')->user();
                $token = $user->createToken('main')->plainTextToken;
                $message = ['success' => 0, 'message' => 'Success Authentication'];
                return response(compact('user', 'token', 'message'));
            } else {
                $message = ['success' => 1, 'message' => 'Invalid Credentials'];
                return response(compact('message'));
                return response([]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            $message = ['success' => 1, 'message' => 'Invalid Credentials'];
            return response(compact('message'));
            return response([]);
        }


        return $request->all();
    }

    public function logout()
    {
        try {
            //code...
            Auth::guard('rider')->logout();
            $message = ['success' => 0, 'message' => 'Success'];
            return response(compact('message'));
            // return ;
        } catch (\Throwable $th) {
            //throw $th;
            $message = ['success' => 1, 'message' => $th];
            return response(compact('message'));
        }
    }
    public function user()
    {


        try {
            //code...
            $user = Rider::where('id', Auth::guard('rider')->user()->id)->with('branch')->first(); // Auth::user();
            $message = ['success' => 0, 'message' => 'Success'];
            return response(compact('user', 'message'));
            // return ;
        } catch (\Throwable $th) {
            throw $th;
            $message = ['success' => 1, 'message' => $th];
            return response(compact('message'));
        }
    }

    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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
}
