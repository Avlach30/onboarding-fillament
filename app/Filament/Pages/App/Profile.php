<?php

namespace App\Filament\Pages\App;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Profile extends Page
{   
    // The view to render
    protected static string $view = 'filament.pages.app.profile';

    protected static bool $shouldRegisterNavigation = false; // This will hide the page from the navigation

    // The title of the page
    protected static ?string $title = 'Profile Page';

    // Get the data for the view from the logged in user
    protected function getViewData(): array
    {
        return [
            'user' => Auth::user(),
        ];
    }
}
