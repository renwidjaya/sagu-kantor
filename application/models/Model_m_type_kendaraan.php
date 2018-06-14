<?php
class Model_m_type_kendaraan extends CI_Model{
    function list_data(){
        $data = $this->db->get('m_type_kendaraan');
        return $data;
    }

    function cek_data($code){
        $data = $this->db->query("Select * From m_type_kendaraan Where type_kendaraan='".$code."'");        
        return $data;
    }
    
    function show_data($id){
        $data = $this->db->query("Select * From m_type_kendaraan Where id=".$id);        
        return $data;
    }
}