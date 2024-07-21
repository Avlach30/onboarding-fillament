<?php

namespace App\Utils;

use App\Enums\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Guard {
    public function permission(Permission $permission): void {
        // Get the logged in user's ID
        $loggedUserId = auth()->user()->id;

        // Get the user with the role
        $userWithRole = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.id', $loggedUserId)
            ->select(['users.id', 'users.role_id', 'roles.name'])
            ->first();

        // Get the permissions of the user with the role
        $userWithRole->permissions = DB::table('role_has_permissions')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', $userWithRole->role_id)
            ->select('permissions.name')
            ->get();

        // Check if the user has the permission
        $isLoggedUserHasPermission = $userWithRole->permissions->contains('name', $permission->value);

        if (!$isLoggedUserHasPermission) {
            abort(403, 'Forbidden Access');
        }
    }

    public function checkCreator(int $creatorId): void {
        // Get the logged in user's ID
        $loggedUserId = auth()->user()->id;

        if ($loggedUserId !== $creatorId) {
            abort(403, 'Creator ID does not match the logged in user ID');
        }
    }
}