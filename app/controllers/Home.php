<?php

class Home {

    function index() {

        require_once "../app/views/home/index.php";
    }

    function login() {

        require_once "../app/views/home/login.php";
    }

    function xulylogin() {

        session_start();

        $username = $_POST['username'];
        $password = $_POST['password'];

        if($username == "admin" && $password == "123") {

            $_SESSION['username'] = $username;

            header("Location: /home/index");
        } else {

            echo "Sai tài khoản hoặc mật khẩu";
        }
    }

    function logout() {

        session_start();

        session_destroy();

        header("Location: /home/login");
    }
}