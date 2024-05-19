<?php
namespace App\Services;

class ArabicToPershion
{

    static function change($title) : string {
        $title=str_replace("ي","ی",$title);
        $title=str_replace("ك","ک",$title);
        return  $title;
    }


}
