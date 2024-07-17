<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ArrToStr extends Component
{

    public array $items;
    public string $label;

    public function __construct(array $items, string $label)
    {
        $this->items = $items;
        $this->label = $label;
    }

    public function render()
    {
        return view('components.arr-to-str');
    }
}
