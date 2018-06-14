<?php
class Model_t_oven extends CI_Model{
    function list_data(){
        $data = $this->db->query("Select ovn.*, gil.no_giling, cv.nama_cv "
                . "From t_oven ovn "
                . "Left Join t_giling gil On (ovn.t_giling_id = gil.id) "
                . "Left Join m_cv cv On (ovn.m_cv_id = cv.id) "
                . "Order By gil.no_giling, ovn.oven, ovn.sak");
        return $data;
    }
    
    function list_giling(){
        $data = $this->db->query("Select distinct ovn.t_giling_id, gil.no_giling, gil.tanggal "
                . "From t_oven ovn "
                . "Left Join t_giling gil On (ovn.t_giling_id = gil.id) "
                . "Where ovn.m_cv_id=0 Order By gil.no_giling");
        return $data;
    }
    
    function list_cv(){
        $data = $this->db->query("Select id, nama_cv From m_cv Order By nama_cv");
        return $data;
    }
    
    function get_data_oven($id){
        $data = $this->db->query("Select * From t_oven Where t_giling_id=".$id);
        return $data;
    }
    
    function cek_stok($produk, $cv_id=null, $sak=null){
        $sql = "Select * From t_inventory Where nama_produk like'%".$produk."%'";
        if(!empty($cv_id)){
            $sql .= " And m_cv_id=".$cv_id;
        }
        if(!empty($sak)){
            $sql .= " And sak=".$sak;
        }
        $data = $this->db->query($sql);        
        return $data;
    }
    
    function get_no_giling($id){
        $data = $this->db->query("Select no_giling From t_giling Where id=".$id);
        return $data;
    }
}