<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory;

    protected $appends = [
        'children',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getChildrenAttribute()
    {
        return Permission::where('top_id', $this->id)->get();
    }
}
