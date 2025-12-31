<?php

namespace App\Livewire;

use Livewire\Component;

class NavigationMenu extends Component
{

    public $role;

    public function mount($role = null)
    {
        $this->role = $role;
    }
    public function render()
    {
        return view('navigation-menu', [
            'role' => $this->role,
        ]);
    }
}
