<?php
class Model_m_muatan extends CI_Model{
    function list_data(){
        $data = $this->db->get('m_muatan');
        return $data;
    }

    function cek_data($code){
        $data = $this->db->query("Select * From m_muatan Where nama_muatan='".$code."'");        
        return $data;
    }
    
    function show_data($id){
        $data = $this->db->query("Select * From m_muatan Where id=".$id);        
        return $data;
    }
    
    function list_muatan(){
        $data = $this->db->query("Select * From m_muatan Order By id");        
        return $data;
    }
    
    function list_produk(){
        $data = $this->db->query("Select * From m_muatan Where flag_out=1 Order By id");        
        return $data;
    }
    
    function get_muatan_type($id){
        $data = $this->db->query("Select * From m_muatan_type Where m_muatan_id=".$id);
        return $data;
    }
}