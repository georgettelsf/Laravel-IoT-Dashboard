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
}
