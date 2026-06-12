<?php
class sinhvienModels {
    private $conn;

    public function __construct() {
        $this->conn = DB::getInstance();
    }

    private function buildWhere($search, $malop, &$types, &$params) {
        $where = "WHERE 1=1";
        if ($search !== '') {
            $where .= " AND (sv.mssv LIKE ? OR sv.ten LIKE ?)";
            $kw = "%$search%";
            $types  .= "ss";
            $params[] = $kw;
            $params[] = $kw;
        }
        if ($malop !== '') {
            $where .= " AND sv.malop = ?";
            $types  .= "s";
            $params[] = $malop;
        }
        return $where;
    }

    public function getAll($offset = 0, $limit = 10, $search = '', $malop = '', $sort = 'id', $order = 'ASC') {
        $allowedSort  = ['mssv', 'ten', 'id'];
        $allowedOrder = ['ASC', 'DESC'];
        if (!in_array($sort, $allowedSort))   $sort  = 'id';
        if (!in_array($order, $allowedOrder)) $order = 'ASC';

        $types = '';
        $params = [];
        $where = $this->buildWhere($search, $malop, $types, $params);

        $sql = "SELECT sv.*, lh.tenlop
                FROM sinhvien sv
                LEFT JOIN lophoc lh ON sv.malop = lh.malop
                $where
                ORDER BY sv.$sort $order
                LIMIT ? OFFSET ?";

        $types .= "ii";
        $params[] = $limit;
        $params[] = $offset;

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countAll($search = '', $malop = '') {
        $types = '';
        $params = [];
        $where = $this->buildWhere($search, $malop, $types, $params);

        $sql = "SELECT COUNT(*) AS total FROM sinhvien sv $where";

        if ($types) {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            return (int)$stmt->get_result()->fetch_assoc()['total'];
        }

        $result = $this->conn->query($sql);
        return (int)$result->fetch_assoc()['total'];
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM sinhvien WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($ten, $gioitinh, $mssv, $malop) {
        $stmt = $this->conn->prepare(
            "INSERT INTO sinhvien (ten, gioitinh, mssv, malop) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $ten, $gioitinh, $mssv, $malop);
        return $stmt->execute();
    }

    public function update($id, $ten, $gioitinh, $mssv, $malop) {
        $stmt = $this->conn->prepare(
            "UPDATE sinhvien SET ten=?, gioitinh=?, mssv=?, malop=? WHERE id=?"
        );
        $stmt->bind_param("ssssi", $ten, $gioitinh, $mssv, $malop, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM sinhvien WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}