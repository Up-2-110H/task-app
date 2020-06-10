<?php

require_once 'core/autoload.php';

use core\Application;
use core\FM;

FM::$app = new Application();

FM::$app->run();