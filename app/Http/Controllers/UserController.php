<?php

namespace App\Http\Controllers;

use DB;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = User::where('role_id', '!=', '1')->with('role')->get();
        return view('hr-module.employee.employee', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('id', '!=', '1')->get();
        return view('hr-module.employee.add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|min:5|max:20',
            'email'    => 'required|email|unique:users,email',
            'number'   => 'required|size:11',
            'role_id'  => 'required',
            'password' => 'required|min:8|max:20',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'full_name'     => $request->name,
                'role_id'       => $request->role_id,
                'email'         => $request->email,
                'mobile_number' => $request->number,
                'password'      => Hash::make($request->password),
            ]);
            DB::commit();
            return redirect('employees')->with('message','Employee addedd successfully');

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error','Employee not addedd successfully');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $user  = User::where('id', decrypt($id))->first();
            $roles = Role::where('id', '!=', '1')->get();
            return view('hr-module.employee.edit', compact('id', 'user', 'roles'));
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error','Something Went Wrong');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|min:5|max:20',
            'email'    => 'required|email|unique:users,email,'.decrypt($id),
            'number'   => 'required|size:11',
            'role_id'  => 'required',
        ]);

        try {
            DB::beginTransaction();

            $user = User::where('id', decrypt($id))->update([
                'full_name'     => $request->name,
                'role_id'       => $request->role_id,
                'email'         => $request->email,
                'mobile_number' => $request->number,
            ]);
            DB::commit();
            return redirect('employees')->with('message','Employee updated successfully');

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error','Employee not updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
