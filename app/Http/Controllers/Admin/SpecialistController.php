<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialistRequest;
use App\Models\Role;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Service as Helper;
use Illuminate\Validation\Rule;

class SpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['specialists'] = Specialist::all();
        return view('dashboard.specialists.index', $data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::where('name','user')->first();
        $data['users'] = User::where('role_id',$role->id)->get();
        $data['services'] = Service::all();
        return view('dashboard.specialists.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpecialistRequest $request)
    {
        Specialist::create([
            "service_id" => $request->service_id,
            "user_id" => $request->user_id,
            "description" => $request->description,
            "num_of_experience" =>  $request->num_of_experience,
            'personal_card' => $request->has('personal_card') ?
                json_encode(array_map(fn ($image) => Helper::uploadImage($image, "specialists/"), $request->personal_card)) :
                null,
            'personal_image' => $request->hasFile('personal_image') ?
                Helper::uploadImage($request->file('personal_image'), "specialists/") :
                null,
        ]);

        return  redirect()->route('specialists.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialist $specialist)
    {
        $data['specialist'] = Specialist::where('id', $specialist->id)->first();
        return view("dashboard.specialists.index", $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialist $specialist)
    {
        $data['specialist'] = $specialist;
        $data['service'] = Service::where('id', $specialist->service_id)->first();
        return view('dashboard.specialists.index', $data);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'description' => 'required|string',
            'num_of_experience' => 'required|integer|min:0',
            'personal_card.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'personal_image' => 'nullable|image',
            'status' =>  Rule::in(['true', 'false']),
        ]);

        $specialist = Specialist::findOrFail($id);
        $data = [
            'description' => $request->description,
            'num_of_experience' => $request->num_of_experience,
            'personal_card' => $request->has('personal_card') ?
                json_encode(array_map(fn ($image) => Helper::uploadImage($image, "specialists/"), $request->personal_card)) :
                $specialist->personal_card,
            'personal_image' => $request->hasFile('personal_image') ?
                Helper::uploadImage($request->file('personal_image'), "specialists/") :
                $specialist->personal_image,
        ];

        $specialist->update($data);
        $specialist->user()->update(['is_specialist' => $request->status,]);
        return redirect()->route('specialists.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialist $specialist)
    {
        if ($specialist->file) {
            $oldImagePath = public_path('uploads/' . $specialist->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        $specialist->deleted_at ? $specialist->restore() : $specialist->delete();
        return redirect()->route('specialists.index');
    }

    public function activate(Specialist $specialist)
    {
        // Update the specialist's status to active
        $specialist->user->update(['is_specialist' => 'true']);
        return redirect()->route('specialists.index');
    }
}
