<?php


namespace core;


class Route
{
    private $_controller = 'site';
    private $_action = 'index';
    private $_params;

    public function __construct()
    {
        $this->urlDecoder();
    }

    /**
     * Get controller name
     * @return string
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * Get action name
     * @return string
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * Get url parameters
     * @return array|null
     */
    public function getParams()
    {
        return $this->_params;
    }

    private function urlDecoder()
    {
        $url = $_GET['url'];
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        if (isset($url[0])) {
            $this->_controller = $this->controllerDecode($url[0]);
        }

        if (isset($url[1])) {
            $this->_action = $this->actionDecode($url[1]);
        }

        if (count($url) > 2) {
            $this->_params = array_slice($url, 2);
        }
    }

    public function controllerDecode($url)
    {
        $decoded = $this->decode($url);
        return $decoded . 'Controller';
    }

    public function controllerEncode($url)
    {
        $controllerName = $url;
        $controllerPos = strrpos($controllerName, 'Controller');

        if ($controllerPos !== false) {
            $controllerName = substr_replace($controllerName, '', $controllerPos);
        }

        return $this->encode($controllerName);
    }

    public function actionEncode($url)
    {
        $actionName = $url;
        $actionPos = strpos($actionName, 'action');

        if ($actionPos !== false) {
            $actionName = substr_replace($actionName, '', $actionPos, 6);
        }

        return $this->encode($actionName);
    }

    public function actionDecode($url)
    {
        $decoded = $this->decode($url);
        return 'action' . $decoded;
    }

    private function decode($url)
    {
        $lowerCase = strtolower($url);
        $words = explode('-', $lowerCase);
        $words = array_map('ucfirst', $words);

        return implode($words);
    }

    private function encode($url)
    {
        $words = preg_split('/(?=[A-Z])/', $url, -1, PREG_SPLIT_NO_EMPTY);
        $word = implode('-', $words);

        return strtolower($word);
    }
}