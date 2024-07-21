<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\PermissionResource;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePermission extends CreateRecord
{
    protected static string $resource = PermissionResource::class;

    protected function guard()
    {
        return new Guard();
    }

    public function mountCanAuthorizeAccess(): void
    {
        // Check the permission before mounting
        $this->guard()->permission(Permission::ADD_NEW_PERMISSION);
    }

    protected function getRedirectUrl(): string
    {
        return PermissionResource::getUrl('index');
    }
}
