<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
/*не смог сделать "хлебные крошки"*/
class Breadcrumbs extends Component
{
    public $breadcrumbs;

    public function __construct($breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    public function render()
    {
        return view('components.breadcrumbs');
    }
}
