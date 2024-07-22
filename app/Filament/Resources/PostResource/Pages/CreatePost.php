<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\PostResource;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

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
        $loggedUserId = auth()->user()->id;

        $data['creator_id'] = $loggedUserId;

        return $data;
    }
}
