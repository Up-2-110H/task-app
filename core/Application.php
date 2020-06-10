<?php


namespace core;

class Application
{
    const CONTROLLER_NAMESPACE = 'controllers\\';
    const MODEL_NAMESPACE = 'models\\';

    const CONTROLLER_DIR = 'controllers/';
    const MODEL_DIR = 'models/';
    const VIEW_DIR = 'views/';

    private $_route;
    private $_controller;

    public function __construct()
    {
        $this->_route = new Route();
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

    public function getRoute()
    {
        return $this->_route;
    }

    public function getController()
    {
        return $this->_controller;
    }
}