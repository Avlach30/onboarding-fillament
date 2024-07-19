<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $creator = $this->record->getCreator();

        $this->record->creator_name = $creator->name;
        $this->record->creator_email = $creator->email;
    }
}
