<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Topping;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PizzzaToppingsController extends Controller
{
    public function insert(Pizza $pizza, Topping $topping, Request $request): RedirectResponse
    {

    }
}