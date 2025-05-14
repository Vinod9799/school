<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Helpers\Mk;
use Illuminate\Http\Request;
use App\Http\Requests\Student\StudentRecordUpdate;
use App\Repositories\LocationRepo;
use App\Repositories\MyClassRepo;
use App\Repositories\StudentRepo;
use App\Repositories\UserRepo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Salary;
use App\Models\Bus;
use App\Models\Driver;

class SalaryController extends Controller
{
    protected $loc, $my_class, $user, $student;

    public function __construct(LocationRepo $loc, MyClassRepo $my_class, UserRepo $user, StudentRepo $student)
    {
        $this->middleware('teamSA', ['only' => ['edit', 'update', 'reset_pass', 'create', 'store', 'graduated']]);
        $this->middleware('super_admin', ['only' => ['destroy',]]);

        $this->loc = $loc;
        $this->my_class = $my_class;
        $this->user = $user;
        $this->student = $student;
    }
    public function index()
    {
        $salaries = Salary::all();
        $driver = Driver::all();
        return view('pages.support_team.salaries.index', compact('salaries','driver'));
    }

    public function create()
    {
        return view('pages.support_team.salaries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'driver_id' => 'required',
            'basic' => 'required|numeric',
            'fuel_expense' => 'nullable|numeric',
            'other_expense' => 'nullable|numeric',
        ]);

        $data = $request->only(['driver_name', 'basic', 'fuel_expense', 'other_expense']);
        $data['total_pay'] = $data['basic'] + ($data['fuel_expense'] ?? 0) + ($data['other_expense'] ?? 0);

        Salary::create($data);
        return redirect()->route('pages.support_team.salaries.index')->with('success', 'Salary added successfully');
    }

    public function edit(Salary $salary)
    {
        return view('pages.support_team.salaries.edit', compact('salary'));
    }

    public function update(Request $request, Salary $salary)
    {
        $request->validate([
            'driver_name' => 'required|string|max:255',
            'basic' => 'required|numeric',
            'fuel_expense' => 'nullable|numeric',
            'other_expense' => 'nullable|numeric',
        ]);

        $data = $request->only(['driver_name', 'basic', 'fuel_expense', 'other_expense']);
        $data['total_pay'] = $data['basic'] + ($data['fuel_expense'] ?? 0) + ($data['other_expense'] ?? 0);

        $salary->update($data);
        return redirect()->route('pages.support_team.salaries.index')->with('success', 'Salary updated successfully');
    }

    public function destroy(Salary $salary)
    {
        $salary->delete();
        return redirect()->route('pages.support_team.salaries.index')->with('success', 'Salary deleted successfully');
    }

}
