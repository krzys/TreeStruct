<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TreeStruct extends Component
{
    public $roots, $element_id, $name, $fullName, $parent, $elements;
    public $mode = null;

    public function render()
    {
        $this->roots = \App\Models\TreeStruct::getRoots();
        $this->elements = \App\Models\TreeStruct::all();

        return view('livewire.tree-struct');
    }

    private function resetInputFields(){
        $this->name = '';
        $this->parent = null;
    }

    public function edit($id)
    {
        if($this->mode == 'edit') {
            $element = \App\Models\TreeStruct::find($id);
            $element->name = $this->name;
            $element->parent = $this->parent;
            $element->save();

            $this->cancel();
        } else {
            $this->mode = 'edit';

            $element = \App\Models\TreeStruct::find($id);
            $this->element_id = $id;
            $this->name = $element->name;
            $this->fullName = $element->getFullName();
            $this->parent = $element->parent;
        }
    }

    public function cancel()
    {
        $this->mode = null;
        $this->resetInputFields();
    }

    public function add($parent = null)
    {
        if($this->mode == 'add') {
            $element = new \App\Models\TreeStruct;
            $element->name = $this->name;
            $element->parent = $this->parent ?: null;
            $element->save();

            $this->cancel();
        } else {
            $this->mode = 'add';
            $this->parent = $parent;
        }
    }

    public function delete($id)
    {
        if($this->mode == 'delete') {
            \App\Models\TreeStruct::find($id)->deleteWithChildren();

            $this->cancel();
        } else {
            $this->mode = 'delete';

            $element = \App\Models\TreeStruct::find($id);
            $this->element_id = $id;
            $this->name = $element->name;
            $this->fullName = $element->getFullName();
        }
    }
}
