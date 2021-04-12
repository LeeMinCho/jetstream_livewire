<?php

namespace App\Http\Livewire;

use App\Models\NavigationMenu;
use Livewire\WithPagination;
use Livewire\Component;

class NavigationMenus extends Component
{
    use WithPagination;

    public $modalFormVisible;
    public $modelId;
    public $label;
    public $slug;
    public $sequence = 1;
    public $type = 'SidebarNav';

    public function read()
    {
        return NavigationMenu::paginate(5);
    }

    public function createShowModal()
    {
        $this->modalFormVisible = true;
    }

    public function render()
    {
        return view('livewire.navigation-menus', [
            'data' => $this->read()
        ]);
    }
}
