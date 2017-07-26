<?php

namespace App\Models;

use Ultraware\Roles\Models\Permission as Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
class Permission extends Model implements Transformable
{
    use TransformableTrait;

}