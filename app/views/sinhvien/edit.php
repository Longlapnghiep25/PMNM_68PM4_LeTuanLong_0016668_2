<div class="row justify-content-center">
<div class="col-md-6">
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white fw-bold">
        ✏️ Sửa thông tin sinh viên
    </div>
    <div class="card-body">

        <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $e): ?>
                    <li><?= $e ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/sinhvien/edit/<?= $sinhvien['id'] ?>">
            <div class="mb-3">
                <label class="form-label">Họ và tên</label>
                <input type="text" name="ten" class="form-control"
                       value="<?= htmlspecialchars($_POST['ten'] ?? $sinhvien['ten']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Giới tính</label>
                <select name="gioitinh" class="form-select" required>
                    <option value="">-- Chọn --</option>
                    <?php $gt = $_POST['gioitinh'] ?? $sinhvien['gioitinh']; ?>
                    <option value="nam" <?= $gt==='nam'?'selected':'' ?>>Nam</option>
                    <option value="nữ"  <?= $gt==='nữ'?'selected':'' ?>>Nữ</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">MSSV</label>
                <input type="text" name="mssv" class="form-control"
                       value="<?= htmlspecialchars($_POST['mssv'] ?? $sinhvien['mssv']) ?>" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="<?= BASE_URL ?>/sinhvien/index/1" class="btn btn-secondary">Huỷ</a>
            </div>
        </form>

    </div>
</div>
</div>
</div>