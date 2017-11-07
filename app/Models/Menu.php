<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['pid', 'name', 'icon', 'slug', 'url', 'active', 'description', 'sort'];
}
