<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\User;
use App\Models\UserAuthentication;
use App\Services\Service;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        $data['admins'] = User::whereIn('role_id', [1, 2])->get();
        return view("dashboard.admins.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.admins.index");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
        $imageName = Service::uploadImage($request->image, 'users\\');
        $user = User::create(array_merge($request->validated(), [
            'role_id' => 2,
            'image' => $imageName,
        ]));
        UserAuthentication::create([
            'user_id' => $user->id,
            'email_verified_at' => now(),
        ]);
        return redirect(url('dashboard/admins'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $admin)
    {
        return view("dashboard.admins.index", get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, User $admin)
    {

        $oldImage = $admin->image;
        $imageName = Service::uploadImage($request->image, 'users/');
        if ($imageName && $oldImage) {
            $oldImagePath = public_path('uploads/' . $oldImage);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Update the user's information
        $admin->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => $request->password ?? $admin->password,
            'image'    => $imageName ?? $admin->image,
        ]);

        return redirect(url('dashboard/admins'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->deleted_at ? $user->restore() : $user->delete();
        return redirect()->route('admins.index');
    }
}
