<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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

    public function checkIfValid()
    {
        $validator = Validator::make([
            'name' => $this->name,
            'parent' => $this->parent
        ], [
            'name' => ['required', 'min:1', 'max:255'],
            'parent' => ['exists:App\Models\TreeStruct,id', 'nullable']
        ])->validate();

        return !$validator->fails();
    }

    public function edit($id)
    {
        if($this->mode == 'edit') {
            if($this->checkIfValid()) {
                $element = \App\Models\TreeStruct::find($id);
                $element->name = $this->name;
                $element->parent = $this->parent;
                $element->save();

                $this->cancel();
            }
        } else {
            $this->mode = 'edit';

            $element = \App\Models\TreeStruct::find($id);
            $this->element_id = $id;
            $this->name = $element->name;
            $this->fullName = $element->getFullName();
            $this->parent = $element->parent;
        }
    }

    public function move(int $id, int $order)
    {
        DB::unprepared("CALL change_tree_struct_element_order($id, $order);");
    }

    public function cancel()
    {
        $this->mode = null;
        $this->resetInputFields();
    }

    public function add($parent = null)
    {
        if($this->mode == 'add') {
            if($this->checkIfValid()) {
                $element = new \App\Models\TreeStruct;
                $element->name = $this->name;
                $element->parent = $this->parent ?: null;
                $element->save();

                $this->cancel();
            }
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
