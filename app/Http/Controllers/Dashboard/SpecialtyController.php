<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialty;

class SpecialtyController extends Controller
{

    public function index()
    {
        $allSpecialties = Specialty::paginate(10);
        return view('dashboard.specialties.manage', compact('allSpecialties'));
    }

    public function show()
    {
        $allSpecialties = Specialty::paginate(10);
        return view('dashboard.specialties.all', compact('allSpecialties'));
    }

    public function create()
    {
        return view('dashboard.specialties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:specialties,name"
        ]);
        $specialty = new Specialty();
        $specialty->name = $request->name;
        $specialty->spec_icon = $request->spec_icon;
        $specialty->about = $request->about;
        $specialty->save();
        return redirect()->route('specialties.index')->with('specialtyCreated' , 'Done!');
    }


    public function edit(Specialty $specialty)
    {
        return view('dashboard.specialties.edit', compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $input = $request->except('_token', '_method');
        $specialty->spec_icon = $input['spec_icon'];
        $specialty->about = $input['about'];
        $specialty->update($input);
        return Redirect::route('specialties.edit', $specialty->id)->with('success', 'Done');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $allSpecialties = Specialty::where('name', 'like', '%' . $search . '%')->paginate(10);
        return view('dashboard.specialties.all', compact('allSpecialties'))->with('SearchDone', 'Search Done');
    }

    public function destroy($id)
    {
        $specialty = Specialty::findOrFail($id);
        $specialty->delete();
        return Redirect::route('specialties.index')->with('success', 'Done');
    }
}
