<?php
class Model_t_otorisasi extends CI_Model{
    function list_data_in(){
        $data = $this->db->query("Select otr.*, agn.nama_agen, agn.jenis_agen, "
                . "kdr.no_kendaraan, mtn.nama_muatan "
                . "From t_otorisasi otr "
                . "Left Join m_agen agn On (otr.m_agen_id = agn.id) "                
                . "Left Join m_kendaraan kdr On (otr.m_kendaraan_id = kdr.id) "
                . "Left Join m_muatan mtn On (otr.m_muatan_id = mtn.id) "
                . "Where otr.status<9 "
                . "Order By otr.time_in");
        return $data;
    }

    function cek_data_kendaraan_masuk($code){
        $data = $this->db->query("Select * From t_otorisasi "
                . "Where m_kendaraan_id='".$code."' And status <9");        
        return $data;
    }
    
    function show_data_masuk($id){
        $data = $this->db->query("Select otr.*, agn.nama_agen, agn.jenis_agen, "
                . "kdr.no_kendaraan, tkdr.type_kendaraan, mtn.nama_muatan "
                . "From t_otorisasi otr "
                . "Left Join m_agen agn On (otr.m_agen_id = agn.id) "                
                . "Left Join m_kendaraan kdr On (otr.m_kendaraan_id = kdr.id) "
                . "Left Join m_type_kendaraan tkdr On (kdr.m_type_kendaraan_id = tkdr.id) "
                . "Left Join m_muatan mtn On (otr.m_muatan_id = mtn.id) "
                . "Where otr.id=".$id);        
        return $data;
    }
    
    function list_data_out(){
        $data = $this->db->query("Select otr.*, agn.nama_agen, agn.jenis_agen, "
                . "kdr.no_kendaraan, mtn.nama_muatan "
                . "From t_otorisasi otr "
                . "Left Join m_agen agn On (otr.m_agen_id = agn.id) "                
                . "Left Join m_kendaraan kdr On (otr.m_kendaraan_id = kdr.id) "
                . "Left Join m_muatan mtn On (otr.m_muatan_id = mtn.id) "
                . "Where otr.status = 3 "
                . "Order By otr.time_in");
        return $data;
    }
    
    function show_produk($id){
        $data = $this->db->query("Select * From t_otorisasi_muatan "
                . "Where t_otorisasi_id=".$id." Order By id");
        return $data;
    }
    
    function otorisasi_sagu($id){
        $data = $this->db->query("Select otr.*, kdr.no_kendaraan, tkdr.type_kendaraan, "
                . "agn.nama_agen, agn.jenis_agen "
                . "From t_otorisasi otr "
                . "Left Join m_agen agn On (otr.m_agen_id = agn.id) "                
                . "Left Join m_kendaraan kdr On (otr.m_kendaraan_id = kdr.id) "
                . "Left Join m_type_kendaraan tkdr On (kdr.m_type_kendaraan_id = tkdr.id) "
                . "Left Join m_muatan mtn On (otr.m_muatan_id = mtn.id) "
                . "Where otr.id=".$id);        
        return $data;
    }
    
    function data_detail_delivery($id){
        $data = $this->db->query("Select * From t_delivery_order_detail "
                . "Where t_delivery_order_id=".$id." Order By id");
        return $data;
    }
    
    function cek_muatan($id){
        $data = $this->db->query("Select * From t_otorisasi_muatan "
                . "Where t_otorisasi_id=".$id." And flag_timbang=0");
        return $data;
    }
    
    function list_dt_otorisasi(){
        $data = $this->db->query("Select otr.*, agn.nama_agen, agn.jenis_agen, "
                . "kdr.no_kendaraan, mtn.nama_muatan "
                . "From t_otorisasi otr "
                . "Left Join m_agen agn On (otr.m_agen_id = agn.id) "                
                . "Left Join m_kendaraan kdr On (otr.m_kendaraan_id = kdr.id) "
                . "Left Join m_muatan mtn On (otr.m_muatan_id = mtn.id) "
                . "Where otr.status=9 "
                . "Order By otr.time_in");
        return $data;
    }
}