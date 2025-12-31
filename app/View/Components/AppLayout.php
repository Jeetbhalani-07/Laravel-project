<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public $role;

    public function __construct($role = null)
    {
        $this->role = $role;
    }
    public function render(): View
    {
        
        return view('layouts.app',["role"=>$this->role]);
    }
}
