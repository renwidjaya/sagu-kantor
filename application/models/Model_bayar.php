<?php
class Model_bayar extends CI_Model{
    function list_data_timbang(){
        $data = $this->db->query("Select tbg.id, tbg.berat_bersih, tbg.harga, tbg.total_harga, "
                . "otr.supir, otr.time_in, agn.nama_agen, kdr.no_kendaraan, "
                . "mtn.nama_muatan "
                . "From t_timbang tbg "
                . "Left Join t_otorisasi otr On (tbg.t_otorisasi_id = otr.id) "
                . "Left Join m_agen agn On (otr.m_agen_id = agn.id) "
                . "Left Join m_kendaraan kdr On (otr.m_kendaraan_id = kdr.id) "
                . "Left Join m_muatan mtn On (otr.m_muatan_id = mtn.id) "
                . "Where otr.jenis_transaksi='Jual' And otr.status=3 And tbg.t_bayar_id=0 " //status 3 untuk kendaraan yg selesai timbang 2
                . "Order By otr.time_in"
                );
        return $data;
    }
    
    function create_nota($id){
        $data = $this->db->query("Select tbg.id, tbg.berat_bersih, tbg.harga, tbg.total_harga, "
                . "otr.m_kendaraan_id, otr.m_agen_id, otr.supir, otr.time_in, agn.nama_agen, kdr.no_kendaraan, "
                . "mtn.nama_muatan, usr.realname "
                . "From t_timbang tbg "
                . "Left Join t_otorisasi otr On (tbg.t_otorisasi_id = otr.id) "
                . "Left Join m_agen agn On (otr.m_agen_id = agn.id) "
                . "Left Join m_kendaraan kdr On (otr.m_kendaraan_id = kdr.id) "
                . "Left Join m_muatan mtn On (otr.m_muatan_id = mtn.id) "
                . "Left Join users usr On (tbg.created_by = usr.id) "
                . "Where tbg.id=".$id);
        return $data;
    }
    
    function list_nota(){
        $data = $this->db->query("Select nb.*, kdr.no_kendaraan, agn.nama_agen "
                . "From t_nota_bayar nb "
                . "Left Join m_kendaraan kdr On (nb.m_kendaraan_id = kdr.id) "
                . "Left Join m_agen agn On (nb.m_agen_id = agn.id) "
                . "Order By nb.No_nota");
        return $data;
    }  
    
}