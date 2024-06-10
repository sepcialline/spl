<?php

namespace App\Http\Controllers\Admin\UserManagment;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = User::paginate(10);
        // return $data['data'];

        //return $data->toArray();
        return view('admin.users.customer.index', compact('data'));
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
        $data = User::find($id);

        return view('admin.users.customer.show', compact('data'));
    }

    // Search Admins
    public function search(Request $request)
    {
        //  return $request->all();
        $result = User::where('name', 'LIKE', '%' . $request->search . '%')->orWhere('email', 'LIKE', '%' . $request->search . '%')->orWhere('mobile', 'LIKE', '%' . $request->search . '%')->get();
        return ['results' => $result->all()];
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
        // $user=User::find($id);
        // //return $user;
        // if($user->delete()){
        //     return response()->json([
        //         'success' => 'success',
        //     ]);

        // }else{
        //     return response()->json([
        //         'error' => 'error',
        //     ]);
        // }
    }
}
