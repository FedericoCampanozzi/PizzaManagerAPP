<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Topping;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function dashboard(): Response
    {
        return Inertia::render('Dashboards/Dashboard');
    }

    public function admin(): Response
    {
        $sql_1 = "
                select  *
                from    users
                where   fk_role = ?
        ";
        $sql_2 = "
                select  fk_chef, users.name, weekofyear(pizzas.ordered) as nr_week, count(*) as nr_pizzas
                from    pizzas inner join users on pizzas.fk_chef = users.id
                where   year(pizzas.ordered) = 2023 and fk_chef = ?
                group   by fk_chef, users.name, weekofyear(pizzas.ordered)
                order   by fk_chef, users.name, weekofyear(pizzas.ordered) DESC
        ";

        $chef_wd = [];
        foreach(DB::select($sql_1, [2]) as $chef){
            array_push($chef_wd, (object)[
                "label" => $chef->name,
                "data" => (new Collection(DB::select($sql_2, [$chef->id])))->map(fn($e):int => $e->nr_pizzas)->toArray(),
                "borderColor" => $chef->color,
                "backgroundColor" => $chef->color.'ff'
            ]);
        }

        $chef_md = [];
        $chef_md_stack = [];
        foreach(DB::select($sql_1, [2]) as $chef){
            array_push($chef_md, (object)[
                "label" => $chef->name,
                "data" => (new Collection(DB::select($sql_2, [$chef->id])))->map(fn($e):int => $e->nr_pizzas)->toArray(),
                "borderColor" => $chef->color,
                "backgroundColor" => $chef->color.'ff'
            ]);
            array_push($chef_md_stack, (object)[
                "label" => $chef->name,
                "data" => (new Collection(DB::select($sql_2, [$chef->id])))->map(fn($e):int => $e->nr_pizzas)->toArray(),
                "borderColor" => $chef->color,
                "backgroundColor" => $chef->color.'ff',
                "stack" => 'first'
            ]);
        }
        
        $sql_3 = "
                    select 
                            concat(users.id, ' - ', users.name, ' ( ', role.role_name, ' )') as title, 
                            holidays_start as start, 
                            holidays_end as end,
                            color,
                            'true' as allDay,
                            'true' as stick
                    from    users inner join role on users.fk_role = role.id
                    where   (fk_role = 3 or fk_role = 2) and holidays_start is not null and holidays_end is not null
            ";

        return Inertia::render('Dashboards/Admin',[
            "users" => User::all(),
            "chef_weekly_data" => $chef_wd,
            "chef_weekly_labels" => range(1, 53),
            "chef_monthly_data" => $chef_md,
            "chef_monthly_labels" => range(1, 12),
            "chef_monthly_data_stack" => $chef_md_stack,
            "chef_monthly_labels_stack" => range(1, 12),
            "holidays" => DB::select($sql_3)
        ]);
    }

    public function guest(User $user): Response
    {
        return Inertia::render('Dashboards/Guest', [
            "pizzas" => Pizza::all()->where("fk_client", $user->id)->flatten()->toArray(),
            "all_toppings" => Topping::all()->toArray(),
            "all_crusts" => (new Collection(Pizza::getCrustSizes()))->map(fn($e) => (object)[
                "sid" => $e 
            ])->toArray(),
            "all_sizes" => (new Collection(Pizza::getSizes()))->map(fn($e) => (object)[
                "sid" => $e 
            ])->toArray()
        ]);
    }

    public function chef(User $user): Response
    {
        $sql =  "
                    select id, size, crust, client, ordered, pizzastatus
                    from pizzasinfocomplete 
                    where (fk_pizzastatus is null or fk_chef is null or fk_chef = ?) and fk_pizzastatus <> 3
                ";
        return Inertia::render('Dashboards/Worker', [
            "isChefPage" => true,
            "pizzas" => DB::select($sql, [$user->id])
        ]);
    }

    public function deliveryman(User $user): Response
    {
        $sql = "
                    select id, client, ordered, deliverystatus 
                    from pizzasinfocomplete 
                    where (fk_pizzastatus = 3 and fk_pizzastatus <> 6 and (fk_deliveryman is null or fk_deliveryman = ?))
                    order by fk_deliveryman ASC
                ";
        return Inertia::render('Dashboards/Worker', [
            "isChefPage" => false,
            "pizzas" => DB::select($sql, [$user->id])
        ]);
    }
}