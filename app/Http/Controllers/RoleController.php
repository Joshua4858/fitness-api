<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{

    // TODO: could potentially add more custom error handling.
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();

        return $this->successResponse($roles, "Successfully retrieved roles", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $validatedData = $request->validated();

        // Create new Role
        $roleData = Role::create($validatedData);

        return $this->successResponse($roleData, 'Successfully created new role : ' . $roleData->name, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        // Can do it like this because of route to model binding
        return $this->successResponse($role, "", 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $validatedData = $request->validated();

        // Find role to update
        $roleToUpdate = Role::findOrFail($role);

        // Update the role where id is role
        $updatedRole = $role->update($validatedData);

        return $this->successResponse($updatedRole, 'Successfully updated role',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(null, 204);
    }
}
