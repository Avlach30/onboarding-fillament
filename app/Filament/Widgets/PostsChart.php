<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Post;

class PostsChart extends ChartWidget
{
    protected static $post;
    protected static ?string $heading = 'Posts Chart';
    protected static ?int $sort = 3;

    public function __construct()
    {
        self::$post = new Post();
    }

    protected function getData(): array
    {
        return [
            'labels' => ['Active Posts', 'Inactive Posts'],
            'datasets' => [
                [
                    'label' => 'Posts',
                    'data' => [self::$post->countActives(), self::$post->countInactives()],
                    'backgroundColor' => ['#3490dc', '#f6993f'],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
