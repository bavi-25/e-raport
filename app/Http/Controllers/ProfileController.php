<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        $name = $profile->name ?? $user->name;
        $email = $user->email;

        $memberSince = Carbon::parse($user->created_at)->format('F Y');

        $roles = collect($user->roles ?? [])
            ->map(fn($r) => is_string($r) ? $r : ($r->name ?? $r->slug ?? ''))
            ->filter()
            ->map(function ($r) {
                $r = str_replace(['_', '-'], ' ', $r);
                return ucwords(trim($r));
            })
            ->unique()
            ->values()
            ->toArray();

        $roleString = implode(', ', $roles);

        $teacherRoles = ['Guru', 'Wali Kelas', 'Kepala Sekolah', 'Admin', 'Super Admin'];
        $isTeacher = collect($roles)->contains(fn($r) => in_array($r, $teacherRoles, true));
        $isSiswa = collect($roles)->contains('Siswa');

        $roleType = 'lainnya';
        if ($isTeacher) {
            $roleType = 'teacher';
        } elseif ($isSiswa) {
            $roleType = 'siswa';
        }

        return view('profile.index', [
            'page' => 'Profile Info',
            'user' => $user,
            'profile' => $profile,
            'name' => $name,
            'email' => $email,
            'roles' => $roleString,
            'roleType' => $roleType,
            'memberSince' => $memberSince,
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Current password is required',
            'new_password.required' => 'New password is required',
            'new_password.min' => 'New password must be at least 8 characters',
            'new_password.confirmed' => 'Password confirmation does not match',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password has been changed successfully');
    }
}