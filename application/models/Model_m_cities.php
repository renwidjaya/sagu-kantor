<?php
class Model_m_cities extends CI_Model{
    function list_data(){
        $data = $this->db->query("Select a.*,b.province_name From m_cities a "
                . "Left Join m_provinces b ON (a.m_province_id=b.id) Order By a.city_code");        
        return $data;
    }

    function cek_data($code){
        $data = $this->db->query("Select * From m_cities Where city_code='".$code."'");        
        return $data;
    }
    
    function show_data($id){
        $data = $this->db->query("Select a.*,b.province_name From m_cities a "
                . "Left Join m_provinces b ON (a.m_province_id=b.id) Where a.id=".$id);        
        return $data;
    }
    
    function get_province(){
        $data = $this->db->query("Select * From m_provinces Order By province_name");        
        return $data;
    }
}