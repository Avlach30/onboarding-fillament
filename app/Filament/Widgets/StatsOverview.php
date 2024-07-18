<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Post;

class StatsOverview extends BaseWidget
{   
    protected static $post;
    protected static $user;
    protected static ?int $sort = 2;

    public function __construct()
    {
        self::$post = new Post();
        self::$user = new User();
    }

    protected function getStats(): array
    {   
        return [
            Stat::make('Total Users', self::$user->countData())
                ->description('Total users in app')
                ->descriptionIcon('heroicon-o-user')
                ->color('success'),
            Stat::make('Total Posts', self::$post->countData())
                ->description('Total posts in app')
                ->descriptionIcon('heroicon-o-arrow-up-on-square-stack')
                ->color('primary'),
            Stat::make('Total Inactive Posts', self::$post->countInactives())
                ->description('Total inactive posts in app')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger'),
            Stat::make('Total Active Posts', self::$post->countActives())
                ->description('Total active posts in app')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
        ];
    }
}
