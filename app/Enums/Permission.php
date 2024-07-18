<?php 

namespace App\Enums;

enum Permission: string {
    case DASHBOARD = 'dashboard';
    case ADD_NEW_PERMISSION = 'add new permission';
    case READ_PERMISSION = 'read permission';
    case EDIT_PERMISSION = 'edit permission';
    case DELETE_PERMISSION = 'delete permission';
    case ADD_NEW_ROLE = 'add new role';
    case READ_ROLE = 'read role';
    case EDIT_ROLE = 'edit role';
    case DELETE_ROLE = 'delete role';
    case ADD_NEW_USER = 'add new user';
    case READ_USER = 'read user';
    case EDIT_USER = 'edit user';
    case DELETE_USER = 'delete user';
    case ADD_NEW_POST = 'add new post';
    case READ_POST = 'read post';
    case EDIT_POST = 'edit post';
    case DELETE_POST = 'delete post';

    public static function getValues(): array {
        // Map the values of the enum to an array
        return array_map(fn($permission) => $permission->value, self::cases());
    }
}