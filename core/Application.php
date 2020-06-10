<?php


namespace core;

use PDO;

class Application
{
    const CONTROLLER_NAMESPACE = 'controllers\\';
    const MODEL_NAMESPACE = 'models\\';

    const CONTROLLER_DIR = 'controllers/';
    const MODEL_DIR = 'models/';
    const VIEW_DIR = 'views/';

    private $_route;
    private $_db;
    private $_controller;

    public function __construct()
    {
        $this->_route = new Route();
        $this->_db = $this->dbConfig();
    }

    public function run()
    {
        $route = $this->_route;
        $controllerName = self::CONTROLLER_NAMESPACE . $route->getController();
        $this->_controller = new $controllerName;
        $params = $route->getParams();

        if ($params === null) {
            $params = [];
        }

        $result = call_user_func_array([$this->_controller, $route->getAction()], $params);

        if ($result) {
            echo $result;
        } else {
            echo 'Not found';
        }
    }

    public function getDb()
    {
        return $this->_db;
    }

    public function getRoute()
    {
        return $this->_route;
    }

    public function getController()
    {
        return $this->_controller;
    }

    private function dbConfig()
    {
        $db = require 'config/db.php';

        try {
            return new PDO($db['dsn'] . ';charset=' . $db['charset'], $db['username'], $db['password']);
        } catch (\Exception $e) {
            echo $e->getMessage() . '<br>';
        }

        return null;
    }
}