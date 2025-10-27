<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentAddRequest;
use App\Http\Requests\StudentUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use function Laravel\Prompts\alert;

class StudentController extends Controller
{
    protected $status;
    public function __construct()
    {
        $this->status = "fail";
    }
    public function index(Request $request)
    {
        // return Student::all();
        return Student::when($request->search, function ($query) use ($request) {
            return $query->whereAny([
                'studentName',
                'age',
                'percentage',
                'gender',
                'date_of_birth'
            ], 'like', '%' . $request->search . '%');
        })->paginate(13);
    }

    public function createStudent(StudentAddRequest $request)
    {
        $imagePath = null;
        if ($request->hasFile('studentImage')) {
            $imagePath = $request->file('studentImage')->store('photoes', 'public');
        }
        $Student = new Student();
        $Student->studentName = $request->studentName;
        $Student->age = $request->studentAge;
        $Student->percentage = $request->studentPercentage;
        $Student->date_of_birth = $request->studentDateOfBirth;
        $Student->gender = $request->studentGender;
        $Student->user_id = $request->studentUserId;
        $Student->profileImage = $imagePath;
        $Student->save();
        session()->flash('success', 'student created successfully');
        return redirect('/dashboard');
    }


    public function getStudents()
    {
        // Eloquent ORM
        $students = Student::all();

        return view('homeOld', compact('students'));
        // return $students;

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
        // DB::table('students')->insert([
        //     "studentName" => 'test',
        //     "age" => 20,
        //     "date_of_birth" => '2005-03-16',
        //     "gender" => 'male',
        //     "percentage" => 99,
        //     "user_id" => 10
        // ]);
        $user = Auth::user();

        return view('addStudent', compact('user'));
        // return " Add User Page ";
    }

    public function getStudent($id)
    {
        $Student = Student::findOrFail($id);
        Gate::authorize('update', $Student);

        $user = Auth::user();

        // return "Student " . $item;
        return view('updateStudent', compact('Student', 'user'));
    }

    public function updateStudent(StudentUpdateRequest $request, $id)
    {
        $student = Student::findOrFail($id);

        $imagePath = null;

        if ($request->hasFile('studentImage')) {
            if ($student->profileImage) {
                Storage::disk('public')->delete($student->profileImage);
            }
            $imagePath = $request->file('studentImage')->store('photoes', 'public');
        }
        // $request->validate([
        //     'studentName' => 'required|string|max:255',
        //     'studentUserId' => 'required|integer|max:255',
        //     'studentAge' => 'required|integer|min:10|max:50',
        //     'studentDateOfBirth' => 'required|date',
        //     'studentGender' => 'required|in:male,female',
        //     'studentPercentage' => 'required|integer|min:0|max:100'
        // ], [
        //     'studentName.required' => 'Student name is required',
        //     'studentAge.max' => 'Age must be under 50',
        //     'studentDateOfBirth.required' => 'Date of birth is required',
        //     'studentGender.required' => 'Gender is required',
        //     'studentPercentage.required' => 'Percentage is required',
        //     'studentUserId.required' => 'User id is required'
        // ]);


        $student->studentName = $request->studentName;
        $student->age = $request->studentAge;
        $student->percentage = $request->studentPercentage;
        $student->date_of_birth = $request->studentDateOfBirth;
        $student->gender = $request->studentGender;
        $student->user_id = $request->studentUserId;
        $student->profileImage = $imagePath;
        $student->update();
        session()->flash('success', 'student Updated successfully');

        return redirect('/dashboard');
    }

    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        if ($student->profileImage) {
            Storage::disk('public')->delete($student->profileImage);
        }
        $student->delete();
        session()->flash('success', 'student deleted successfully');

        return redirect('/dashboard');
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
