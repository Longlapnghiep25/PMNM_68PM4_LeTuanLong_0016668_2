<?php
class App {
    protected $controller = 'sinhvien';
    protected $action = 'index';
    protected $params = [];

    public function __construct() {
        $url = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
        $segments = $url ? explode('/', $url) : [];

        // Controller
        if (!empty($segments[0])) {
            $ctrlFile = __DIR__ . '/../controllers/' . $segments[0] . '.php';
            if (file_exists($ctrlFile)) {
                $this->controller = $segments[0];
                unset($segments[0]);
            } else {
                // map login/logout -> auth controller
                if (in_array($segments[0], ['login', 'logout'])) {
                    $this->action = $segments[0];
                    $this->controller = 'auth';
                    unset($segments[0]);
                }
            }
        }

        // Action
        if (!empty($segments[1])) {
            $this->action = $segments[1];
            unset($segments[1]);
        }

        // Params
        $this->params = array_values($segments);

        require_once __DIR__ . '/../controllers/' . $this->controller . '.php';
        $controllerObj = new $this->controller();

        if (!method_exists($controllerObj, $this->action)) {
            $this->action = 'index';
        }

        call_user_func_array([$controllerObj, $this->action], $this->params);
    }
}