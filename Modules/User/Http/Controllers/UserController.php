<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Entities\User;
use Modules\User\Contracts\UserServiceContract;
use Modules\User\Http\Requests\UpdateUserRolesRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends ModuleBaseController
{
    protected $service;

    public function __construct(UserServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = $this->service->index();

        return view('user::index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
    }

    public function updateUserRoles(UpdateUserRolesRequest $request)
    {
        $validatedData = $request->validated();

        return $this->service->updateUserRoles($validatedData);
    }

    /**
     * Remove the specified resource from storage.
     * @param User $user
     * @return void
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $this->service->delete($user);
    }

    public function showForm()
    {
        return view('user::roles.show-form');
    }

    public function storeRoles(Request $request)
    {
        $role= new Role;
        $role ->name = $request->name;
        $role ->label = $request->label;
        $role ->guard_name = $request->guard_name;
        $role ->description = $request->description;
        $role ->save();

        return redirect()->back();
    }
}
