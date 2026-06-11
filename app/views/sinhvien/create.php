<div class="row justify-content-center">
<div class="col-md-6">
<div class="card shadow-sm">
    <div class="card-header bg-success text-white fw-bold">
        ➕ Thêm sinh viên mới
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

        <form method="POST" action="<?= BASE_URL ?>/sinhvien/create">
            <div class="mb-3">
                <label class="form-label">Họ và tên</label>
                <input type="text" name="ten" class="form-control"
                       value="<?= htmlspecialchars($_POST['ten'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Giới tính</label>
                <select name="gioitinh" class="form-select" required>
                    <option value="">-- Chọn --</option>
                    <option value="nam" <?= (($_POST['gioitinh']??'')==='nam')?'selected':'' ?>>Nam</option>
                    <option value="nữ"  <?= (($_POST['gioitinh']??'')==='nữ')?'selected':'' ?>>Nữ</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">MSSV</label>
                <input type="text" name="mssv" class="form-control"
                       value="<?= htmlspecialchars($_POST['mssv'] ?? '') ?>" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="<?= BASE_URL ?>/sinhvien/index/1" class="btn btn-secondary">Huỷ</a>
            </div>
        </form>

    </div>
</div>
</div>
</div>