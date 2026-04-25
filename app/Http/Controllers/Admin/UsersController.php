<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use Inertia\Inertia;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('roles')
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = '%' . $request->search . '%';
                $q->where(function ($q2) use ($search) {
                    $q2->where('name', 'like', $search)
                       ->orWhere('email', 'like', $search)
                       ->orWhere('firstname', 'like', $search)
                       ->orWhere('lastname', 'like', $search);
                });
            })
            ->when($request->filled('role'), function ($q) use ($request) {
                $q->whereHas('roles', fn ($q2) => $q2->where('name', $request->role));
            });

        return Inertia::render('admin/users/Index', [
            'response' => UserResource::collection($query->paginate()->withQueryString()),
            'roles'    => RoleResource::collection(Role::all()),
            'filters'  => $request->only(['search', 'role']),
        ]);
    }

    /**        
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/users/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();

        $data = $request->only([
            'firstname',
            'lastname',
            'name',
            'email',
            'password',
            'role',
            'avatar'
        ]);

        $user = User::create($data);

        return Inertia::render('admin/users/Edit', [ 'user' => new UserResource($user) ]);
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
    public function edit(User $user)
    {
        return Inertia::render('admin/users/Edit', [ 'user' => new UserResource($user) ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $validated = $request->validated();

        $data = $request->only([
            'firstname',
            'lastname',
            'name',
            'email',
            'password',
            'role',
            'avatar',
            'permissions',
            'status'
        ]);

        $user = $user->update($data);
        
        return Inertia::render('admin/users/Edit', [ 'user' => new UserResource($user) ]);

        
    }

    /**
     * Sync roles for a user.
     */
    public function syncRoles(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'roles'   => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        $user->syncRoles($request->roles ?? []);

        return back()->with('success', "Roles updated for {$user->name}.");
    }

    /**
     * Delete multiple users at once.
     */
    public function bulkDelete(Request $request)
    {
        $this->authorize('delete', User::class);

        $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:users,id'],
        ]);

        $authId = auth()->id();
        User::whereIn('id', $request->ids)
            ->where('id', '!=', $authId)
            ->delete();

        return back()->with('success', 'Selected users deleted.');
    }

    /**
     * Sync roles for multiple users at once.
     */
    public function bulkSyncRoles(Request $request)
    {
        $this->authorize('update', User::class);

        $request->validate([
            'ids'     => ['required', 'array'],
            'ids.*'   => ['integer', 'exists:users,id'],
            'roles'   => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        User::whereIn('id', $request->ids)->each(
            fn (User $user) => $user->syncRoles($request->roles ?? [])
        );

        return back()->with('success', 'Roles synced for selected users.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->is(auth()->user())) {
            return $this->errorUnauthorized('You can\'t delete for yourself and other Administrators!');
        }

        $user->delete();

        return to_route('admin.users.index');
    }
}
