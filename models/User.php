<?php


namespace models;


use core\Model;

class User extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $status;

    public static function tableName()
    {
        return 'user';
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    public function checkPassword($password)
    {
        return password_verify($password, $this->password);
    }
}