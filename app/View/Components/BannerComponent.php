<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BannerComponent extends Component
{
    public $page_title;
    public $path;
    public $driver;
    /**
     * Create a new component instance.
     */
    public function __construct($pagetitle = null ,$path = null,$driver = null )
    {
        $this->page_title = $pagetitle;
        $this->path = $path;
        $this->driver = $driver;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.banner-component');
    }
}
