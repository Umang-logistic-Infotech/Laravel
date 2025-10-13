<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class invocableController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return "Inside invokable controller";
    }
}
