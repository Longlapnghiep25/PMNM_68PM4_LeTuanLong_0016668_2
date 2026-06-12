<?php
class sinhvienModels {
    private $conn;

    public function __construct() {
        $this->conn = DB::getInstance();
    }

    public function getAll($offset = 0, $limit = PAGE_SIZE) {
        $stmt = $this->conn->prepare(
            "SELECT sv.*, lh.tenlop
             FROM sinhvien sv
             LEFT JOIN lophoc lh ON sv.malop = lh.malop
             ORDER BY sv.id ASC
             LIMIT ? OFFSET ?"
        );
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countAll() {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM sinhvien");
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