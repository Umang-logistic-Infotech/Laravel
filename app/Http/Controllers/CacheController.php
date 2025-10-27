<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
    //
    public function index()
    {
        // Cache::put('keyName', 'value', Duration);
        // Cache::put('test', 'test message', 600);

        $countries = Cache::remember('countries', 600, function () {
            return Countries::all()->toArray();
        });

        // $value = Cache::get('test', 'default value');
        return $countries;
    }
}
