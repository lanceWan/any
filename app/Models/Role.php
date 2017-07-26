<?php

namespace App\Models;

use Ultraware\Roles\Models\Role as Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Role extends Model implements Transformable
{
    use TransformableTrait;

}
