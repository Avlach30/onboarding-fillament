<?php

namespace App\Utils;

use App\Enums\Permission;
use App\Models\User;

class Guard {
    public function permission(Permission $permission): void {
        // Get the logged in user's ID
        $loggedUserId = auth()->user()->id;

        // Create an instance of the User model
        $userModelInstance = new User();

        // Check if the logged in user has the permission to add new users
        $isLoggedUserHasPermission = $userModelInstance->isIdHasPermission($loggedUserId, $permission);

        if (!$isLoggedUserHasPermission) {
            abort(403, 'Forbidden Access');
        }
    }
}