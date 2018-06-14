<?php
class Model_t_timbang extends CI_Model{
    function list_data_otorisasi($muatan=null, $transaksi=null){
        $sql  = "Select otr.*, agn.nama_agen, agn.jenis_agen, "
                . "kdr.no_kendaraan, tkdr.type_kendaraan, mtn.nama_muatan "
                . "From t_otorisasi otr "
                . "Left Join m_agen agn On (otr.m_agen_id = agn.id) "                
                . "Left Join m_kendaraan kdr On (otr.m_kendaraan_id = kdr.id) "
                . "Left Join m_type_kendaraan tkdr On (kdr.m_type_kendaraan_id = tkdr.id) "
                . "Left Join m_muatan mtn On (otr.m_muatan_id = mtn.id) "
                . "Where otr.status in(1,2)";
        
        if(!empty($muatan)){
            if($muatan=="MATERIAL"){
                $sql .= "And mtn.nama_muatan like '%LAIN-LAIN%'";
            }else if($muatan=="SAGU"){
                $sql .= "";
            }else{
                $sql .= "And mtn.nama_muatan like '%".$muatan."%' ";
            }
        }
        if(!empty($transaksi)){
            $sql .= "And otr.jenis_transaksi='".$transaksi."' ";
        }
        $sql .= "Order By otr.time_in";
        $data = $this->db->query($sql);        
        return $data;
    }
    
    function get_data_timbang($id){
        $data = $this->db->query("Select * From t_timbang Where t_otorisasi_id=".$id);        
        return $data;
    }
    
    function get_detail_biaya($id){
        $data = $this->db->query("Select bt.*, mb.nama_biaya, mb.type_biaya "
                . "From t_biaya_timbang bt "
                . "Left Join m_biaya mb On (bt.m_biaya_id = mb.id) "
                . "Where bt.id=".$id);        
        return $data;
    }
    
    function cek_stok($produk, $sak=null){
        $sql = "Select * From t_inventory Where nama_produk='".$produk."'";
        if(!empty($sak)){
            $sql .= " And sak=".$sak;
        }
        $data = $this->db->query($sql);        
        return $data;
    }
    
    function create_nota($id){
        $data = $this->db->query("Select tb.*, "
                . "kdr.no_kendaraan, tkdr.type_kendaraan, "
                . "agn.nama_agen, agn.jenis_agen, usr.realname, "
                . "tmb.berat1, tmb.berat2, tmb.berat_kotor, tmb.berat_bersih, tmb.type_potongan, "
                . "tmb.refraksi_faktor, tmb.refraksi_value, tmb.created, tmb.modified, "
                . "tmb.qc01, tmb.qc02, tmb.qc03, tmb.qc04, tmb.qc05, tmb.keterangan "
                . "From t_transaksi_bayar tb "
                . "Left Join m_agen agn On (tb.m_agen_id = agn.id) "
                . "Left Join m_kendaraan kdr On (tb.m_kendaraan_id = kdr.id) "
                . "Left Join m_type_kendaraan tkdr On (kdr.m_type_kendaraan_id = tkdr.id) "
                . "Left Join t_timbang tmb On (tb.t_timbang_id = tmb.id) "
                . "Left Join users usr On (tb.created_by = usr.id) "
                . "Where tb.id=".$id);
        return $data;
    }    
    
    function cek_data_kendaraan_masuk($code){
        $data = $this->db->query("Select * From t_otorisasi Where m_kendaraan_id='".$code."' And status <9");        
        return $data;
    }
    
    function show_data_masuk($id){
        $data = $this->db->query("Select otr.*, agn.nama_agen, kdr.no_kendaraan, mtn.nama_muatan  "
                . "From t_otorisasi otr "
                . "Left Join m_agen agn On (otr.m_agen_id = agn.id) "                
                . "Left Join m_kendaraan kdr On (otr.m_kendaraan_id = kdr.id) "
                . "Left Join m_muatan mtn On (otr.m_muatan_id = mtn.id) "
                . "Where otr.id=".$id);        
        return $data;
    }
    
    function list_data_out(){
        $data = $this->db->query("Select otr.*, agn.nama_agen, kdr.no_kendaraan, mtn.nama_muatan  "
                . "From t_otorisasi otr "
                . "Left Join m_agen agn On (otr.m_agen_id = agn.id) "                
                . "Left Join m_kendaraan kdr On (otr.m_kendaraan_id = kdr.id) "
                . "Left Join m_muatan mtn On (otr.m_muatan_id = mtn.id) "
                . "Where otr.status = 3 "
                . "Order By otr.time_in");
        return $data;
    }
    
    function show_biaya($id){
        $data = $this->db->query("Select bt.*, mb.nama_biaya, mb.type_biaya "
                . "From t_biaya_timbang bt "
                . "Left Join m_biaya mb On (bt.m_biaya_id = mb.id) "
                . "Where bt.t_timbang_id =".$id." Order By bt.id");
        return $data;
    }
    
    function get_biaya($id){
        $data = $this->db->query("Select id, nama_biaya, type_biaya, jumlah "
                . "From m_biaya Where id=".$id);
        return $data;
    }
    
    function list_otorisasi_sagu($muatan=null, $transaksi=null){
        $sql  = "Select otr.*, agn.nama_agen, agn.jenis_agen, "
                . "kdr.no_kendaraan, tkdr.type_kendaraan, mtn.nama_muatan "
                . "From t_otorisasi otr "
                . "Left Join m_agen agn On (otr.m_agen_id = agn.id) "                
                . "Left Join m_kendaraan kdr On (otr.m_kendaraan_id = kdr.id) "
                . "Left Join m_type_kendaraan tkdr On (kdr.m_type_kendaraan_id = tkdr.id) "
                . "Left Join m_muatan mtn On (otr.m_muatan_id = mtn.id) "
                . "Where otr.status in(1,2,3)";
        
        if(!empty($muatan)){
            if($muatan=="MATERIAL"){
                $sql .= "And mtn.nama_muatan like '%LAIN-LAIN%'";
            }else if($muatan=="SAGU"){
                $sql .= "";
            }else{
                $sql .= "And mtn.nama_muatan like '%".$muatan."%' ";
            }
        }
        if(!empty($transaksi)){
            $sql .= "And otr.jenis_transaksi='".$transaksi."' ";
        }
        $sql .= "Order By otr.time_in";
        $data = $this->db->query($sql);        
        return $data;
    }
}