<div class="row justify-content-center">
<div class="col-md-6">
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white fw-bold">
        ✏️ Sửa lớp học
    </div>
    <div class="card-body">

        <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $e): ?><li><?= $e ?></li><?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/lophoc/edit/<?= $lophoc['id'] ?>">
            <div class="mb-3">
                <label class="form-label">Mã lớp</label>
                <input type="text" name="malop" class="form-control"
                       value="<?= htmlspecialchars($_POST['malop'] ?? $lophoc['malop']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tên lớp</label>
                <input type="text" name="tenlop" class="form-control"
                       value="<?= htmlspecialchars($_POST['tenlop'] ?? $lophoc['tenlop']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ghi chú</label>
                <textarea name="ghichu" class="form-control" rows="3"><?= htmlspecialchars($_POST['ghichu'] ?? $lophoc['ghichu']) ?></textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="<?= BASE_URL ?>/lophoc/index/1" class="btn btn-secondary">Huỷ</a>
            </div>
        </form>

    </div>
</div>
</div>
</div>