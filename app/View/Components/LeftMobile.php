<?php

namespace App\View\Components;

use App\Models\Corner;
use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class LeftMobile extends Component
{
    public $corners;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->corners = Corner::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.left-mobile');
    }
}
