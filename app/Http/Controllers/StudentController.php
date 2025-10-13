<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function  index()
    {
        return "From Student Controller";
    }
    public function  aboutStudent()
    {
        return "From About Student Method";
    }
}
