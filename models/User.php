<?php


namespace models;


use core\Model;

class User extends Model
{
    public $id;
    public $username;
    public $email;

    public static function tableName()
    {
        return 'user';
    }
}