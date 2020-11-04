<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\DeviceCollection;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;

class DevicesController extends Controller
{
    public function index() {
        return new DeviceCollection(Device::with('latestMetrics')->where('user_id', Auth::user()->id)->paginate(20));
    }

    public function store(Request $request, string $token) {
        dd($token);

        $validatedData = $request->validate([
            'name' => 'required|min:5',
            'metrics'=> 'required|max:255'
        ]);
        
        $device = Device::create([
            'name' => $validatedData['name'],
            'token' => str::random(16),
            'metrics' => $validatedData['metrics']
        ]);

        return redirect(action('DevicesController@show', ['device' => $device-> id]));
    }

    public function update(Request $request, $id){
        
        $device = Device::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|min:5',
            'variables'=> ''
        ]);

        $device = $device->update()([
            'name' => $validatedData['name'],
            'variables' => $validatedData['variables']
        ]);
    }

    /*public function get(Request $request, $id){
        
        $device = Device::findOrFail($id);

        return 
    }*/

    public function delete(Request $request, $id){
        
        $device = Device::findOrFail($id);

        $device->delete(); 

        return response()->json([], 204);         
    }
}