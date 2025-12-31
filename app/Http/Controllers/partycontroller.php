<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\party;
use App\Models\transaction;
use App\Models\role;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;



class partycontroller extends Controller
{
    //
    function list(){
        $party = party::all();
        return view("party",["party" => $party]);
    }
    public function data(Request $req){
        if($req->ajax()){
            $data = party::all();

            return DataTables::of($data)
            ->addIndexColumn()
                ->editColumn('name', function ($row) {

                    return '

                <div class="flex px-2 py-1">
                    
                    <div class="flex flex-col justify-center">
                        <h6 class="mb-0 text-sm leading-normal">' . $row->name . '</h6>
                       
                    </div>
                </div>';
                })
                ->addColumn('edit', function ($row) {
                    return '<a href="/partys/' . $row->id . '/edit" class="text-xs font-semibold leading-tight text-slate-400">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/partys/' . $row->id . '/delete" data-id="' . $row->id . '" class="deleteUser text-xs font-semibold leading-tight text-red-500">Delete</a>';
                })
                ->rawColumns(['name','edit','delete'])
            ->make(true);
        }
    }
    public function display(Request $req)
    {


        $userId = Auth::user()->role_id;

        $role = role::where('id', $userId)->value('permission');
        //     // this gives you the permission JSON string directly

        // return $role;
        return view('table pages.Client', ["roles" => $role]);
    }
    function add(Request $req){
        $party = new party;
        $party->name= $req->name;
        $party->save();
        // return $party;
        return redirect('party');
    }
    function edit($id){
        $party = party::find($id);
        return view('table pages.edit_party',["party" => $party]);
    }
    function update(Request $req){
        $party = party::find($req->id);
        $party->name = $req->name;
        $party->save();
        return redirect('party');

    }
    function delete($id){
        $party = party::find($id);
        $transaction = transaction::where('party_id', "=", $id)->get();
        if ($transaction->isEmpty()) {
           

         

                $party->delete();
                return redirect('party')->with('success', 'user deleted');
           

        }
        // return $transaction;
        return redirect('party')->with('error', 'Please delete all transactions before deleting the user.');

    }
}
