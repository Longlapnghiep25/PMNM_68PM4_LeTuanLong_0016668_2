<?php
class auth extends Controller {

    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($username === 'admin' && $password === '123456') {
                $_SESSION['user'] = $username;
                $this->redirect('/sinhvien/index/1');
            }
            $error = "Sai tài khoản hoặc mật khẩu!";
        }
        include __DIR__ . '/../views/home/login.php';
    }

    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }

    public function index() {
        $this->login();
    }
}