<?php
class Model_t_giling extends CI_Model{
    function list_data_giling(){
        $data = $this->db->query("Select tbng.*, otr.time_in, otr.supir, "
                . "agn.nama_agen, kdr.no_kendaraan, mtn.nama_muatan "
                . "From t_timbang tbng "
                . "Left Join t_otorisasi otr On (tbng.t_otorisasi_id = otr.id) "
                . "Left Join m_agen agn On (otr.m_agen_id = agn.id) "                
                . "Left Join m_kendaraan kdr On (otr.m_kendaraan_id = kdr.id) "
                . "Left Join m_muatan mtn On (otr.m_muatan_id = mtn.id) "
                . "Where mtn.nama_muatan ='SINGKONG' And tbng.t_giling_id =0 "
                . "And otr.status=9 "
                . "Order By otr.time_in");
        return $data;
    }
    
    function list_dt_giling(){
        $data = $this->db->query("SELECT * From t_giling Order By tanggal");
        return $data;
    }  
    
    function view_dt_giling($id){
        $data = $this->db->query("Select tbng.*, otr.time_in, otr.supir, "
                . "agn.nama_agen, kdr.no_kendaraan, mtn.nama_muatan "
                . "From t_timbang tbng "
                . "Left Join t_otorisasi otr On (tbng.t_otorisasi_id = otr.id) "
                . "Left Join m_agen agn On (otr.m_agen_id = agn.id) "                
                . "Left Join m_kendaraan kdr On (otr.m_kendaraan_id = kdr.id) "
                . "Left Join m_muatan mtn On (otr.m_muatan_id = mtn.id) "
                . "Where mtn.nama_muatan ='SINGKONG' And tbng.t_giling_id=".$id." "
                . "And otr.status=9 "
                . "Order By otr.time_in");
        return $data;
    }
    
    function header_dt_giling($id){
        $data = $this->db->query("SELECT gil.*, cv.nama_cv From t_giling gil "
                . "Left Join m_cv cv On (gil.m_cv_id = cv.id) WHERE gil.id=".$id);
        return $data;
    }  
    
}