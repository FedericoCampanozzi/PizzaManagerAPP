<?php

namespace App\Utils;

class UtilityFunctions
{
    public static function pick_itm_random($array): mixed
    {
        return $array[array_rand($array)];
    }
    
    public static function get_fake_food(): string
    {
        return UtilityFunctions::pick_itm_random([
            "Bacon",
            "Black olives",
            "Canadian bacon/ham",
            "Chicken",
            "Green peppers",
            "Mushrooms",
            "Pepperoni",
            "Red onions",
            "Sausage",
            "Tomatoes",
            "Cheddar",
            "Mozzarella",
            "Pecorino Romano",
            "Parmesan",
            "Pears",
            "Pineapple",
            "Roasted grapes"
        ]);
    }
}

?>