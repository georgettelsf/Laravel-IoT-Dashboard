<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Metric;

class MetricsController extends Controller
{
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
}
