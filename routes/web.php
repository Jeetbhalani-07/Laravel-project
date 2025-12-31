<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transcontroller;
use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\userregistration;
use App\Http\Controllers\rolecontroller;
use App\Http\Controllers\partycontroller;


Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
]);
// ->group(function () {
//     Route::get('/dashboard', [transcontroller::class,'count'])->name('dashboard');
// });

// Route::get('/add', [transcontroller::class,'party_detail'])->name('add');
Route::get('/income', [transcontroller::class,'income'])->name('income');
Route::get('/expense', [transcontroller::class,'expense'])->name('expense');
Route::post('index', [transcontroller::class, 'index']);
// Route::get('/post', [transcontroller::class, 'display'])->name('transactions.display');

Route::get('/list', [transcontroller::class, 'list'])->name('list');
Route::get('update', [transcontroller::class, 'filter']);
// Route::get('edit/{id}',[transcontroller::class,'edit_page']);
Route::post('update', [transcontroller::class, 'update']);
// Route::get('delete/{id}', [transcontroller::class, 'delete']);


Route::get('/register', [CreateNewUser::class, 'add'])
    ->middleware('auth')
    ->name('register');
Route::post('/register', [userregistration::class, 'create'])->middleware('auth');
// Route::get('/user',[userregistration::class,'list'])->name('user');
// Route::get('user/edit/{id}', [userregistration::class, 'edit_one']);
// Route::get('user/delete/{id}', [userregistration::class, 'delete']);



// Route::post('add_role', [rolecontroller::class, 'add']);
// Route::get('/role', [rolecontroller::class, 'list'])->name('role');
// Route::get('role/edit/{id}',[rolecontroller::class,'edit_one']);
Route::post('/role/update',[rolecontroller::class,'update']);
// Route::get('role/delete/{id}',[rolecontroller::class,'delete']);

Route::get('/party',[partycontroller::class,'list'])->name('party');
// Route::get('add_party', function(){
//     return view('add_party');
// })->name('add_party');
// Route::post('add_party',[partycontroller::class,'add']);
// Route::get('party/edit/{id}', [partycontroller::class, 'edit']);
Route::post('/party/update', [partycontroller::class, 'update']);
// Route::get('party/delete/{id}', [partycontroller::class, 'delete']);


Route::get('dashboard',[transcontroller::class,'count'])->name('check');
Route::get('client',[partycontroller::class,'display'])->name('table');
Route::get('billing', function () {
    return view('build.pages.billing');
})->name('billing');
Route::get('profile', function () {
    return view('build.pages.profile');
})->name('profile');
Route::get('rtl', function () {
    return view('build.pages.rtl');
})->name('rtl');
Route::get('sign-in', function () {
    return view('build.pages.sign-in');
})->name('sign-in');
Route::get('sign-up', function () {
    return view('build.pages.sign-up');
})->name('sign-up');
Route::get('virtual-reality', function () {
    return view('build.pages.virtual-reality');
})->name('virtual-reality');

Route::get('transaction', [transcontroller::class,'display'])->name('transaction');
Route::get('role', [rolecontroller::class,'display'])->name('role');
Route::get('user', function () {
    return view('build.pages.table');
})->name('party');

Route::view('/user/edit','table pages.edit_user');

Route::get('/users/list', [userregistration::class, 'list'])->name('users.list');
Route::get('/transaction/data',[transcontroller::class,'data'])->name('transaction.data');
Route::get('/role/data',[rolecontroller::class,'data'])->name('role.data');
Route::get('/party/data',[partycontroller::class,'data'])->name('party.data');
Route::post('/update{user}', [userregistration::class, 'update'])->name('update');

Route::get('users/{id}/edit', [userregistration::class, 'edit_one']);
Route::get('users/{id}/delete', [userregistration::class, 'delete']);

Route::get('/transaction/add', [transcontroller::class, 'party_detail'])->name('addTrans');
Route::get('transactions/{id}/edit', [transcontroller::class, 'edit_page']);
Route::get('transactions/{id}/delete', [transcontroller::class, 'delete']);

Route::get('add_role', function () {
    return view('table pages.addRole');
})->name('addRole');
Route::post('add_role', [rolecontroller::class, 'add']);
Route::get('roles/{id}/edit', [rolecontroller::class, 'edit_one']);
Route::get('roles/{id}/delete', [rolecontroller::class, 'delete']);

Route::get('add_party', function () {
    return view('table pages.addParty');
})->name('addParty');
Route::post('add_party', [partycontroller::class, 'add']);
Route::get('partys/{id}/edit', [partycontroller::class, 'edit']);
Route::get('partys/{id}/delete', [partycontroller::class, 'delete']);

