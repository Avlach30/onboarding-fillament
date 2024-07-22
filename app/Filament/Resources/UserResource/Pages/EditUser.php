<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\UserResource;
use App\Models\User;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    // Define the instance of the Guard class
    protected function guard()
    {
        return new Guard();
    }

    public function mountCanAuthorizeAccess(): void
    {   
        // Check the permission before mounting
        $this->guard()->permission(Permission::EDIT_USER);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return array_merge($data, [
            'role' => $data['role_id'],
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return array_merge($data, [
            'role_id' => $data['role'],
        ]);
    }

    protected function handleRecordUpdate(Model|User $record, array $data): Model|User
    {   
        // Get the role and related permissions
        $role = Role::findById($data['role_id']);
        $permissions = $role->permissions->pluck('name')->toArray();

        // Update the user
        $record->update($data);

        // Sync the roles and permissions
        $record->syncRoles($role->name);
        $record->syncPermissions($permissions);

        // Return the updated user
        return $record;
    }

    protected function getRedirectUrl(): ?string
    {
        return UserResource::getUrl('index');
    }
}
