<?php


namespace App\Interfaces;

interface ServiceInterface
{
    public static function Add($request);
    public static function delete($id);
    public static function update($data,$id);
    public static function getDetail($id);
    public static function List();
}
