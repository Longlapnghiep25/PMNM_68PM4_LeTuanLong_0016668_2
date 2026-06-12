<?php
class lophocModels {
    private $conn;

    public function __construct() {
        $this->conn = DB::getInstance();
    }

    public function getAll($offset = 0, $limit = PAGE_SIZE) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM lophoc ORDER BY id ASC LIMIT ? OFFSET ?"
        );
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllNoLimit() {
        $result = $this->conn->query("SELECT * FROM lophoc ORDER BY tenlop ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countAll() {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM lophoc");
        return (int)$result->fetch_assoc()['total'];
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM lophoc WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getByMalop($malop) {
        $stmt = $this->conn->prepare("SELECT * FROM lophoc WHERE malop = ?");
        $stmt->bind_param("s", $malop);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($malop, $tenlop, $ghichu) {
        $stmt = $this->conn->prepare(
            "INSERT INTO lophoc (malop, tenlop, ghichu) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $malop, $tenlop, $ghichu);
        return $stmt->execute();
    }

    public function update($id, $malop, $tenlop, $ghichu) {
        $stmt = $this->conn->prepare(
            "UPDATE lophoc SET malop=?, tenlop=?, ghichu=? WHERE id=?"
        );
        $stmt->bind_param("sssi", $malop, $tenlop, $ghichu, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM lophoc WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function isMalopExists($malop, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->conn->prepare("SELECT id FROM lophoc WHERE malop=? AND id != ?");
            $stmt->bind_param("si", $malop, $excludeId);
        } else {
            $stmt = $this->conn->prepare("SELECT id FROM lophoc WHERE malop=?");
            $stmt->bind_param("s", $malop);
        }
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
}