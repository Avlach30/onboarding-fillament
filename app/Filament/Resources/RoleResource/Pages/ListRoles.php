<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\RoleResource;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // Define the instance of the Guard class
    protected function guard()
    {
        return new Guard();
    }

    public function mount(): void
    {   
        // Check the permission before mounting
        $this->guard()->permission(Permission::READ_ROLE);
    }
}
