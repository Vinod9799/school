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
use App\Models\Bus;

class BusController extends Controller
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
        $buses = Bus::all();
       return view('pages.support_team.buses.index',compact('buses'));
    }

    public function create()
    {
        return view('pages.support_team.buses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'number_plate' => 'required|unique:buses',
            'model' => 'required|string',
            'year' => 'required|digits:4|integer',
        ]);

        Bus::create($request->only(['number_plate', 'model', 'year']));

        return redirect()->back()->with('success', 'Bus added successfully');
    }


    public function show(Bus $bus)
    {
        return view('pages.support_team.buses.show', compact('bus'));
    }

    public function edit(Bus $bus)
    {
        return view('pages.support_team.buses.edit', compact('bus'));
    }

   public function update(Request $request, $id)
{
    $request->validate([
        'number_plate' => 'required|unique:buses,number_plate,' . $id,
        'model' => 'required|string',
        'year' => 'required|digits:4|integer',
    ]);

    $bus = Bus::findOrFail($id);
    $bus->update($request->only(['number_plate', 'model', 'year']));

    return redirect()->route('buses.index')->with('success', 'Bus updated successfully');
}


    public function destroy(Bus $bus)
    {
        $bus->delete();
        return redirect()->route('pages.support_team.buses.index')->with('success', 'Bus deleted.');
    }
}
