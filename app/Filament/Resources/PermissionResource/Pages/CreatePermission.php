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

    protected function getRedirectUrl(): string
    {
        return PermissionResource::getUrl('index');
    }
}
