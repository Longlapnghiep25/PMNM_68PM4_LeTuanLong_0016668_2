<?php
if (!function_exists('buildSortLink')) {
    function buildSortLink($field, $label, $sort, $order, $search, $malop, $pageSize) {
        $newOrder = ($sort === $field && $order === 'ASC') ? 'DESC' : 'ASC';
        $icon = '';
        if ($sort === $field) {
            $icon = $order === 'ASC' ? ' ▲' : ' ▼';
        }
        $params = http_build_query([
            'q' => $search, 'malop' => $malop,
            'sort' => $field, 'order' => $newOrder,
            'pagesize' => $pageSize,
        ]);
        return '<a href="' . BASE_URL . '/sinhvien/index/1?' . $params . '" class="text-dark text-decoration-none fw-bold">'
             . $label . $icon . '</a>';
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Danh sách sinh viên <span class="badge bg-secondary"><?= $total ?></span></h3>
    <a href="<?= BASE_URL ?>/sinhvien/create" class="btn btn-success">
        + Thêm sinh viên
    </a>
</div>

<!-- ===== Form tìm kiếm ===== -->
<form method="GET" action="<?= BASE_URL ?>/sinhvien/index/1" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="q" class="form-control"
               placeholder="Tìm theo tên hoặc MSSV..."
               value="<?= htmlspecialchars($search) ?>">
    </div>
    <div class="col-md-3">
        <select name="malop" class="form-select">
            <option value="">-- Tất cả lớp --</option>
            <?php foreach ($lophocs as $lop): ?>
                <option value="<?= htmlspecialchars($lop['malop']) ?>"
                    <?= ($malop === $lop['malop']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($lop['tenlop']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
    <input type="hidden" name="order" value="<?= htmlspecialchars($order) ?>">
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">
            <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
        </button>
    </div>
    <div class="col-md-2">
        <a href="<?= BASE_URL ?>/sinhvien/index/1" class="btn btn-outline-secondary w-100">
            <i class="fa-solid fa-rotate-left"></i> Đặt lại
        </a>
    </div>
    <div class="col-md-1">
        <select name="pagesize" class="form-select" onchange="this.form.submit()">
            <?php foreach ([2, 5, 10, 20, 50] as $sz): ?>
                <option value="<?= $sz ?>" <?= $pageSize == $sz ? 'selected' : '' ?>>
                    <?= $sz ?>/trang
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</form>

<table class="table table-bordered table-hover bg-white shadow-sm">
    <thead>
        <tr>
            <th>STT</th>
            <th><?= buildSortLink('mssv', 'MSSV', $sort, $order, $search, $malop, $pageSize) ?></th>
            <th><?= buildSortLink('ten', 'Họ tên', $sort, $order, $search, $malop, $pageSize) ?></th>
            <th>Giới tính</th>
            <th>Lớp học</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sinhviens as $index => $sv): ?>
        <tr>
            <td><?= ($currentPage - 1) * $pageSize + $index + 1 ?></td>
            <td><?= htmlspecialchars($sv['mssv']) ?></td>
            <td><?= htmlspecialchars($sv['ten']) ?></td>
            <td><?= htmlspecialchars($sv['gioitinh']) ?></td>
            <td>
                <?php if ($sv['tenlop']): ?>
                    <span class="badge bg-info text-dark"><?= htmlspecialchars($sv['tenlop']) ?></span>
                <?php else: ?>
                    —
                <?php endif; ?>
            </td>
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
        <tr><td colspan="6" class="text-center text-muted">Không tìm thấy sinh viên nào.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- ===== Paging ===== -->
<div class="mt-3">
    <?php
    $extraParams = http_build_query([
        'q' => $search, 'malop' => $malop,
        'sort' => $sort, 'order' => $order,
        'pagesize' => $pageSize,
    ]);
    for ($i = 1; $i <= $totalpage; $i++):
        $active = ($i == $currentPage) ? 'btn-primary' : 'btn-outline-primary';
    ?>
        <a class="btn <?= $active ?> btn-sm ms-1"
           href="<?= BASE_URL ?>/sinhvien/index/<?= $i ?>?<?= $extraParams ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>