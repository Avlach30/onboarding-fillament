<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\PostResource;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;

    protected function guard()
    {
        return new Guard();
    }

    public function mount(int|string $record): void
    {
        $this->guard()->permission(Permission::READ_POST);

        $this->record = $this->resolveRecord($record);

        $creator = $this->record->getCreator();

        $this->record->creator_name = $creator->name;
        $this->record->creator_email = $creator->email;
    }
}
