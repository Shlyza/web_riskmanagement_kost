<?php
require_once "Database.php";

class Monitoring extends Database {
    public function ambilSemuaMonitoring() {
        $sql = "SELECT 
                    k.id AS keluhan_id,
                    u.username,
                    k.keluhan,
                    k.deskripsi AS deskripsi_keluhan,
                    k.gambar AS gambar_keluhan,
                    k.status,
                    t.deskripsi AS deskripsi_tindakan,
                    t.gambar AS gambar_tindakan,
                    t.tanggal_tindakan
                FROM keluhan k
                JOIN users u ON k.user_id = u.id
                LEFT JOIN tindakan t ON t.keluhan_id = k.id
                ORDER BY k.id DESC";

        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}
