<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render(
            'admin/users/Index', 
            [
                'response' => UserResource::collection(User::with('roles')->paginate())
            ]
        );
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
