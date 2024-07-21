<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\PermissionResource;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPermission extends EditRecord
{
    protected static string $resource = PermissionResource::class;

    protected function guard()
    {
        return new Guard();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->before(
                function () {
                    // Only allow users with the DELETE_PERMISSION permission to delete permissions
                    $guard = new Guard();

                    $guard->permission(Permission::DELETE_PERMISSION);
                }
            ),
        ];
    }

    public function mountCanAuthorizeAccess(): void
    {
        // Check the permission before mounting
        $this->guard()->permission(Permission::EDIT_PERMISSION);
    }

    protected function getRedirectUrl(): ?string
    {
        return PermissionResource::getUrl('index');
    }
}
