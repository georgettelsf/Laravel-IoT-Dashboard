<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Metric;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MetricCollection;

class MetricsController extends Controller
{
    public function get($id) {
        $device = Device::findOrFail($id);

        if ($device->user_id != Auth::user()->id) {
            abort(403);
        }
        $metrics = Metric::where('device_id', $id)->paginate(15);
        return new MetricCollection($metrics);        
    }

    public function store(Request $request, string $token)
    {
        $device = Device::where('token', $token)->first();
        if (!$device) {
            abort(404);
        }

        Metric::create([
            'values' => $request->input('values'),
            'device_id' => $device->id
        ]);
        return response('', 201);
    }

    public function delete(Request $request, $id){   
        $device = Device::findOrFail($id);

        if ($device->user_id != Auth::user()->id) {
            abort(403);
        }

        $metrics = Metric::where('device_id', $id)->delete();
        return response()->json([], 204);         
    }
}
