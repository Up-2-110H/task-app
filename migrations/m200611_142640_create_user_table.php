<?php

namespace migrations;

use core\FM;
use core\interfaces\MigrationInterface;

class m200611_142640_create_user_table implements MigrationInterface
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $sql =
            'create table if not exists `user` (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            username TEXT NOT NULL,
            password TEXT NOT NULL,
            email TEXT NOT NULL,
            status INT NOT NULL DEFAULT 1
        );';

        return FM::$app->getDb()->exec($sql) === false ? false : true;
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $sql = 'drop table if exists `user`;';

        return FM::$app->getDb()->exec($sql) === false ? false : true;
    }
}