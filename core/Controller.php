<?php


namespace core;


use Exception;
use Throwable;

class Controller
{
    private $_viewDir;

    public function __construct()
    {
        $this->_viewDir = $this->viewDirName() . DIRECTORY_SEPARATOR;
    }

    /**
     * @param string $file
     * @param array $params
     * @return string
     * @throws Exception
     * @throws Throwable
     */
    public function render($file, $params = [])
    {
        $path = Application::VIEW_DIR . $this->_viewDir . $file . '.php';
        ob_start();
        extract($params, EXTR_OVERWRITE);

        try {
            require $path;
            return ob_get_clean();
        } catch (Exception $e) {
            if (!@ob_end_clean()) {
                ob_clean();
            }
            throw $e;
        } catch (Throwable $e) {
            if (!@ob_end_clean()) {
                ob_clean();
            }
            throw $e;
        }
    }

    private function viewDirName()
    {
        $controllerName = end(explode('\\', get_class($this)));

        return FM::$app->getRoute()->controllerEncode($controllerName);
    }
}