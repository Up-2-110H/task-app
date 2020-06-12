<?php


namespace controllers;


use core\Migration;

class MigrationController
{

    public static function access()
    {
        return [
            'actionDown' => '$',
        ];
    }

    public function actionCreate($migrationName)
    {
        $result = Migration::create($migrationName);
        return $result === true ? 'created' : $result;
    }

    public function actionUp()
    {
        return Migration::up();
    }

    public function actionDown()
    {
        return Migration::down();
    }
}