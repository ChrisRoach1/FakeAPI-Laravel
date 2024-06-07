<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name("welcome");

Route::get('/v1/custom', function (Request $req){

    if($req->query('tableID') == null){
        return response()->json([
            'error' => 'Please provide a tableID value'],
            400
        );
    }

    if($req->query('API_KEY') == null){
        return response()->json([
            'error' => 'Please provide an API_KEY value'],
            400
        );
    }


    $table = \App\Models\MockTable::with(['user', 'mockFields'])
        ->where('id', '=', $req->query('tableID'))
        ->whereRelation('user', 'api_key', '=', $req->query('API_KEY'))
        ->first();

    if($table == null){
        return response()->json([
            'error' => 'Table does not exist for provided tableID and API_KEY'],
            400
        );
    }

    $returnArray = [];
    for($i=0; $i < 200; $i++){
        $newObj = [];
        foreach ($table->mockFields as $field) {
            $newObj[$field->name] = eval("return $field->generator;");
        }

        array_push($returnArray, (object)$newObj);
    }

    return response()->json($returnArray);
})->middleware('throttle:api');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('addTable', 'addMockTable')
    ->middleware(['auth', 'verified'])
    ->name('addTable');

Route::get('editTable/{mockTable}', function (\App\Models\MockTable $mockTable) {
    return view('editMockTable', ['mockTable' => $mockTable]);
})
    ->middleware(['auth', 'verified'])
    ->name('editTable');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
