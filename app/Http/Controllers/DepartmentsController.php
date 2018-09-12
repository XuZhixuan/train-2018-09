<?php

namespace App\Http\Controllers;

use App\Models\Department;

class DepartmentsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $departments = Department::all();
        foreach ($departments as $department)
        {
            $department->members_count = $department->members->count();
        }
        return view('departments.index', compact('departments'));
    }

    /**
     * @param Department $department
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }
}
