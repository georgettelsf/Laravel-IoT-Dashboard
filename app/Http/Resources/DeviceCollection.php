<?php

namespace App\Http\Resources;

use App\Models\Device;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DeviceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function(Device $device) {
            return new DeviceResource($device);
        });

        return parent::toArray($request);
    }
}
