<?php

namespace migrations;

use core\FM;
use core\interfaces\MigrationInterface;

class m200611_151243_add_admin_to_user_table implements MigrationInterface
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $sql = 'insert into user (username, email, password) values (:username, :email, :password)';
        $data = FM::$app->getDb()->prepare($sql);

        return $data->execute([
            ':username' => 'admin',
            ':email' => 'admin@test.com',
            ':password' => password_hash('123', PASSWORD_DEFAULT),
        ]);
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