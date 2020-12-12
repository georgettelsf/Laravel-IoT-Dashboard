<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\DeviceCollection;
use App\Http\Resources\DeviceResource;
use App\Http\Resources\DeviceResourceSingle;

use App\Models\Device;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class DevicesController extends Controller
{
    public function index() {
        return new DeviceCollection(Device::where('user_id', Auth::user()->id)->with('latestMetrics')->paginate(20));
    }

    public function store(Request $request) {

        $validatedData = $request->validate([
            'name' => 'required|min:5',
            'variables'=> 'required',
            'lat' => 'required',
            'long' => 'required'
        ]);
        
        $device = Device::create([
            'name' => $validatedData['name'],
            'token' => Str::random(16),
            'user_id' => Auth::user()->id,
            'variables' => $validatedData['variables'],
            'lat' => $validatedData['lat'],
            'long' => $validatedData['long']
        ]);

        return new DeviceResource($device);       
    }

    public function update(Request $request, $id){
        $device = Device::findOrFail($id);

        if ($device->user_id != Auth::user()->id) {
            abort(403);
        }
        $validatedData = $request->validate([
            'name' => 'required|min:5',
            'variables'=> 'required',
            'lat' => 'required',
            'long' => 'required'
        ]);

        $device->update([
            'name' => $validatedData['name'],
            'variables' => $validatedData['variables'],
            'lat' => $validatedData['lat'],
            'long' => $validatedData['long']
        ]);

        return new DeviceResource($device);
    }

    public function delete(Request $request, $id){        
        $device = Device::findOrFail($id);
        if ($device->user_id != Auth::user()->id) {
            abort(403);
        }
        $device->delete(); 
        return response()->json([], 204);        
    }

    public function get(Request $request, $id) {
        $device = Device::with(['metrics' => function($query) {
            $query->latest()->take(15);
        }])->where('id', $id)->first(); 
        if (!$device) {
            abort(404);
        }

        if ($device->user_id != Auth::user()->id) {
            abort(403);
        }
        return new DeviceResourceSingle($device);       
    }
}