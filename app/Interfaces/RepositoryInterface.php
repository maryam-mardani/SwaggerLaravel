<?php


namespace App\Interfaces;

interface RepositoryInterface
{
    public static function findByField($field,$value);
    public static function NewItem($data);
    public static function UpdateItem($data,$id);
    public static function Remove($id);
    public static function Index();
}
