<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;


class StudentController extends Controller
{
    protected $status;
    public function __construct()
    {
        $this->status = "fail";
    }


    public function index()
    {
        return Student::all();
    }

    public function add()
    {
        $item = new Student();
        $item->name = 'test';
        $item->save();
        return Student::all();
    }

    public function getStudent($id)
    {
        $item = Student::findOrFail($id);

        return $item;
    }

    public function updateStudent($id)
    {
        $item = Student::findOrFail($id);
        $item->name = 'abcd';
        $item->update();
        return "updated";
    }

    public function deleteStudent($id)
    {
        $item = Student::findOrFail($id);
        $item->delete();
        return "deleted";
    }

    // public function  index()
    // {
    //     return "From Student Controller";
    // }
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
