<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = [
            'users' => User::with('tenant')->
                where('id', '!=', Auth::user()->id)->get(),
            'page' => 'Users Management'
        ];
        return view('super_admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = [
            'page' => 'Create New User',
            'religions' => [
                'Islam',
                'Kristen',
                'Katholik',
                'Hindu',
                'Buddha',
                'Konghucu',
            ],
            'genders' => [
                'Laki-laki',
                'Perempuan',
            ],
            'roles' => Role::where('name', '!=', 'Super-Admin')->get(),
            'tenants' => Tenant::select('id', 'name', 'npsn')->get(),
        ];
        return view('super_admin.user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        DB::transaction(function () use ($request) {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('1234'),
                'tenant_id' => $request->tenant,
            ]);

            $user->syncRoles($request->roles);

            $user->profile()->create([
                'name' => $request->name,
                'nip_nis' => $request->nip_nis,
                'birth_date' => $request->birthdate,
                'religion' => $request->religion,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        });
        return redirect()->route('super_admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = [
            'page' => 'Edit User',
            'user' => User::with('profile', 'roles')->findOrFail($id),
            'religions' => [
                'Islam',
                'Kristen',
                'Katholik',
                'Hindu',
                'Buddha',
                'Konghucu',
            ],
            'genders' => [
                'Laki-laki',
                'Perempuan',
            ],
            'tenants' => Tenant::select('id', 'name', 'npsn')->get(),
            'roles' => Role::where('name', '!=', 'Super-Admin')->get(),
        ];
        return view('super_admin.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
