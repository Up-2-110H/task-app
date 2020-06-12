<?php

namespace migrations;

use core\FM;
use core\interfaces\MigrationInterface;

class m200612_152639_add_users_to_user_table implements MigrationInterface
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $sql = '';

        for ($i = 0; $i < 10; $i++) {
            $sql .= "insert into user (username, email, password)
                    values ('user_$i', 'user_$i@test.com' , '" . password_hash("user_$i", PASSWORD_DEFAULT) . "');";

        }

        $data = FM::$app->getDb()->prepare($sql);

        return $data->execute();
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $sql = 'delete from user where status=1';
        $data = FM::$app->getDb()->prepare($sql);

        return $data->execute();
    }
}