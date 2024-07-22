<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\PostResource;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Carbon;

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

        // Define translated data of the created_at and updated_at date to Indonesian
        $this->record->translated_created_at = Carbon::parse($this->record->created_at)->locale('id')->isoFormat('dddd, D MMMM Y');
        $this->record->translated_updated_at = Carbon::parse($this->record->updated_at)->locale('id')->isoFormat('dddd, D MMMM Y');

        $creator = $this->record->getCreator();

        $this->record->creator_name = $creator->name;
        $this->record->creator_email = $creator->email;
    }
}
