<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeStruct extends Model
{
    use HasFactory;

    protected $table = 'tree_struct';

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

    function children()
    {
        return $this->hasMany('App\Models\TreeStruct', 'parent', 'id');
    }
}
