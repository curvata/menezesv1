<?php

namespace App\Tests\Helper;

trait GenerateText
{
    public function getString(int $length): string
    {
        $characters = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
        $value = "";

        for ($a=0; $a < $length; $a++) {
            $value .= $characters[rand(0, count($characters) -1)];
        }

        return $value;
    }
}