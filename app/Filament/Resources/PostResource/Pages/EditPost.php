<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\PostResource;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function guard()
    {
        return new Guard();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->before(
                function() {
                    // Check if the logged in user is the creator of the post
                    $this->guard()->checkCreator($this->record->creator_id);
                }
            ),
        ];
    }

    // Function for mutating the form data before saving it
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Split the tags string into an array if it exists, otherwise return a null value
        $data['tags'] = $data['tags'] ?? null;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Check if the logged in user is the creator of the post
        $this->guard()->checkCreator($record->creator_id);

        return parent::handleRecordUpdate($record, $data);
    }

    protected function getRedirectUrl(): ?string
    {
        return PostResource::getUrl('index');
    }
}
