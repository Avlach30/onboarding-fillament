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

    public static function getValues(): array {
        // Map the values of the enum to an array
        return array_map(fn($status) => $status->value, self::cases());
    }
}

