<?php

namespace migrations;

use core\FM;
use core\interfaces\MigrationInterface;

class m200612_130633_add_edited_column_to_task_table implements MigrationInterface
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $sql = 'ALTER TABLE  `task` ADD  `edited` INT NOT NULL DEFAULT 0;';
        $data = FM::$app->getDb()->prepare($sql);

        return $data->execute();
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $sql = 'ALTER TABLE  `task` DROP  `edited`;';
        $data = FM::$app->getDb()->prepare($sql);

        return $data->execute();
    }
}