<?php
class sinhvien extends Controller {

    public function __construct() {
        $this->requireLogin();
    }

    public function index($param1 = 1) {
        $model    = $this->model('sinhvienModels');
        $lopModel = $this->model('lophocModels');

        $page     = max(1, (int)$param1);
        $search   = trim($_GET['q'] ?? '');
        $malop    = trim($_GET['malop'] ?? '');
        $sort     = $_GET['sort'] ?? 'id';
        $order    = $_GET['order'] ?? 'ASC';
        $pageSize = (int)($_GET['pagesize'] ?? PAGE_SIZE);

        $allowedSize = [2, 5, 10, 20, 50];
        if (!in_array($pageSize, $allowedSize)) $pageSize = PAGE_SIZE;

        $total     = $model->countAll($search, $malop);
        $totalpage = max(1, ceil($total / $pageSize));
        if ($page > $totalpage) $page = $totalpage;
        $offset    = ($page - 1) * $pageSize;

        $this->render('sinhvien/index', [
            'sinhviens'   => $model->getAll($offset, $pageSize, $search, $malop, $sort, $order),
            'totalpage'   => $totalpage,
            'currentPage' => $page,
            'total'       => $total,
            'search'      => $search,
            'malop'       => $malop,
            'sort'        => $sort,
            'order'       => $order,
            'pageSize'    => $pageSize,
            'lophocs'     => $lopModel->getAllNoLimit(),
        ]);
    }

    public function create() {
        $model    = $this->model('sinhvienModels');
        $lopModel = $this->model('lophocModels');
        $errors   = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten      = trim($_POST['ten'] ?? '');
            $gioitinh = $_POST['gioitinh'] ?? '';
            $mssv     = trim($_POST['mssv'] ?? '');
            $malop    = $_POST['malop'] ?? '';

            if (!$ten)      $errors[] = "Họ tên không được trống.";
            if (!$gioitinh) $errors[] = "Vui lòng chọn giới tính.";
            if (!$mssv)     $errors[] = "MSSV không được trống.";
            if (!$malop)    $errors[] = "Vui lòng chọn lớp học.";

            if (empty($errors)) {
                $model->create($ten, $gioitinh, $mssv, $malop);
                $this->redirect('/sinhvien/index/1');
            }
        }

        $this->render('sinhvien/create', [
            'errors'  => $errors,
            'lophocs' => $lopModel->getAllNoLimit(),
        ]);
    }

    public function edit($id = null) {
        $model    = $this->model('sinhvienModels');
        $lopModel = $this->model('lophocModels');
        $id       = (int)$id;
        $sinhvien = $model->getById($id);

        if (!$sinhvien) {
            echo "Không tìm thấy sinh viên!";
            exit;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten      = trim($_POST['ten'] ?? '');
            $gioitinh = $_POST['gioitinh'] ?? '';
            $mssv     = trim($_POST['mssv'] ?? '');
            $malop    = $_POST['malop'] ?? '';

            if (!$ten)      $errors[] = "Họ tên không được trống.";
            if (!$gioitinh) $errors[] = "Vui lòng chọn giới tính.";
            if (!$mssv)     $errors[] = "MSSV không được trống.";
            if (!$malop)    $errors[] = "Vui lòng chọn lớp học.";

            if (empty($errors)) {
                $model->update($id, $ten, $gioitinh, $mssv, $malop);
                $this->redirect('/sinhvien/index/1');
            }
        }

        $this->render('sinhvien/edit', [
            'sinhvien' => $sinhvien,
            'errors'   => $errors,
            'lophocs'  => $lopModel->getAllNoLimit(),
        ]);
    }

    public function delete($id = null, $page = 1) {
        $model = $this->model('sinhvienModels');
        $model->delete((int)$id);
        $this->redirect('/sinhvien/index/' . max(1, (int)$page));
    }
}