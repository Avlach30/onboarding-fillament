<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\RoleResource;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;
    protected static $oldPermissionIds = [];
    protected static $permissionIds = [];

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // Define the instance of the Guard class
    protected function guard()
    {
        return new Guard();
    }

    public function mountCanAuthorizeAccess(): void
    {   
        // Check the permission before mounting
        $this->guard()->permission(Permission::EDIT_ROLE);
    }

    // Mutate the form data before filling the form
    protected function mutateFormDataBeforeFill(array $data): array
    {
        self::$oldPermissionIds = $this->record->permissions->pluck('id')->toArray();

        return [
            'name' => $data['name'],
            'permissions' => self::$oldPermissionIds, // Get the permission ids
        ];
    }

    // Mutate the form data before saving the form
    protected function mutateFormDataBeforeSave(array $data): array
    {
        self::$permissionIds = array_map('intval', $data['permissions']);

        return [
            'name' => $data['name'],
        ];
    }

    protected function afterSave(): void
    {
        $role = $this->record;
        
        // Delete the old permissions
        $role->permissions()->sync(self::$oldPermissionIds);

        // Attach the new permissions
        $role->permissions()->attach(self::$permissionIds);
    }

    protected function getRedirectUrl(): ?string
    {
        return RoleResource::getUrl('index');
    }
}
