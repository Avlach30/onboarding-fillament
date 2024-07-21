<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\PostResource;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->before(
                function() {
                    $this->guard()->permission(Permission::DELETE_POST);
                }
            ),
        ];
    }

    protected function guard()
    {
        return new Guard();
    }

    public function mountCanAuthorizeAccess(): void
    {
        // Check the permission before mounting
        $this->guard()->permission(Permission::EDIT_POST);
    }
    // Function for mutating the form data before saving it
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Split the tags string into an array if it exists, otherwise return a null value
        $data['tags'] = $data['tags'] ?? null;

        return $data;
    }

    protected function getRedirectUrl(): ?string
    {
        return PostResource::getUrl('index');
    }
}
