<?php

namespace core\interfaces;

interface MigrationInterface
{

    /**
     * @return bool
     */
    public function up();

    /**
     * @return bool
     */
    public function down();

}
