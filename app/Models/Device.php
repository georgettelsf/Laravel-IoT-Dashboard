<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'token',
        'user_id',
        'variables',
        'lat',
        'long'
    ];

    protected $casts = [
        'variables' => 'array'
    ];


    public function setVariablesAttribute($variables)
    {
        $this->attributes['variables'] = json_encode($variables);
    }


    public function metrics()
    {
        return $this->hasMany(Metric::class);
    }

    public function latestMetrics()
    {
        return $this->hasMany(Metric::class)->latest();
    }
}