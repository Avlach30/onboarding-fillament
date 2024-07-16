<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;
    
    // Function to mutate the form data before filling the form
    protected function mutateFormDataBeforeFill(array $data): array
    {
        return array_merge($data, [
            // Convert the tags array to a comma-separated string if it exists
            'tags' => $data['tags'] ? implode(',', $data['tags']) : "",
        ]);
    }
}
