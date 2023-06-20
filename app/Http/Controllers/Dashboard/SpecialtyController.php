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
        $request->validate([
            "title" => "required|unique:specialties,title",
            "image" => "required|image|mimes:jpeg,png,jpg|max:5128",
            "brief" => "required|max:500",
        ]);
        Specialty::create([
            'title' => $request->title,
            'image' => $this->UploudAvatar($request->file('image'), 'specialities'),
            'brief' => $request->brief,
        ]);
        notify()->success('You are awesome, Specialty has been created successfull!');
        return redirect()->route('specialties.index');
    }

    public function edit(Specialty $specialty)
    {
        return view('dashboard.specialties.edit', compact('specialty'));
    }

    public function update(Request $request, $id)
    {
        $specialty = Specialty::where('id', $id)->first();
        if ($specialty) {
            $request->validate([
                "title" => "sometimes|required|unique:specialties,title," . $specialty->id,
                "brief" => "sometimes|required|max:500",
            ]);

            $specialty->title = $request->title ?? $specialty->title;
            if ($request->file('image')) {
                $request->validate(["image" => "sometimes|image|mimes:jpeg,png,jpg|max:5128"]);
                $specialty->image = $this->UploudAvatar($request->file('image'), 'specialities') ?? $specialty->image;
            }
            $specialty->brief = $request->brief ?? $specialty->brief;
            $specialty->save();

            notify()->success('You are awesome, Specialty has been Updated successfull!');
            return redirect()->route('specialties.index');
        } else {
            notify()->success('Opps, Update Faild!');
            return redirect()->back();
        }
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $allSpecialties = Specialty::where('title', 'like', '%' . $search . '%')->paginate(10);
        return view('dashboard.specialties.manage', compact('allSpecialties'));
    }

    public function destroy(string $id)
    {
        $specialty = Specialty::find($id);
        if ($specialty) {
            $specialty->delete();
            notify()->success('You are awesome, The Specialty has been deleted successfull!');
        } else {
            notify()->error('Opps!, The Specialty has been deleted before');
        }
        return redirect()->back();
    }
}
