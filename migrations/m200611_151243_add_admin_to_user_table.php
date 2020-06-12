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
        $sql = 'insert into user (username, email, password, status) values (:username, :email, :password, 0)';
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
        $sql = 'delete from user where status=0';
        $data = FM::$app->getDb()->prepare($sql);

        return $data->execute();
    }
}