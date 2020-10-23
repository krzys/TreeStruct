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
}
