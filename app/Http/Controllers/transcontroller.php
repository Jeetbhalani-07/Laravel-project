<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transaction;
use App\Models\role;
use App\Models\User;
use App\Models\party;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;



class transcontroller extends Controller
{
    //
    function count(){


    $transactions = DB::table('transactions')
        ->select(
            DB::raw('MONTH(date) as month'),
            DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as income"),
            DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as expense")
        )
        ->whereYear('date', date('Y'))
        ->groupBy(DB::raw('MONTH(date)'))
        ->get();

    // Prepare arrays for chart
    $labels1 = [];
    $incomeData = [];
    $expenseData = [];

    foreach (range(1, 12) as $m) {
        $labels1[] = date("F", mktime(0, 0, 0, $m, 1));

        $income = $transactions->firstWhere('month', $m)->income ?? 0;
        $expense = $transactions->firstWhere('month', $m)->expense ?? 0;

        $incomeData[] = $income;
        $expenseData[] = $expense;
    }

    // return view('dashboard', compact('labels', 'incomeData', 'expenseData'));


    // Fetch user count per month
    $usersPerMonth = DB::table('users')
        ->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->pluck('count', 'month');  // returns [month => count]

    // Format labels (month names)
    $labels = [];
    $data1 = [];

    foreach (range(1, 12) as $m) {
        $labels[] = date("F", mktime(0, 0, 0, $m, 1)); // Jan, Feb...
        $data1[] = $usersPerMonth[$m] ?? 0; // put 0 if no users in that month
    }

    // return view('dashboard', compact('labels', 'data'));


        $data = transaction::get();
        $id = Auth::user()->id;
        $role = DB::table('users')->join('role', 'users.role_id', '=', 'role.id')->where('users.id', $id)->select('role.id', 'role.permission')->get();
        $user = User::all();
        $party = party::all();

        // return $role;
        return view("build.pages.dashboard", ["data" => $data, "role" => $role, "user" => $user, "party" => $party, "labels" => $labels, "data1" => $data1, "labels1" => $labels1, "incomeData" => $incomeData, "expenseData" => $expenseData]);
    }
    function index(Request $req)
    {
        $transaction = new transaction;
        $transaction->date = $req->date;
        $transaction->description = $req->description;
        $transaction->type = $req->type;
        $transaction->category = $req->category;
        $transaction->amount = $req->amount;
        $transaction->party_id = $req->party_id;
        $transaction->user_id = $req->user_id;
        $transaction->save();
        return redirect("post");
    }

