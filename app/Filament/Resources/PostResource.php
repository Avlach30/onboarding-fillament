<?php

namespace App\Filament\Resources;

use App\Enums\Permission;
use App\Enums\Status;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use App\Utils\Guard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options(Status::class)
                    ->required(),
                Forms\Components\TagsInput::make('tags')
                    ->placeholder('Add a tag')
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        // Get tags from the record
        $tags = $infolist->record->tags;

        return $infolist
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Informasi Postingan')
                            ->icon('heroicon-o-pencil-square')
                            ->schema([
                                Split::make([
                                    Section::make()
                                        ->schema([
                                            TextEntry::make('title')->weight(FontWeight::Bold),
                                            TextEntry::make('content'),
                                            TextEntry::make('status'),
                                            // Display the tags as a custom component
                                            TextEntry::make('tags')->view('components.arr-to-str', [
                                                'items' => $tags,
                                                'label' => 'Tags',
                                            ]),
                                        ])->grow(false),
                                    Section::make('Tanggal')
                                        ->description('Tanggal dibuat dan diperbaruinya catatan ini')
                                        ->schema([
                                            TextEntry::make('translated_created_at')
                                                ->label('Dibuat pada'),
                                            TextEntry::make('translated_updated_at')
                                                ->label('Diperbarui pada'),
                                        ])
                                        ->grow(false)
                                        ->collapsible(),
                                ]),
                            ]),
                        Tab::make('Informasi Kreator')
                            ->icon('heroicon-o-user')
                            ->schema([
                                TextEntry::make('creator_name')->label('Nama'),
                                TextEntry::make('creator_email')->label('Email'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter the posts by status
                Filters\SelectFilter::make('status')
                    ->options(Status::class),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(
                        function ($record) {
                            $guard = new Guard();

                            // Only creators of the post can edit the post
                            return $guard->isCreator($record->creator_id);
                        }
                ),
                Tables\Actions\DeleteAction::make()
                    ->visible(
                        function ($record) {
                            $guard = new Guard();

                            // Only creators of the post can delete the post
                            return $guard->isCreator($record->creator_id);
                        }
                    )
                    ->before(
                        function ($record) {
                            $guard = new Guard();

                            // Check if the logged in user is the creator of the post
                            $guard->checkCreator($record->creator_id);
                        }
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->before(
                        function ($records) {
                            $guard = new Guard();

                            // Check if the logged in user is the creator of the selected posts
                            foreach ($records as $record) {
                                $guard->checkCreator($record->creator_id);
                            }
                        }
                    ),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
