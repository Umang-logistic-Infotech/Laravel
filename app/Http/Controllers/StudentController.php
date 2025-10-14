<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

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

    public function getStudents()
    {
        // Eloquent ORM
        return Student::all();

        // return DB::table('students')->limit(5)->get();
    }

    public function getStudentsCount()
    {
        return DB::table('students')->count();
    }

    public function addStudent()
    {
        //Eloquent ORM
        // $item = new Student();
        // $item->name = 'test';
        // $item->save();
        // return Student::all();


        //Query Builder 
        DB::table('students')->insert([
            "studentName" => 'test',
            "age" => 20,
            "date_of_birth" => '2005-03-16',
            "gender" => 'male',
            "percentage" => 99,
            "user_id" => 10
        ]);

        return " Inserted ";
    }

    public function getStudent($id)
    {
        $item = Student::findOrFail($id);

        return $item;
    }

    public function updateStudent($id)
    {
        //Eloquent ORM
        // $item = Student::findOrFail($id);
        // $item->name = 'abcd';
        // $item->update();
        // return "updated";

        DB::table('students')->where('id', $id)->update([
            'studentName' => "student5"
        ]);

        return "Updated...";
    }

    public function deleteStudent($id)
    {
        $item = Student::findOrFail($id);
        $item->delete();

        // DB::table('students')->where('id', $id)->delete();
        return "deleted";
    }

    public function deletedStudents()
    {
        $item = Student::onlyTrashed()->get();          // to selected deleted students
        $item = Student::withTrashed()->get();          // to selected all students including deleted students
        $item = Student::withTrashed()->find(7)->restore();     // to restore deleted stuedent
        return $item;
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
