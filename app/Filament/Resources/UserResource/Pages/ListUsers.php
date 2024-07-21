<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\UserResource;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

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
        $this->guard()->permission(Permission::READ_USER);
    }
}