    public function data(Request $req){
        if ($req->ajax()) {

            $userId = Auth::id();
        $roleId = Auth::user()->role_id;

        $role = role::where('id', $userId)->value('role_type');
           
            $permission = role::where('id', $roleId)->value('permission');
            $permissions = json_decode($permission, true);
             $isAdmin =  ($role == 'admin' ? 'true' : 'false') ;
         $Edit =  in_array('edit_transaction', $permissions);
         $Delete =  in_array('delete_transaction', $permissions);


            $data = DB::table('transactions')
                ->join('parties', 'transactions.party_id', '=', 'parties.id')
                ->select(
                    'transactions.id',
                    'transactions.date',
                    'transactions.description',
                    'transactions.category',
                    'transactions.type',
                    'transactions.amount',
                    'transactions.user_id',
                    'parties.name as party_name'
                );



            if ($req->start_date && $req->end_date) {
                $startDate = Carbon::parse($req->start_date)->startOfDay();
                $endDate = Carbon::parse($req->end_date)->endOfDay();

                $data->whereBetween('transactions.date', [$startDate, $endDate]);
            }





            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('party_name', function($row){
                    return '

                <div class="flex px-2 py-1">
                    
                    <div class="flex flex-col justify-center">
                        <h6 class="mb-0 text-sm leading-normal">' . $row->party_name . '</h6>
                       
                    </div>
                </div>';
            })
                ->editColumn('category', function ($row) {
                    return '<p class="mb-0 text-xs font-semibold leading-tight">' . $row->category . '</p>';
                })
                ->editColumn('description', function ($row) {
                    return '<p class="mb-0 text-xs font-semibold leading-tight">' . $row->description . '</p>';
                })
                ->editColumn('type', function ($row) {
                    return '<p class="mb-0 text-xs font-semibold leading-tight">' . $row->type . '</p>';
                })
                ->editColumn('date', function ($row) {
                    return '<span class="text-xs font-semibold leading-tight text-slate-400">'
                        . \Carbon\Carbon::parse($row->date)->format("d/m/Y") . '</span>';
                })

                ->editColumn('amount', function ($row) {
                    return '<p class="mb-0 text-xs font-semibold leading-tight">' . $row->amount . '</p>';
                })
                // ->addColumn('edit', function ($row) use() {
                       
                //     return '<a href="/transactions/' . $row->id . '/edit" class="text-xs font-semibold leading-tight text-slate-400">Edit</a>';
                // })

 ->addColumn('edit', function ($row) use ($userId, $isAdmin, $Edit) {
                $actions = '';

                if ($isAdmin == 'true' || $userId == $row->user_id) {
                    
                    if($Edit) {
                        $actions .= '<a href="/transactions/' . $row->id . '/edit" class="text-xs font-semibold leading-tight text-slate-400">Edit</a> ';
                    }
                        return $actions != '' ? $actions : "You don't have access";
                    }

                    return "You don't have permission";
                })


                // ->addColumn('delete', function ($row) {
                //     return '<a href="/transactions/' . $row->id . '/delete" data-id="' . $row->id . '" class="deleteUser text-xs font-semibold leading-tight text-red-500">Delete</a>';
                // })
->addColumn('delete', function ($row) use ($userId, $isAdmin, $Delete) {
                $actions = '';

                if ($isAdmin == 'true' || $userId == $row->user_id) {
                                    if ($Delete) {
                        $actions .= '<a href="/transactions/' . $row->id . '/delete" 
                                        data-id="' . $row->id . '" 
                                      class="deleteUser text-xs font-semibold leading-tight text-red-500">Delete</a>';
                    }

                    return $actions != '' ? $actions : "You don't have access";
                }
                    return "You don't have permission";
                })

                ->rawColumns(['party_name','description','date','category','type','amount','edit','delete'])
                ->make(true);
        }
    }
   

    public function display(Request $req)
    {
        // $userId = Auth::id();

        // $role = role::where('id', $userId)->value('role_type');

        // $isAdmin = $role =="admin" ? 'true' : 'false' ;
        // return $isAdmin;
        $userId = Auth::user()->role_id;


        $role = role::where('id', $userId)->value('permission');
        // this gives you the permission JSON string directly

  
        return view('table pages.Transaction', ["roles" => $role]);
    }

    function edit_page($id){
        $data = DB::table('transactions')->join('parties', 'transactions.party_id', '=', 'parties.id')->select('transactions.id', 'transactions.date', 'transactions.description', 'transactions.category', 'transactions.type', 'transactions.amount', 'transactions.user_id','transactions.party_id', 'parties.name')->where( 'transactions.id','=',$id)->get();
        // return $trans;
        $party = party::all();

        return view('table pages.edit_trans',["data"=>$data, "party" => $party]);
    }
    function update(Request $req){
            $transaction = transaction::find($req->id);
        $transaction->date = $req->date;
        $transaction->description = $req->description;
        $transaction->type = $req->type;
        $transaction->category = $req->category;
        $transaction->amount = $req->amount;
        $transaction->party_id = $req->party_id;
        $transaction->user_id = $req->user_id;
        $transaction->save();
        return redirect("transaction");
    }
    function delete($id){
        $data = transaction::find($id);
        $data->delete();
        return redirect('transaction');
    }
    function filter(Request $req)
    {
        $data = transaction::whereBetween("date", [$req->start, $req->end])->get();
        // return $data;
        return view('transaction', ['data' => $data]);
    }
    function party_detail(){
        $data = party::all();
        return view('table pages.addTrans',["data" => $data]);
    }
    function expense()
    {
        $data = party::all();
        return view('expense_transaction', ["data" => $data]);
    }
    function income()
    {
        $data = party::all();
        return view('income_transaction', ["data" => $data]);
    }
}
