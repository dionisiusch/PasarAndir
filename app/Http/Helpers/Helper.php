<?php

namespace App\Http\Helpers;

class Helper
{
    public function price_decoder(String $price) {
        $_explodePrice = explode(' ' , $price);

        if (isset($_explodePrice[1])) {
            $result = preg_replace('/[^0-9]/', '', $_explodePrice[1]);
        } else {
            $result = preg_replace('/[^0-9]/', '', $_explodePrice[0]);
        }
        
        return (int) $result;
    }
}

