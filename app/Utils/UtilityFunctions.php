<?php

namespace App\Utils;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;

class UtilityFunctions
{
    public static function pick_itm_random($array): mixed
    {
        return $array[array_rand($array)];
    }
    
    public static function get_fake_food(): string
    {
        return UtilityFunctions::pick_itm_random([
            "Blue cheese",
            "Burrata",
            "Cheddar",
            "Cream cheese",
            "Feta",
            "Garganzola",
            "Goat cheese",
            "Gouda",
            "Gruyere",
            "Haloumi",
            "Havarti",
            "Mozzarella",
            "Parmesan",
            "Pecorino Romano",
            "Provolone",
            "Ricotta",
            "Anchovies",
            "Bacon",
            "Canadian Bacon",
            "Chicken",
            "Clams",
            "Crab",
            "Ground Beef",
            "Ground Sausage",
            "Ham",
            "Meatballs",
            "Pancetta",
            "Pepperoni",
            "Prosciutto",
            "Salami",
            "Salmon",
            "Scallops",
            "Shredded Pork",
            "Shrimp",
            "Sliced Sausage",
            "Steak",
            "Arugala",
            "Asparagus",
            "Bell peppers",
            "Black olives",
            "Broccoli",
            "Brussel sprouts",
            "Chili peppers",
            "Eggplant",
            "Garlic",
            "Giardiniera",
            "Green olives",
            "Green Olives",
            "Green Onions",
            "Green Peppers",
            "Habanero peppers",
            "Jalapenos",
            "Kale",
            "Mushrooms",
            "Pepperoncini",
            "Potatoes",
            "Red Onions",
            "Rhubarb",
            "Spinach",
            "Squash",
            "Sun-dried tomatoes",
            "Tomatoes",
            "Zucchini",
            "Bananas",
            "Blackberries",
            "Blueberries",
            "Figse",
            "Grapes",
            "Mango",
            "Oranges",
            "Peaches",
            "Pears",
            "Pineapple",
            "Plums",
            "Raspberries",
            "Strawberries",
            "Basil",
            "Cilantro",
            "Fennel",
            "Garlic",
            "Oregano",
            "Paprika",
            "Parsley",
            "Pepper",
            "Rosemary",
            "Sage",
            "Thym",
        ]);
    }

    public static function insert_static_data(string $class, array $data): bool
    {
        try {
            if($class == User::class) {
                $u = new User();
                $u->name = $data['name'];
                $u->email = $data['email'];
                $u->fk_role = $data['fk_role'];
                $u->password = $data['password'];
                $u->remember_token = $data['remember_token'];
                $u->color = $data['color'];
                $u->save();
            } else if ($class == Role::class) {
                $r = new Role();
                $r->role_name = $data['role_name'];
                $r->save();
            } else if ($class == Status::class) {
                $s = new Status();
                $s->name = $data['name'];
                $s->isPizzaStatus = $data['isPizzaStatus'];
                $s->sequence = $data['sequence'];
                $s->save();
            }
        } catch (Exception) {
            return false;
        } finally {
            return true;
        }
    }
}

?>