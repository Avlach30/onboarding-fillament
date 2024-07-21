<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\PermissionResource;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionResource::class;

    protected function guard()
    {
        return new Guard();
    }

    public function mountCanAuthorizeAccess(): void
    {
        $this->guard()->permission(Permission::READ_PERMISSION);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
