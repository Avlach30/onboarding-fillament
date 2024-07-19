<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    public function mount(int|string $record): void
    {   
        // Resolve the record
        $this->record = $this->resolveRecord($record);

        // Get the role name from the role_id
        $this->record->role = $this->record->getRole()->name;
    }
}
