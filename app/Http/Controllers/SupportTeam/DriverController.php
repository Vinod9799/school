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
use App\Models\Driver;
use App\Models\Bus;

class DriverController extends Controller
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
        $driver = Driver::all();
        $bus = Bus::all();
       return view('pages.support_team.driver.index',compact('driver','bus'));
    }

    public function create()
    {
        return view('pages.support_team.driver.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'license_number' => 'required|string',
            'phone' => 'required',
            'address' => 'required',
            'bus_id' => 'required',
            'image' =>"required"
        ]);
         if($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $f = Qs::getFileMetaData($photo);
            $f['name'] = 'photo.' . $f['ext'];
            $f['path'] = $photo->storeAs(Qs::getUploadPath('driver'), $f['name']);
            $data['photo'] = asset('storage/' . $f['path']);
        }
        Driver::create($request->all());

        return redirect()->back()->with('success', 'Bus added successfully');
    }


    public function show(Driver $bus)
    {
        return view('pages.support_team.driver.show', compact('bus'));
    }

    public function edit(Driver $driver)
    {
        return view('pages.support_team.driver.edit', compact('driver'));
    }

   public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'license_number' => 'required|string',
        'phone' => 'required',
        'address' => 'required',
    ]);

    $bus = Driver::findOrFail($id);
    $bus->update($request->only(['name', 'license_number', 'phone','address']));

    return redirect()->route('drivers.index')->with('success', 'Bus updated successfully');
}


    public function destroy(Driver $bus)
    {
        $bus->delete();
        return redirect()->route('pages.support_team.driver.index')->with('success', 'Bus deleted.');
    }
}
