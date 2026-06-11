<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { background:#f5f7fb; font-family:'Segoe UI',sans-serif; }
        .navbar { background:linear-gradient(135deg,#0d6efd,#0dcaf0)!important;
                  box-shadow:0 3px 10px rgba(0,0,0,.15); }
        .navbar-brand { font-size:1.4rem; font-weight:700; }
        .table thead { background:#0d6efd; color:white; }
        .table th, .table td { vertical-align:middle; border:none; }
        .btn { border-radius:10px; }
        .form-control, .form-select { border-radius:10px; }
        footer { margin-top:50px; padding:20px 0;
                 text-align:center; color:#666; font-size:14px; }
    </style>
</head>
<body>

<?php include __DIR__ . '/partial/header.php'; ?>

<div class="container py-4">
    <?php include $__view__; ?>
</div>

<footer>
    © <?= date('Y') ?> Hệ Thống Quản Lý Sinh Viên |
    Developed by <strong>Lê Tuấn Long</strong>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>