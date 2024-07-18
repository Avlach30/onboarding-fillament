<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
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
