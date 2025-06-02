<?php
require_once  "Database.php";

class Keluhan extends Database{
    private $keluhan;
    private $deskripsi;
    private $gambar;
    private $user_id;
    private $likelihood;
    private $impact;
    private $result;

    public function __construct($keluhan,$deskripsi,$gambar,$user_id,$likelihood,$impact){
        parent::__construct();
        $this->keluhan      = $keluhan;
        $this->deskripsi    = $deskripsi;
        $this->gambar       = $gambar;
        $this->user_id      = $user_id;
        $this->likelihood   = $likelihood;
        $this->impact       = $impact;
        $this->result       = $likelihood*$impact;
    }

    public function getKeluhan(){
        return $this->keluhan;
    }

    public function setKeluhan($keluhan){
        $this->keluhan = $keluhan;
    }

    public function getDeskripsi(){
        return $this->deskripsi;
    }

    public function setDeskripsi($deskripsi){
        $this->deskripsi = $deskripsi;
    }
    public function getGambar(){
        return $this->gambar;
    }
    public function setGambar($gambar){
        $this->gambar = $gambar;
    }


   public function simpan() {
    $sql = "INSERT INTO keluhan (keluhan, deskripsi, gambar, user_id, likelihood_keluhan, impact_keluhan, result_keluhan) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("sssiiii", $this->keluhan, $this->deskripsi, $this->gambar, $this->user_id, $this->likelihood, $this->impact, $this->result);
    return $stmt->execute();
}

    public function ambilSemua() {
    $sql = "SELECT k.*, u.username FROM keluhan k 
            JOIN users u ON k.user_id = u.id
            ORDER BY k.id DESC";
    $result = $this->conn->query($sql);
    $keluhan = [];
    while ($row = $result->fetch_assoc()) {
        $keluhan[] = $row;
    }
    return $keluhan;
    }

        public function ambilDenganFilterRisiko($kategori) {
    $sql = "SELECT k.*, u.username FROM keluhan k 
            JOIN users u ON k.user_id = u.id";

    if ($kategori === 'tinggi') {
        $sql .= " WHERE result_keluhan >= 9";
    } elseif ($kategori === 'sedang') {
        $sql .= " WHERE result_keluhan >= 4 AND result_keluhan < 9";
    } elseif ($kategori === 'rendah') {
        $sql .= " WHERE result_keluhan < 4";
    }

    $sql .= " ORDER BY k.id DESC";

    $result = $this->conn->query($sql);
    $keluhan = [];
    while ($row = $result->fetch_assoc()) {
        $keluhan[] = $row;
    }
    return $keluhan;
    }



}