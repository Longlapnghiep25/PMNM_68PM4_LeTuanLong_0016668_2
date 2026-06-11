<nav class="navbar navbar-dark navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand fw-bold" 
           href="<?= BASE_URL ?>/sinhvien/index/1">🎓 QLSV</a>
        <div class="ms-auto">
            <?php if (isset($_SESSION['user'])): ?>
                <span class="text-light me-3">
                    👤 <?= htmlspecialchars($_SESSION['user']) ?>
                </span>
                <a href="http://localhost/PMNM_68PM4_LeTuanLong_0016668_2/public/login" 
                   class="btn btn-outline-light btn-sm">Đăng xuất</a>
            <?php endif; ?>
        </div>
    </div>
</nav>