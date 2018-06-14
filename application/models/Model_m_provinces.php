<?php
class Model_m_provinces extends CI_Model{
    function list_data(){
        $data = $this->db->query("Select * From m_provinces Order By province_name");        
        return $data;
    }

    function cek_data($code){
        $data = $this->db->query("Select * From m_provinces Where province_code='".$code."'");        
        return $data;
    }
    
    function show_data($id){
        $data = $this->db->query("Select * From m_provinces Where id=".$id);        
        return $data;
    }
}