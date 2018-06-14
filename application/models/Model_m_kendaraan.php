<?php
class Model_m_kendaraan extends CI_Model{
    function list_data(){
        $data = $this->db->query("Select mken.*, mtk.type_kendaraan "
                . "From m_kendaraan mken Left Join m_type_kendaraan mtk On (mken.m_type_kendaraan_id = mtk.id) "
                . "Order By mken.no_kendaraan");
        return $data;
    }

    function cek_data($code){
        $data = $this->db->query("Select * From m_kendaraan Where no_kendaraan='".$code."'");        
        return $data;
    }
    
    function show_data($id){
        $data = $this->db->query("Select mken.*, mtk.type_kendaraan "
                . "From m_kendaraan mken Left Join m_type_kendaraan mtk On (mken.m_type_kendaraan_id = mtk.id) "
                . "Where mken.id=".$id);        
        return $data;
    }
}