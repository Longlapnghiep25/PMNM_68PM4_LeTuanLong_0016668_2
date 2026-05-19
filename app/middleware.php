<?php
require_once "../app/core/App.php";
session_status();
    class middleware{
        function checklogin(){
            if(!isset($_SESSION['username'])) {
                header('Location:/home/login');
                exit();
            }
        }
    }
?>