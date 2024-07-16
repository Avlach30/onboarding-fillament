<?php

namespace App\Enums;

enum Status: string {
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function getLabel(): string {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
        };
    }
}

