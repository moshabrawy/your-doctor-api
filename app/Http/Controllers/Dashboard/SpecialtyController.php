<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialty;
use App\Traits\FilesTrait;
use Illuminate\Support\Facades\Storage;

class SpecialtyController extends Controller
{
    use FilesTrait;

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
        return $request;

        $request->validate([
            "name" => "required|unique:specialties,name",
            "image" => "required|image|mimes:jpeg,png,jpg|max:5128",
            "brief" => "required|max:500",
        ]);
        Specialty::create([
            'ttle' => $request->name,
            'image' => Storage::disk('public')->put('uploads/images/specialities', $request->file('image')),
            'brief' => $request->brief,
        ]);
        notify()->success('You are awesome, Specialty has been created successfull!');
        return redirect()->route('specialties.index');
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
