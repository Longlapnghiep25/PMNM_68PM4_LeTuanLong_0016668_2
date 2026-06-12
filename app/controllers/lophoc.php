<?php
class lophoc extends Controller {

    public function __construct() {
        $this->requireLogin();
    }

    public function index($param1 = 1) {
        $model = $this->model('lophocModels');
    
        $page     = max(1, (int)$param1);
        $search   = trim($_GET['q'] ?? '');
        $sort     = $_GET['sort'] ?? 'id';
        $order    = $_GET['order'] ?? 'ASC';
        $pageSize = (int)($_GET['pagesize'] ?? PAGE_SIZE);
    
        $allowedSize = [2, 5, 10, 20, 50];
        if (!in_array($pageSize, $allowedSize)) $pageSize = PAGE_SIZE;
    
        $total     = $model->countAll($search);
        $totalpage = max(1, ceil($total / $pageSize));
        if ($page > $totalpage) $page = $totalpage;
        $offset    = ($page - 1) * $pageSize;
    
        $this->render('lophoc/index', [
            'lophocs'     => $model->getAll($offset, $pageSize, $search, $sort, $order),
            'totalpage'   => $totalpage,
            'currentPage' => $page,
            'total'       => $total,
            'search'      => $search,
            'sort'        => $sort,
            'order'       => $order,
            'pageSize'    => $pageSize,
        ]);
    }

    public function create() {
        $model  = $this->model('lophocModels');
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $malop  = trim($_POST['malop'] ?? '');
            $tenlop = trim($_POST['tenlop'] ?? '');
            $ghichu = trim($_POST['ghichu'] ?? '');

            if (!$malop)  $errors[] = "Mã lớp không được trống.";
            if (!$tenlop) $errors[] = "Tên lớp không được trống.";
            if ($malop && $model->isMalopExists($malop)) {
                $errors[] = "Mã lớp đã tồn tại.";
            }

            if (empty($errors)) {
                $model->create($malop, $tenlop, $ghichu);
                $this->redirect('/lophoc/index/1');
            }
        }

        $this->render('lophoc/create', ['errors' => $errors]);
    }

    public function edit($id = null) {
        $model  = $this->model('lophocModels');
        $id     = (int)$id;
        $lophoc = $model->getById($id);

        if (!$lophoc) {
            echo "Không tìm thấy lớp học!";
            exit;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $malop  = trim($_POST['malop'] ?? '');
            $tenlop = trim($_POST['tenlop'] ?? '');
            $ghichu = trim($_POST['ghichu'] ?? '');

            if (!$malop)  $errors[] = "Mã lớp không được trống.";
            if (!$tenlop) $errors[] = "Tên lớp không được trống.";
            if ($malop && $model->isMalopExists($malop, $id)) {
                $errors[] = "Mã lớp đã tồn tại.";
            }

            if (empty($errors)) {
                $model->update($id, $malop, $tenlop, $ghichu);
                $this->redirect('/lophoc/index/1');
            }
        }

        $this->render('lophoc/edit', [
            'lophoc' => $lophoc,
            'errors' => $errors,
        ]);
    }

    public function delete($id = null, $page = 1) {
        $model = $this->model('lophocModels');
        $model->delete((int)$id);
        $this->redirect('/lophoc/index/' . max(1, (int)$page));
    }
}