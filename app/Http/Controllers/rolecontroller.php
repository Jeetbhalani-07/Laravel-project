<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\role;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class rolecontroller extends Controller
{
    //
    function add(Request $req){
        
        $role = new role;
        $role->role_type = $req->role;
        $role->permission = json_encode($req->permission);
        // return $role;

        $role->save();
        return redirect('role');
    }
public function data(Request $req){
    if($req->ajax()){
        $data = role::all();
        return DataTables::of($data)
        ->addIndexColumn()
         ->editColumn('role_type', function ($row) {
                   
                    return '

                <div class="flex px-2 py-1">
                    
                    <div class="flex flex-col justify-center">
                        <h6 class="mb-0 text-sm leading-normal">' . $row->role_type . '</h6>
                       
                    </div>
                </div>';
                })
                ->editColumn('permission', function ($row) {
                    $permissions = json_decode($row->permission, true);
                    if(is_array($permissions)){
                        $perm = implode(",",$permissions);
                        return '<p class="mb-0 text-xs font-semibold leading-tight">' . $perm . '</p>';

                    }
                    else{

                        return '<p class="mb-0 text-xs font-semibold leading-tight">' . $row->permission . '</p>';
                    }
                })
                ->addColumn('edit', function ($row) {
                    return '<a href="/roles/' . $row->id . '/edit" class="text-xs font-semibold leading-tight text-slate-400">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/roles/' . $row->id . '/delete" data-id="' . $row->id . '" class="deleteUser text-xs font-semibold leading-tight text-red-500">Delete</a>';
                })
                ->rawColumns(['role_type','permission','edit','delete'])
                ->make(true);
        
    }
}

    public function display(Request $req)
    {


        $userId = Auth::user()->role_id;


        $role = role::where('id', $userId)->value('permission');
        //     // this gives you the permission JSON string directly


        return view('table pages.Role', ["roles" => $role]);
    }

    public function register(){
        $data = role::all();
        return $data;
    }
    function list(){
        $role = role::get();
        return view('role',["role" => $role]);
    }

    function update(Request $req){
        $role = role::find($req->id);
        $role->role_type = $req->role;
        $role->permission = json_encode($req->permission);
        $role->save();
        return redirect('role');
    }

    function edit_one($id){
        $role = role::find($id);
        // return $role;
        return view('table pages.editroles',["role"=>$role]);
    }
    function delete($id)
    {
        $data = role::Find($id);
        if ($id != 1) {

            $data->delete();
        }
        return redirect('role');
    }
}
