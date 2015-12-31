<?php

namespace BlackfyreStudio\CRUD\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    public function givePermission(Permission $permission) {
        return $this->permissions()->save($permission);
    }
}
