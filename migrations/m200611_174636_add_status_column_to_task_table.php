<?php

namespace migrations;

use core\FM;
use core\interfaces\MigrationInterface;

class m200611_174636_add_status_column_to_task_table implements MigrationInterface
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $sql = 'ALTER TABLE  `task` ADD  `status` INT NOT NULL DEFAULT 0;';
        $data = FM::$app->getDb()->prepare($sql);

        return $data->execute();
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $sql = 'ALTER TABLE  `task` DROP  `status`;';
        $data = FM::$app->getDb()->prepare($sql);

        return $data->execute();
    }
}