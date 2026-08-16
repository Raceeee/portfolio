<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::firstOrCreate(['id' => 1], ['full_name' => 'Your Name']);

        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'full_name'    => ['required', 'string', 'max:255'],
            'role_title'   => ['nullable', 'string', 'max:255'],
            'location'     => ['nullable', 'string', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:50'],
            'email'        => ['nullable', 'email', 'max:255'],
            'objective'    => ['nullable', 'string'],
            'case_number'  => ['nullable', 'string', 'max:100'],
            'status'       => ['nullable', 'string', 'max:50'],
            'github_url'   => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
        ]);

        $profile = Profile::firstOrCreate(['id' => 1]);
        $profile->update($data);

        return redirect()->route('admin.profile.edit')->with('status', 'Profile updated.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'          => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->string('password'));
        $user->save();

        return redirect()->route('admin.profile.edit')->with('status', 'Password updated.');
    }
}