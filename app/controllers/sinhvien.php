<?php
class sinhvien extends Controller {

    public function __construct() {
        $this->requireLogin();
    }

    public function index($param1 = 1) {
        $model     = $this->model('sinhvienModels');
        $page      = max(1, (int)$param1);
        $total     = $model->countAll();
        $totalpage = max(1, ceil($total / PAGE_SIZE));
        $offset    = ($page - 1) * PAGE_SIZE;

        $this->render('sinhvien/index', [
            'sinhviens'   => $model->getAll($offset, PAGE_SIZE),
            'totalpage'   => $totalpage,
            'currentPage' => $page,
        ]);
    }

    public function create() {
        $model     = $this->model('sinhvienModels');
        $lopModel  = $this->model('lophocModels');
        $errors    = [];

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
            'errors'   => $errors,
            'lophocs'  => $lopModel->getAllNoLimit(),
        ]);
    }

    public function edit($id = null) {
        $model     = $this->model('sinhvienModels');
        $lopModel  = $this->model('lophocModels');
        $id        = (int)$id;
        $sinhvien  = $model->getById($id);

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