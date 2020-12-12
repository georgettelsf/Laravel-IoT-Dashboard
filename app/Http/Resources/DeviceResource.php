<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'variables' => $this->variables,
            'token' => $this->token,
            'lat' => $this->lat,
            'long' => $this->long,
            'latest_metrics' => new MetricCollection($this->latestMetrics)
        ];
    }
}
