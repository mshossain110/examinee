<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render(
            'admin/roles/Index', 
            [
                'response' => RoleResource::collection(Role::with('permissions')->paginate()),
                'app_roles' => Role::appRoles()
            ]
        );
    }

    /**        
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/roles/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $data = $request->only([
            'name',
            
        ]);

        $role = Role::create($data);


        return Inertia::render('admin/roles/Edit', [ 'role' => new RoleResource($role) ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return Inertia::render('admin/roles/Edit', [ 'role' => new RoleResource($role) ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string'
        ]);

        $data = $request->all();

        $role = $role->update($data);

        return Inertia::render('admin/roles/Edit', [ 'role' => new RoleResource($role) ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if(collect([Role::SUPERADMIN, Role::ADMIN])->contains($role->name)){
            // exception not possible
        }

        $role->delete();

        return to_route('admin.roles.index');
    }
}
