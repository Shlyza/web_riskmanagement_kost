<?php
require_once "Database.php";

class PenghuniKost extends Database {
    private $nama;
    private $nomor_kamar;
    private $durasi_sewa;
    private $user_id;

    public function __construct($nama = null, $nomor_kamar = null, $durasi_sewa = null,$user_id = null) {
        parent::__construct();
        $this->nama = $nama;
        $this->nomor_kamar = $nomor_kamar;
        $this->durasi_sewa = $durasi_sewa;
        $this->user_id = $user_id;
    }

    // Getter dan Setter
    public function getNama() {
        return $this->nama;
    }

    public function setNama($nama) {
        $this->nama = $nama;
    }

    public function getNomorKamar() {
        return $this->nomor_kamar;
    }

    public function setNomorKamar($nomor) {
        $this->nomor_kamar = $nomor;
    }

    public function getDurasiSewa() {
        return $this->durasi_sewa;
    }

    public function setDurasiSewa($durasi) {
        $this->durasi_sewa = $durasi;
    }

    public function simpan() {
        $sql = "INSERT INTO penghuni (nama, nomor_kamar, durasi_sewa, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssi", $this->nama, $this->nomor_kamar, $this->durasi_sewa, $this->user_id);
        return $stmt->execute();
    }

    public function ambilSemua() {
        $sql = "SELECT id, nama, nomor_kamar, durasi_sewa FROM penghuni";
        $result = $this->conn->query($sql);

        $penghuni = [];
        while ($row = $result->fetch_assoc()) {
            $penghuni[] = $row;
        }
        return $penghuni;
    }
    public function hapus($id) {
        $sql = "DELETE FROM penghuni WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function update($id, $nama, $nomor_kamar, $durasi_sewa) {
        $sql = "UPDATE penghuni SET nama = ?, nomor_kamar = ?, durasi_sewa = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssi", $nama, $nomor_kamar, $durasi_sewa, $id);
        return $stmt->execute();
    }


}
?>
