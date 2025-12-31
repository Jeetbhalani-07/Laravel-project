<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;



use App\Actions\Fortify\CreateNewUser;

class userregistration extends Controller
{
    //
   

    public function create(Request $request, CreateNewUser $creator)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:4|confirmed',
            'role_type' => 'required',

        ]);

        $creator->create($validated);

        return redirect('user')->with('success', 'User created.');
    }
    public function list(Request $req)
    {
        if ($req->ajax()) {
            $user = DB::table('users')
                ->join('role', 'users.role_id', '=', 'role.id')
                ->select('users.id', 'users.name', 'users.email', 'role.role_type', 'users.created_at')
                ->orderBy('users.id')
                ->get();
            
            return DataTables::of($user)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                   
                    return '

                <div class="flex px-2 py-1">
                    
                    <div class="flex flex-col justify-center">
                        <h6 class="mb-0 text-sm leading-normal">' . $row->name . '</h6>
                        <p class="mb-0 text-xs leading-tight text-slate-400">' . $row->email . '</p>
                    </div>
                </div>';
                })
                ->editColumn('role_type', function ($row) {
                    return '<p class="mb-0 text-xs font-semibold leading-tight">' . $row->role_type . '</p>';
                })
                ->editColumn('created_at', function ($row) {
                    return '<span class="text-xs font-semibold leading-tight text-slate-400">'
                        . date("d/m/Y", strtotime($row->created_at)) . '</span>';
                })
                ->addColumn('status', function ($row) {
                    $action = '';
                    if(Auth::id() == $row->id){

                        $action = '<span class="bg-gradient-to-tl from-green-600 to-lime-400 
                        px-2.5 text-xs rounded-1.8 py-1.4 inline-block text-white font-bold">Online</span>';
                        }
                        else{
                            $action = '
                          <span class="bg-gradient-to-tl from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">Offline</span>';
                       
                        }
                    return $action;
                })
                ->addColumn('edit', function ($row) {
                    return '<a href="/users/' . $row->id . '/edit" class="text-xs font-semibold leading-tight text-slate-400">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/users/' .$row->id  . '/delete" data-id="' . $row->id . '" class="deleteUser text-xs font-semibold leading-tight text-red-500">Delete</a>';
                })
                ->rawColumns(['name', 'role_type', 'status', 'created_at', 'edit', 'delete'])
                ->make(true);
        }
    }

    function edit_one($id){
        
        $user = user::find($id);
        $data = DB::table('role')->get();
        return view('table pages.edit_user',["user" => $user, "data" => $data]);
    }

    function update(Request $req, User $user){
       $input = $req->all();
 
       validator::make($input,[
        'current_password' => ['required','string','current_password:web'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmed' => ['required', 'same:password'],
       ],
       [
            'current_password.current_password' => __('The provided password does not match your current password.')
        ])->validateWithBag('updatePassword');

       $user->forceFill([
        'password' => $input['password'],
            'name' => $input['user_name'],
            'email' => $input['email'],
            'role_id' => $input['role_type'],
       ])->save();
       return redirect('table');
    }

    function delete($id){
        $data = User::Find($id);
        $transaction = transaction::where('user_id' , "=" ,$id)->get();
        if($transaction->isEmpty()){
            echo "null value";
       
            if($id == 1){
    
                
                return redirect('table')->with('error', 'Admin cannot be deleted');
            }
            else{
                $data->delete();
                return redirect('table')->with('success', 'user deleted');
            }

        }
        // return $transaction;
        return redirect('table')->with('error', 'Please delete all transactions before deleting the user.');
    
    }

}
