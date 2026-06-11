<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Danh sách sinh viên</h3>
    <a href="<?= BASE_URL ?>/sinhvien/create" class="btn btn-success">
        + Thêm sinh viên
    </a>
</div>

<table class="table table-bordered table-hover bg-white shadow-sm">
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên</th>
            <th>Giới tính</th>
            <th>MSSV</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sinhviens as $index => $sv): ?>
        <tr>
            <td><?= ($currentPage - 1) * PAGE_SIZE + $index + 1 ?></td>
            <td><?= htmlspecialchars($sv['ten']) ?></td>
            <td><?= htmlspecialchars($sv['gioitinh']) ?></td>
            <td><?= htmlspecialchars($sv['mssv']) ?></td>
            <td>
                <a href="<?= BASE_URL ?>/sinhvien/edit/<?= $sv['id'] ?>"
                   class="btn btn-primary btn-sm">Sửa</a>
                <a href="<?= BASE_URL ?>/sinhvien/delete/<?= $sv['id'] ?>/<?= $currentPage ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Xác nhận xoá?')">Xoá</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($sinhviens)): ?>
        <tr>
            <td colspan="5" class="text-center text-muted">Chưa có sinh viên nào.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Paging -->
<div class="mt-3">
    <?php for ($i = 1; $i <= $totalpage; $i++):
        $active = ($i == $currentPage) ? 'btn-primary' : 'btn-outline-primary';
    ?>
        <a class="btn <?= $active ?> btn-sm ms-1"
           href="<?= BASE_URL ?>/sinhvien/index/<?= $i ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>