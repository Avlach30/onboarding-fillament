<?php

namespace App\Livewire\App\User;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component;

class Profile extends Component implements HasForms
{   
    use InteractsWithForms; // Import the InteractsWithForms trait for form handling

    public ?string $name = null; // Define the name property
    public ?string $email = null; // Define the email property

    public $user; // Define the user property

    // Get the data for the view from the logged in user
    protected function getViewData(): ?Authenticatable
    {
        return Auth::user();
    }

    // Mount the component and get the user data
    public function mount(): void
    {
        $this->user = Auth::user(); // Get the logged in user
        $this->name = $this->user->name; // Set the name property to the user's name
        $this->email = $this->user->email; // Set the email property to the user's email
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Name')
                ->placeholder('Enter your name')
                ->required(),
            TextInput::make('email')
                ->label('Email')
                ->placeholder('Enter your email')
                ->required()
        ])->columns(1);
    }

    // The view to render
    public function render(): View
    {
        return view('livewire.app.user.profile');
    }

    public function save(): void
    {
        $this->resetErrorBag(); // Reset the error bag to remove any previous errors
        $this->validate(); // Validate the form data

        $this->user->update([ // Update the user data
            'name' => $this->name,
            'email' => $this->email
        ]);

        Notification::make()->success()->title('Update profile successfully')->send(); // Send a success notification
    }
}
