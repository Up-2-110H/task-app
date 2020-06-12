<?php


namespace models;


use core\FM;
use core\Model;

class Task extends Model
{
    public $id;
    public $user_id;
    public $text;
    public $status;
    public $edited;

    public static function tableName()
    {
        return 'task';
    }

    public static function findAsArray($sort, $sort_type, $limit, $offset)
    {
        $sql =
            'select ' .
            self::tableName() . '.id, ' .
            User::tableName() . '.username, ' .
            User::tableName() . '.email, ' .
            self::tableName() . '.text, ' .
            self::tableName() . '.status, ' .
            self::tableName() . '.edited ' .
            'from ' . self::tableName() . ' ' .
            'left join ' . User::tableName() . ' ' .
            'on ' . User::tableName() . '.id = ' . self::tableName() . '.user_id ' .
            'order by ' . $sort . ' ' . $sort_type . ' ' .
            'limit ' . $limit . ' ' .
            'offset ' . $offset . ';';

        $data = FM::$app->getDb()->query($sql);

        return $data->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function count()
    {
        $sql = 'select count(*) from ' . self::tableName() . ';';
        $data = FM::$app->getDb()->query($sql);
        return $data->fetchColumn();
    }
}