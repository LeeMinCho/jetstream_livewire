<?php

namespace App\Http\Livewire;

use Illuminate\Support\Str;
use App\Models\NavigationMenu;
use Livewire\WithPagination;
use Livewire\Component;

class NavigationMenus extends Component
{
    use WithPagination;

    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $modelId;
    public $label;
    public $slug;
    public $sequence = 1;
    public $type = 'SidebarNav';

    public function read()
    {
        return NavigationMenu::paginate(5);
    }

    public function updatedLabel($value)
    {
        $this->slug = Str::slug($value);
    }

    public function rules()
    {
        return [
            'label' => 'required',
            'slug' => 'required',
            'sequence' => 'required',
            'type' => 'required',
        ];
    }

    public function createShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
    }

    public function create()
    {
        $this->validate();
        NavigationMenu::create($this->modelData());
        $this->modalFormVisible = false;
        $this->reset();
        $this->resetPage();
    }

    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
        $this->modelId = $id;
        $this->loadModel();
    }

    public function update()
    {
        $this->validate();
        // dd([$this->modelId, $this->slug, $this->type]);
        NavigationMenu::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false;
        $this->reset();
        $this->resetPage();
    }

    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
    }

    public function delete()
    {
        NavigationMenu::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

    private function loadModel()
    {
        $data = NavigationMenu::find($this->modelId);
        $this->label = $data->label;
        $this->slug = $data->slug;
        $this->type = $data->type;
        $this->sequence = $data->sequence;
    }

    private function modelData()
    {
        return [
            'label' => $this->label,
            'slug' => $this->slug,
            'sequence' => $this->sequence,
            'type' => $this->type,
        ];
    }

    public function render()
    {
        return view('livewire.navigation-menus', [
            'data' => $this->read()
        ]);
    }
}
