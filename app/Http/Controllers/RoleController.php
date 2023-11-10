<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
    public function edit (User $user): Response
    {
        return Inertia::render('Profile/Partials/EditRole', [
            "edituser" => User::all()->where('id',$user->id)->first(),
            "options" => Role::all()->map(fn($el):string=>$el->role_name)
        ]);
    }

    public function update (Request $request, User $user): Response
    {
        
    }
}