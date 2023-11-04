<?php

namespace App\Utils;

class UtilityFunctions
{
    public static function pick_itm_random($array): mixed
    {
        return $array[array_rand($array)];
    }    
}

?>