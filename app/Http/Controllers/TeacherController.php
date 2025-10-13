<?php

namespace App\Http\Controllers;

use App\Models\teacher;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    //
    public function index()
    {
        return teacher::all();
    }

    public function add()
    {
        $item = new teacher();
        $item->name = 'test';
        $item->save();
        return teacher::all();
    }

    public function getTeacher($id)
    {
        $item = teacher::findOrFail($id);

        return $item;
    }

    public function updateTeacher($id)
    {
        $item = teacher::findOrFail($id);
        $item->name = 'abcd';
        $item->update();
        return "updated";
    }

    public function deleteTeacher($id)
    {
        $item = teacher::findOrFail($id);
        $item->delete();
        return "deleted";
    }
}
