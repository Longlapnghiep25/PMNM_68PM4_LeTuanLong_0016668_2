<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Danh sách lớp học</h3>
    <a href="<?= BASE_URL ?>/lophoc/create" class="btn btn-success">
        + Thêm lớp học
    </a>
</div>

<table class="table table-bordered table-hover bg-white shadow-sm">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã lớp</th>
            <th>Tên lớp</th>
            <th>Ghi chú</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lophocs as $index => $lop): ?>
        <tr>
            <td><?= ($currentPage - 1) * PAGE_SIZE + $index + 1 ?></td>
            <td><?= htmlspecialchars($lop['malop']) ?></td>
            <td><?= htmlspecialchars($lop['tenlop']) ?></td>
            <td><?= htmlspecialchars($lop['ghichu']) ?></td>
            <td>
                <a href="<?= BASE_URL ?>/lophoc/edit/<?= $lop['id'] ?>"
                   class="btn btn-primary btn-sm">Sửa</a>
                <a href="<?= BASE_URL ?>/lophoc/delete/<?= $lop['id'] ?>/<?= $currentPage ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Xác nhận xoá lớp học này?')">Xoá</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($lophocs)): ?>
        <tr><td colspan="5" class="text-center text-muted">Chưa có lớp học nào.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="mt-3">
    <?php for ($i = 1; $i <= $totalpage; $i++):
        $active = ($i == $currentPage) ? 'btn-primary' : 'btn-outline-primary';
    ?>
        <a class="btn <?= $active ?> btn-sm ms-1"
           href="<?= BASE_URL ?>/lophoc/index/<?= $i ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>