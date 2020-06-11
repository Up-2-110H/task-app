<?php

namespace migrations;

use core\FM;
use core\interfaces\MigrationInterface;

class m200611_142656_create_task_table implements MigrationInterface
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $sql =
            'create table if not exists `task` (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            text TEXT NOT NULL
        );';

        return FM::$app->getDb()->exec($sql) === false ? false : true;
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $sql = 'drop table if exists `task`;';

        return FM::$app->getDb()->exec($sql) === false ? false : true;
    }
}