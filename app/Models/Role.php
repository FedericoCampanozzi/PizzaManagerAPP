<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $table = 'role';

    use HasFactory;
    protected $appends = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public static function getRoleByName($roleName) : Role
    {
        return Role::all()->where('role_name', $roleName)->first();
    }
}