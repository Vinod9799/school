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
use App\Models\attendance;
use App\Models\MyClass;
use App\Models\Bus;
use App\User;

class AttendanceController extends Controller
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
        $attendance = Attendance::all();
        $classes  = MyClass::all();
        $bus = Bus::all();
        $students = User::all();
        return view('pages.support_team.attendance.index',compact('attendance','classes','bus','students'));
    }

    public function create()
    {
        return view('pages.support_team.attendance.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'class_id' => 'required',
            'student_id' => 'required',
            'status' => 'required|in:present,absent',
        ]);

        // Check if already marked for this student/date
        $exists = Attendance::where('student_id', $request->student_id)
            ->where('date', $request->date)
            ->first();

        if ($exists) {
            return back()->with('flash_warning', 'Attendance already marked for this student on the selected date.');
        }

        Attendance::create([
            'date' => $request->date,
            'class_id' => $request->class_id,
            'student_id' => $request->student_id,
            'status' => $request->status,
            'teacher_id' => Auth::id(), // assuming logged in teacher
        ]);

        return redirect()->route('attendance.index')->with('flash_success', 'Attendance marked successfully.');
    }


    public function show(attendance $bus)
    {
        return view('pages.support_team.attendance.show', compact('bus'));
    }

    public function edit(attendance $attendance)
    {
        return view('pages.support_team.attendance.edit', compact('attendance'));
    }

   public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'license_number' => 'required|string',
        'phone' => 'required',
        'address' => 'required',
    ]);

    $bus = Attendance::findOrFail($id);
    $bus->update($request->only(['name', 'license_number', 'phone','address']));

    return redirect()->route('attendances.index')->with('success', 'Bus updated successfully');
}


    public function destroy(attendance $bus)
    {
        $bus->delete();
        return redirect()->route('pages.support_team.attendance.index')->with('success', 'Bus deleted.');
    }
}
