<?php

namespace App\Enums;

enum Role: string {
    case SUPER_ADMIN = 'super admin';
    case ADMIN_USER_MANAGEMENT = 'admin user management';
    case ADMIN_POST_MANAGEMENT = 'admin post management';

    public static function getValues(): array {
        // Map the values of the enum to an array
        return array_map(fn($role) => $role->value, self::cases());
    }
}