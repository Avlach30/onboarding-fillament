<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\UserResource;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // Define the instance of the Guard class
    protected function guard()
    {
        return new Guard();
    }

    public function mount(): void
    {
        // Check the permission before mounting
        $this->guard()->permission(Permission::ADD_NEW_USER);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {   
        // Add the role_id to the data array
        return array_merge($data, [
            'role_id' => $data['role'],
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return UserResource::getUrl('index');
    }
}
