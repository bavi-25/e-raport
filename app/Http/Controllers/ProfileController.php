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

        // Format member since date
        $memberSince = Carbon::parse($user->created_at)->format('F Y');

        // Get roles
        $roles = collect($user->roles ?? [])
            ->map(fn($r) => is_string($r) ? $r : ($r->name ?? $r->slug ?? ''))
            ->filter()
            ->map(fn($r) => ucwords(str_replace(['_', '-'], ' ', $r)))
            ->unique()
            ->values()
            ->toArray();

        $roleString = implode(', ', $roles);

        // Determine role type for NIP/NIS label
        $roleType = 'student'; // default
        if (!empty($roles)) {
            $firstRole = strtolower($roles[0]);
            if (strpos($firstRole, 'teacher') !== false || strpos($firstRole, 'admin') !== false) {
                $roleType = 'teacher';
            }
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

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect');
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password has been changed successfully');
    }
}