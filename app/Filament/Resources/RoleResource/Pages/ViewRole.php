<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\RoleResource;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRole extends ViewRecord
{
    protected static string $resource = RoleResource::class;

    // Define the instance of the Guard class
    protected function guard()
    {
        return new Guard();
    }
    
    public function mount(int|string $record): void
    {
        // Check the permission before mounting
        $this->guard()->permission(Permission::READ_ROLE);

        $this->record = $this->resolveRecord($record);

        $this->record->permissions = $this->record->permissions->pluck('name')->toArray();
    }
}
