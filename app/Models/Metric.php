<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    use HasFactory;

    protected $fillable = [
        'values',
        'device_id'
    ];

    protected $casts = [
        'values' => 'array',
        'created_at' => 'datetime'
    ];

    public function setValuesAttribute($values)
    {
        $this->attributes['values'] = json_encode($values);
    }
}
