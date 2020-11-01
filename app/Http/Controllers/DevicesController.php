<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DevicesController extends Controller
{
    public function index() {
        return ['device' => 'temprature-controller'];
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|min:5',
            'metrics'=> 'required|max:255'
        ]);
        
        /**
        *public function create()
        *{
        *    return view('tickets.create');
        *};
        */

        $device = Device::create([
        'name' => $validatedData['name'],
        'token' => str::random(16),
        'metrics' => $validatedData['metrics']
        ]);

        return redirect(action('DevicesController@show', ['device' => $device-> id]));
    }
}
