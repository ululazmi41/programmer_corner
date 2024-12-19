<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use function App\Helpers\getTrendingPosts;

class Trending extends Component
{
    public $trendingPosts;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->trendingPosts = getTrendingPosts(3);
    
        foreach ($this->trendingPosts as $post) {
            $post->likesCount = count($post->likes);
            $post->commentsCount = count($post->comments);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.trending');
    }
}
