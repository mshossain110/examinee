<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Spatie\Permission\Models\Permission;

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
        return Inertia::render('admin/roles/Create', [
            'permissions' => Permission::all(['id', 'name'])->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string',
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return to_route('admin.roles.edit', $role)
            ->with('success', "Role '{$role->name}' created successfully.");
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
        return Inertia::render('admin/roles/Edit', [
            'role'        => new RoleResource($role->load('permissions')),
            'permissions' => Permission::all(['id', 'name'])->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'          => 'required|string',
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return to_route('admin.roles.edit', $role)
            ->with('success', "Role '{$role->name}' updated successfully.");
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
