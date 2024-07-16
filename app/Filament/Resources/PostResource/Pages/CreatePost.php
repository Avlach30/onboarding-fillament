<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{   
    protected static string $resource = PostResource::class;

    // Redirect to the index page after creating a new post
    protected function getRedirectUrl(): string
    {
        return PostResource::getUrl('index');
    }

    // Function for mutating the form data before saving it
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Split the tags string into an array if it exists, otherwise return a null value
        $data['tags'] = $data['tags'] ? explode(',', $data['tags']) : null;

        return $data;
    }
}
