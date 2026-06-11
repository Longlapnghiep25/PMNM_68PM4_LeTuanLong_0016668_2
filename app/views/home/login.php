<!DOCTYPE html>

<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>

```
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<style>
    body{
        background:#e8f5e9;
        display:flex;
        align-items:center;
        justify-content:center;
        height:100vh;
    }

    .card{
        width:380px;
        border-radius:12px;
        box-shadow:0 4px 20px rgba(0,0,0,.15);
    }

    .card-header{
        background:#4CAF50;
        color:#fff;
        text-align:center;
        font-size:1.2rem;
        font-weight:600;
    }
</style>
```

</head>
<body>

<div class="card">
    <div class="card-header py-3">
        🔐 Đăng nhập hệ thống
    </div>

```
<div class="card-body p-4">

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST"
          action="<?= BASE_URL ?>/login">

        <div class="mb-3">
            <label class="form-label">
                Tài khoản
            </label>

            <input
                type="text"
                name="username"
                class="form-control"
                placeholder="admin"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">
                Mật khẩu
            </label>

            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="123456"
                required>
        </div>

        <button
            type="submit"
            class="btn btn-success w-100">
            Đăng nhập
        </button>

    </form>

</div>
```

</div>

</body>
</html>
