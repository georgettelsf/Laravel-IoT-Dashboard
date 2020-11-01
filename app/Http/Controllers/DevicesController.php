<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DevicesController extends Controller
{
    public function index() {
        return ['device' => 'temprature-controller'];
    }
}
