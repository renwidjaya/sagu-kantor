<?php
class Model_m_agen extends CI_Model{
    function list_data(){
        $data = $this->db->query("Select agn.*, prov.province_name, cty.city_name "
                . "From m_agen agn "
                . "Left Join m_provinces prov On (agn.m_province_id = prov.id) "
                . "Left Join m_cities cty On (agn.m_city_id = cty.id) "
                #. "Left Join m_ekspedisi eksp On (agn.m_ekspedisi_id = eksp.id) "
                . "Order By agn.nama_agen");
        return $data;
    }

    function cek_data($code){
        $data = $this->db->query("Select * From m_agen Where nama_agen='".$code."'");        
        return $data;
    }
    
    function show_data($id){
        $data = $this->db->query("Select * From m_agen Where id=".$id);        
        return $data;
    }
}