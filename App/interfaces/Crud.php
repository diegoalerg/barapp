<?php
namespace App\Interfaces;
defined("APPPATH") OR die("Access denied");
interface Crud
{
    static function getAll();
    static function getById($id); //getByLetter?
    //static function getBytwo($termino,$user);
    static function insert($user);
    static function update($data);
    static function delete($id);
}
?>