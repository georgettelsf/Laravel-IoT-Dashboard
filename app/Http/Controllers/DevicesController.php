<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\DeviceCollection;
use App\Http\Resources\DeviceResource;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class DevicesController extends Controller
{
    public function index() {
        return new DeviceCollection(Device::where('user_id', Auth::user()->id)->with('latestMetrics')->paginate(20));
    }

    public function store(Request $request) {

        $validatedData = $request->validate([
            'name' => 'required|min:5',
            'variables'=> 'required'
        ]);
        
        $device = Device::create([
            'name' => $validatedData['name'],
            'token' => Str::random(16),
            'user_id' => Auth::user()->id,
            'variables' => $validatedData['variables']
        ]);

        return new DeviceResource($device);       
    }

    public function update(Request $request, $id){
        
        $device = Device::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|min:5',
            'variables'=> 'required'
        ]);

        $device->update([
            'name' => $validatedData['name'],
            'variables' => $validatedData['variables']
        ]);

        return new DeviceResource($device);
    }

    public function delete(Request $request, $id){        
        $device = Device::findOrFail($id);
        $device->delete(); 
        return response()->json([], 204);        
    }

    public function get(Request $request, $device_id){
        $device = Device::findOrFail($id); 
        return new DeviceResource($device);       
    }
}