<?php
require_once "Database.php";

class Tindakan extends Database {
    public function tambah($keluhan_id, $deskripsi, $oleh, $gambar = NULL) {
        $sql = "INSERT INTO tindakan (keluhan_id, deskripsi, dilakukan_oleh, gambar) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isss", $keluhan_id, $deskripsi, $oleh, $gambar);
        return $stmt->execute();
    }

    public function ambilSemua($keluhan_id) {
        $sql = "SELECT * FROM tindakan WHERE keluhan_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $keluhan_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
