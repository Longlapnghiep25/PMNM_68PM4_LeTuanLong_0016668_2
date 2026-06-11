<?php
session_start();

function render($view, $data = []) {
    extract($data);
    $__view__ = __DIR__ . '/../app/views/' . $view . '.php';
    include __DIR__ . '/../app/views/layout/masterlayout.php';
}

// ===== CONFIG =====
define('BASE_URL', '/PMNM_68PM4_LeTuanLong_0016668_2/public');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'qlsv');
define('PAGE_SIZE', 2);

// ===== ConnectDB =====
class ConnectDB {
    private static $conn = null;

    public static function getInstance() {
        if (self::$conn === null) {
            self::$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (self::$conn->connect_error) {
                die("Kết nối thất bại: " . self::$conn->connect_error);
            }
            self::$conn->set_charset("utf8");
        }
        return self::$conn;
    }
}

// ===== SinhvienModel =====
class SinhvienModel {
    private $conn;

    public function __construct() {
        $this->conn = ConnectDB::getInstance();
    }

    public function getAll($offset = 0, $limit = PAGE_SIZE) {
        $stmt = $this->conn->prepare("SELECT * FROM sinhvien LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countAll() {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM sinhvien");
        $row = $result->fetch_assoc();
        return (int)$row['total'];
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM sinhvien WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($ten, $gioitinh, $mssv) {
        $stmt = $this->conn->prepare("INSERT INTO sinhvien (ten, gioitinh, mssv) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $ten, $gioitinh, $mssv);
        return $stmt->execute();
    }

    public function update($id, $ten, $gioitinh, $mssv) {
        $stmt = $this->conn->prepare("UPDATE sinhvien SET ten = ?, gioitinh = ?, mssv = ? WHERE id = ?");
        $stmt->bind_param("sssi", $ten, $gioitinh, $mssv, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM sinhvien WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

// ===== Helper =====
function redirect($path) {
    header("Location: " . BASE_URL . $path);
    exit;
}

// ===== Middleware =====
function requireLogin() {
    if (!isset($_SESSION['user'])) {
        redirect('/login');
    }
}

// ===== URL Router =====
$url = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
$segments    = explode('/', $url);
$controller  = $segments[0] ?? 'home';
$action      = $segments[1] ?? 'index';
$param1      = $segments[2] ?? null;
$param2      = $segments[3] ?? null;

// ===== Auth Controller =====
if ($controller === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username === 'admin' && $password === '123456') {
            $_SESSION['user'] = $username;
            redirect('/sinhvien/index/1');
        }

        $error = "Sai tài khoản hoặc mật khẩu!";
        include __DIR__ . '/../app/views/home/login.php';
        exit;
    }

    include __DIR__ . '/../app/views/home/login.php';
    exit;
}

// ===== Logout =====
if ($controller === 'logout') {
    session_destroy();
    redirect('/login');
}

// ===== Sinhvien Controller =====
if ($controller === 'sinhvien') {
    requireLogin();
    $model = new SinhvienModel();

    // ===== Danh sách =====
    if ($action === 'index') {
        $page        = max(1, (int)($param1 ?? 1));
        $total       = $model->countAll();
        $totalpage   = ceil($total / PAGE_SIZE);
        $offset      = ($page - 1) * PAGE_SIZE;
        $sinhviens   = $model->getAll($offset, PAGE_SIZE);
        $currentPage = $page;

        render('sinhvien/index', [
            'sinhviens'   => $sinhviens,
            'totalpage'   => $totalpage,
            'currentPage' => $currentPage,
        ]);
        exit;
    }

    // ===== Thêm =====
    if ($action === 'create') {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten      = trim($_POST['ten'] ?? '');
            $gioitinh = $_POST['gioitinh'] ?? '';
            $mssv     = trim($_POST['mssv'] ?? '');

            if (!$ten)      $errors[] = "Họ tên không được trống.";
            if (!$gioitinh) $errors[] = "Vui lòng chọn giới tính.";
            if (!$mssv)     $errors[] = "MSSV không được trống.";

            if (empty($errors)) {
                $model->create($ten, $gioitinh, $mssv);
                redirect('/sinhvien/index/1');
            }
        }

        render('sinhvien/create', ['errors' => $errors]);
        exit;
    }

    // ===== Sửa =====
    if ($action === 'edit') {
        $id       = (int)$param1;
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
    
            if (!$ten)      $errors[] = "Họ tên không được trống.";
            if (!$gioitinh) $errors[] = "Vui lòng chọn giới tính.";
            if (!$mssv)     $errors[] = "MSSV không được trống.";
    
            if (empty($errors)) {
                $model->update($id, $ten, $gioitinh, $mssv);
                redirect('/sinhvien/index/1');
            }
        }
    
        render('sinhvien/edit', [
            'sinhvien' => $sinhvien,   // ← phải có dòng này
            'errors'   => $errors,
        ]);
        exit;
    }

    // ===== Xóa =====
    if ($action === 'delete') {
        $id   = (int)$param1;
        $page = max(1, (int)($param2 ?? 1));
        $model->delete($id);
        redirect("/sinhvien/index/$page");
    }
}

// ===== Default =====
redirect('/login');
?>