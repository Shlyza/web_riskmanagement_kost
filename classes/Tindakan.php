<?php
require_once "Database.php";

class Tindakan extends Database {
    private $keluhan_id;
    private $deskripsi;
    private $oleh;
    private $gambar;
    private $likelihood;
    private $impact;
    private $result;

    public function __construct($keluhan_id = null, $deskripsi = null, $oleh = null, $gambar = null, $likelihood= null, $impact= null) {
        parent::__construct();
        $this->keluhan_id   = $keluhan_id;
        $this->deskripsi    = $deskripsi;
        $this->oleh         = $oleh;
        $this->gambar       = $gambar;
        $this->likelihood   = $likelihood;
        $this->impact       = $impact;
    }

    public function getKeluhanId() {
        return $this->keluhan_id;
    }

    public function setKeluhanId($keluhan_id) {
        $this->keluhan_id = $keluhan_id;
    }

    public function getDeskripsi() {
        return $this->deskripsi;
    }

    public function setDeskripsi($deskripsi) {
        $this->deskripsi = $deskripsi;
    }

    public function getOleh() {
        return $this->oleh;
    }

    public function setOleh($oleh) {
        $this->oleh = $oleh;
    }

    public function getGambar() {
        return $this->gambar;
    }

    public function setGambar($gambar) {
        $this->gambar = $gambar;
    }

    public function setLikelihood($likelihood) {
    $this->likelihood = $likelihood;
    $this->updateResult();
    }

    public function setImpact($impact) {
        $this->impact = $impact;
        $this->updateResult();
    }
    private function updateResult() {
        if ($this->likelihood !== null && $this->impact !== null) {
            $this->result = $this->likelihood * $this->impact;
        }
    }
    public function getResult() {
        return $this->result;
    }



    public function tambah() {
        $sql = "INSERT INTO tindakan (keluhan_id, deskripsi, dilakukan_oleh, gambar, likelihood_tindakan, impact_tindakan, result_tindakan) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isssiii", $this->keluhan_id, $this->deskripsi, $this->oleh, $this->gambar, $this->likelihood, $this->impact, $this->result);
        return $stmt->execute();
    }

    public function ambilSemua() {
        $sql = "SELECT * FROM tindakan WHERE keluhan_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->keluhan_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
