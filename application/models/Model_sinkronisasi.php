<?php
class Model_sinkronisasi extends CI_Model{
    function cek_data($tabel){
        $data = $this->db->query("Select * From ".$tabel." Where flag_sinkronisasi=0 Order By id");
        return $data;
    }
    
    function cek_tabel($nama_file){
        $data = $this->db->query("Select * From t_upload Where nama_file='".$nama_file."'");
        return $data;
    }
    
    function cek_if_exist($tabel, $id){
        $data = $this->db->query("Select * From ".$tabel." Where t_lokal_id=".$id);
        return $data;
    }
}