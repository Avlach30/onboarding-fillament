<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\PostResource;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function guard()
    {
        return new Guard();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
