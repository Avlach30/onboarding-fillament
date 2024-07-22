<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\Permission;
use App\Filament\Resources\UserResource;
use App\Models\User;
use App\Utils\Guard;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    public function mount(int|string $record): void
    {   
        // Resolve the record
        $this->record = $this->resolveRecord($record);

        // Get the role name from the role_id
        $this->record->role = $this->record->getRole()->name;

        // Get the posts from the user
        $posts = $this->record->getPosts()->toArray();

        // Map the posts to get the title and status
        $this->record->posts = array_map(function($post) {
            return [
                'title' => $post['title'],
                'status' => $post['status'],
            ];
        }, $posts);
    }
}
