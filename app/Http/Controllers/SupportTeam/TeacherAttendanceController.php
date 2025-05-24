<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\TeacherPresent;
use App\Models\Attendance;
use App\User;

class TeacherAttendanceController extends Controller
{
    public function index()
    {
        $teacher = User::where('user_type', 'teacher')->get();
        $attendance = TeacherPresent::all(); // show all teachers' attendance

        return view('pages.support_team.teacher-attendance.index', compact('teacher', 'attendance'));
    }

    public function mark(Request $request)
    {
        $teacherId = $request->teacher_id ?? auth()->id(); // allow marking for others if provided
        $now = Carbon::now();
        $today = $now->toDateString();

        $attendance = TeacherPresent::firstOrNew([
            'teacher_id' => $teacherId,
            'date' => $today,
        ]);

        if (!$attendance->check_in) {
            $attendance->check_in = $now->toTimeString();
            $attendance->status = $now->lt(Carbon::createFromTime(8, 30)) ? 'Present' : 'Late';
        } elseif (!$attendance->check_out && $now->gte(Carbon::createFromTime(13, 30))) {
            $attendance->check_out = $now->toTimeString();
        }

        $attendance->save();
    return redirect()->route('teacher-attendance.index')->with('flash_success', 'Attendance marked successfully.');
    }

    public function destroy(TeacherPresent $attendance)
    {
        $attendance->delete();
        return back()->with('flash_success', 'Attendance record deleted.');
    }
}
