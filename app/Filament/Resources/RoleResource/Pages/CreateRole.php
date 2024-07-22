<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Enums\Permission as EnumsPermission;
use App\Filament\Resources\RoleResource;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected static $permissionIds = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        self::$permissionIds = array_map('intval', $data['permissions']);

        return [
            'name' => $data['name'],
            'guard_name' => 'web',
        ];
    }

    protected function handleRecordCreation(array $data): Model|Role
    {
        // Create the role
        $role = Role::create($data);

        // Assign the permissions to the role
        $role->permissions()->attach(self::$permissionIds);

        return $role;
    }

    protected function getRedirectUrl(): string
    {
        return RoleResource::getUrl('index');
    }
}
