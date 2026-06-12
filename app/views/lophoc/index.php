<?php
if (!function_exists('buildSortLinkLop')) {
    function buildSortLinkLop($field, $label, $sort, $order, $search, $pageSize) {
        $newOrder = ($sort === $field && $order === 'ASC') ? 'DESC' : 'ASC';
        $icon = '';
        if ($sort === $field) {
            $icon = $order === 'ASC' ? ' ▲' : ' ▼';
        }
        $params = http_build_query([
            'q' => $search, 'sort' => $field,
            'order' => $newOrder, 'pagesize' => $pageSize,
        ]);
        return '<a href="' . BASE_URL . '/lophoc/index/1?' . $params . '" class="text-dark text-decoration-none fw-bold">'
             . $label . $icon . '</a>';
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Danh sách lớp học <span class="badge bg-secondary"><?= $total ?></span></h3>
    <a href="<?= BASE_URL ?>/lophoc/create" class="btn btn-success">
        + Thêm lớp học
    </a>
</div>

<!-- ===== Form tìm kiếm ===== -->
<form method="GET" action="<?= BASE_URL ?>/lophoc/index/1" class="row g-2 mb-3">
    <div class="col-md-5">
        <input type="text" name="q" class="form-control"
               placeholder="Tìm theo mã lớp hoặc tên lớp..."
               value="<?= htmlspecialchars($search) ?>">
    </div>
    <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
    <input type="hidden" name="order" value="<?= htmlspecialchars($order) ?>">
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">
            <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
        </button>
    </div>
    <div class="col-md-2">
        <a href="<?= BASE_URL ?>/lophoc/index/1" class="btn btn-outline-secondary w-100">
            <i class="fa-solid fa-rotate-left"></i> Đặt lại
        </a>
    </div>
    <div class="col-md-2">
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
            <th><?= buildSortLinkLop('malop', 'Mã lớp', $sort, $order, $search, $pageSize) ?></th>
            <th><?= buildSortLinkLop('tenlop', 'Tên lớp', $sort, $order, $search, $pageSize) ?></th>
            <th>Ghi chú</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lophocs as $index => $lop): ?>
        <tr>
            <td><?= ($currentPage - 1) * $pageSize + $index + 1 ?></td>
            <td><span class="badge bg-info text-dark"><?= htmlspecialchars($lop['malop']) ?></span></td>
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
        <tr><td colspan="5" class="text-center text-muted">Không tìm thấy lớp học nào.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- ===== Paging ===== -->
<div class="mt-3">
    <?php
    $extraParams = http_build_query([
        'q' => $search, 'sort' => $sort,
        'order' => $order, 'pagesize' => $pageSize,
    ]);
    for ($i = 1; $i <= $totalpage; $i++):
        $active = ($i == $currentPage) ? 'btn-primary' : 'btn-outline-primary';
    ?>
        <a class="btn <?= $active ?> btn-sm ms-1"
           href="<?= BASE_URL ?>/lophoc/index/<?= $i ?>?<?= $extraParams ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>