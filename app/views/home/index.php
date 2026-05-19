<?php

session_start();

if(!isset($_SESSION['username'])) {

    header("Location: /home/login");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trang chủ</title>
</head>
<body>

<h1>Xin chào <?php echo $_SESSION['username']; ?></h1>

<a href="/home/logout">Đăng xuất</a>

</body>
</html>