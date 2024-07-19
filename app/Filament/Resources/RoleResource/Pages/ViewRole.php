<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRole extends ViewRecord
{
    protected static string $resource = RoleResource::class;
    
    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->record->permissions = $this->record->permissions->pluck('name')->toArray();
    }
}
