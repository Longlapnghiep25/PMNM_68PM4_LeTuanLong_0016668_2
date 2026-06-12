<?php
class Controller {
    protected function render($view, $data = []) {
        extract($data);
        $__view__ = __DIR__ . '/../views/' . $view . '.php';
        include __DIR__ . '/../views/layout/masterlayout.php';
    }

    protected function model($name) {
        require_once __DIR__ . '/../models/' . $name . '.php';
        return new $name();
    }

    protected function redirect($path) {
        header("Location: " . BASE_URL . $path);
        exit;
    }

    protected function requireLogin() {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
        }
    }
}