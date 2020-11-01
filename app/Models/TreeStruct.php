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
        'name', 'parent'
    ];

    protected $attributes = [
        'parent' => null
    ];

    /**
     * @return TreeStruct[]
     */
    public static function getRoots()
    {
        return TreeStruct::whereNull('parent')->orderBy('id')->get();
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
        return $this->hasMany('App\Models\TreeStruct', 'parent', 'id');
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
