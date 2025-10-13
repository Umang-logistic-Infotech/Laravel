<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $status;
    public function __construct()
    {
        $this->status = "fail";
    }



    public function  index()
    {
        return "From Student Controller";
    }
    public function  aboutStudent($id, $name)
    {
        $percentage = "25";
        $result = $this->studentResult($id, $percentage);
        return view('aboutUs', compact('id', 'name', 'result'));
        // return "Student " . $id . " Name : " . $name;
    }
    private function  studentResult($id, $percentage)
    {
        if ($percentage >= 35) {
            $this->status = "pass";
        } else {
            return "Student Id " . $id . " Is " . $this->status;
        }
        return "Student Id " . $id . " has " . $percentage . " Percentage";
    }
}
