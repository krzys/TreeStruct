<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeStruct extends Model
{
    use HasFactory;

    protected $table = 'tree_struct';

    // public $timestamps = false; // PhpStorm treats this as an error
    public function usesTimestamps()
    {
        return false;
    }

    protected $fillable = [
        'name', 'parent', 'display_order'
    ];

    protected $attributes = [
        'parent' => null,
        'display_order' => 1
    ];

    /**
     * @return TreeStruct[]
     */
    public static function getRoots()
    {
        return TreeStruct::whereNull('parent')->orderBy('display_order')->get();
    }

    function hasChildren()
    {
        return $this->children()->exists();
    }

    function getFullName() {
        $name = $this->name;
        if($this->parent != null) {
            $name = TreeStruct::find($this->parent)->getFullName() . ' → ' . $name;
        }

        return $name;
    }

    function children()
    {
        return $this->hasMany('App\Models\TreeStruct', 'parent', 'id')
            ->orderBy('display_order');
    }

    function deleteWithChildren()
    {
        $status = true;
        foreach ($this->children as $child) {
            $status = $status && $child->deleteWithChildren();
        }

        return $status && $this->delete();
    }
}
