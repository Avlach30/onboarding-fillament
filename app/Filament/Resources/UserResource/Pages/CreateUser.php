<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\UserResource;
use App\Models\User;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // Define the instance of the Guard class
    protected function guard()
    {
        return new Guard();
    }

    public function mount(): void
    {
        // Check the permission before mounting
        $this->guard()->permission(Permission::ADD_NEW_USER);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {   
        // Add the role_id to the data array
        return array_merge($data, [
            'role_id' => $data['role'],
        ]);
    }

    protected function handleRecordCreation(array $data): Model | User
    {
        // Create the user
        $user = User::create($data);
        // Get the role and related permissions
        $role = Role::findById($data['role_id']);
        $permissions = $role->permissions->pluck('name')->toArray();

        // Assign the role to the user
        $user->assignRole($role->name);

        // Assign the permissions to the user
        $user->givePermissionTo($permissions);

        // Return the created user
        return $user;
    }

    protected function getRedirectUrl(): string
    {
        return UserResource::getUrl('index');
    }
}
