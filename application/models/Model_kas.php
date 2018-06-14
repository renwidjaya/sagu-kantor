<?php
class Model_kas extends CI_Model{
    function list_nota_bayar($tglAwal, $tglAkhir){
        $data = $this->db->query("Select tb.*,
                    Case
                        When tb.jenis_barang='EKSPEDISI' THEN eksp.nama_ekspedisi
                        Else agn.nama_agen
                    End AS nama_agen,
                    Case
                        When tb.jenis_barang='EKSPEDISI' THEN NULL
                        Else agn.jenis_agen
                    End AS jenis_agen,
                    usr.realname 
                From t_transaksi_bayar tb 
                    Left Join m_agen agn On (tb.m_agen_id = agn.id) 
                    Left Join m_ekspedisi eksp On (tb.m_agen_id = eksp.id)
                    Left Join users usr On (tb.created_by = usr.id) 
                Where tb.dk='D' And tb.tanggal>='".$tglAwal."' And tb.tanggal<='".$tglAkhir."' Order By tb.tanggal");
        return $data;
    }
    
    function list_nota_bayar_gelondongan($tglAwal, $tglAkhir){
        $data = $this->db->query("Select tb.*, agn.nama_agen, 
                usr.realname 
                From t_transaksi_bayar tb 
                    Left Join m_agen agn On (tb.m_agen_id = agn.id) 
                    Left Join users usr On (tb.created_by = usr.id) 
                Where tb.dk='D' And tb.jenis_barang='SINGKONG' 
                    And tb.t_transaksi_bayar_id=0 And flag_bayar=0 and flag_cancel=0 
                    And tb.tanggal>='".$tglAwal."' And tb.tanggal<='".$tglAkhir."' 
                Order By tb.tanggal");
        return $data;
    }
    
    function get_transaksi_bayar($id){
        $data = $this->db->query("Select tb.*, 
                    Case
                        When tb.jenis_barang='EKSPEDISI' THEN eksp.nama_ekspedisi
                        Else agn.nama_agen
                    End AS nama_agen,
                    Case
                        When tb.jenis_barang='EKSPEDISI' THEN NULL
                        Else agn.jenis_agen
                    End AS jenis_agen, 
                    kdr.no_kendaraan, tkdr.type_kendaraan, usr.realname 
                From t_transaksi_bayar tb 
                    Left Join m_agen agn On (tb.m_agen_id = agn.id)
                    Left Join m_ekspedisi eksp On (tb.m_agen_id = eksp.id)
                    Left Join m_kendaraan kdr On (tb.m_kendaraan_id = kdr.id) 
                    Left Join m_type_kendaraan tkdr On (kdr.m_type_kendaraan_id = tkdr.id) 
                    Left Join users usr On (tb.created_by = usr.id) 
                Where tb.id=".$id);
        return $data;
    }
    
    function get_saldo(){
        $data = $this->db->query("Select * From t_saldo Limit 1");
        return $data;
    }
    
    function list_biaya(){
        $data = $this->db->query("Select tby.*, usr.realname "
                . "From t_biaya tby "
                . "Left Join users usr On (tby.created_by = usr.id) "
                . "Where tby.t_kas_id=0 And flag_cancel=0 Order By tby.tanggal");
        return $data;
    }
    
    function get_biaya($id){
        $data = $this->db->query("Select tb.*, usr.realname From t_transaksi_bayar tb "
                . "Left Join users usr On (tb.created_by = usr.id) "
                . "Where tb.id=".$id);
        return $data;
    }
    
    function list_nota_jual($tglAwal, $tglAkhir){
        $data = $this->db->query("Select tb.*, cust.nama_customer, 
                    usr.realname 
                From t_transaksi_bayar tb 
                    Left Join m_customers cust On (tb.m_agen_id = cust.id) 
                    Left Join users usr On (tb.created_by = usr.id) 
                Where tb.dk='K' And tb.tanggal>='".$tglAwal."' And tb.tanggal<='".$tglAkhir."' Order By tb.tanggal");
        return $data;
    }
    
    function get_transaksi_jual($id){
        $data = $this->db->query("Select tj.*, cust.nama_customer, cust.alamat, "
                . "kdr.no_kendaraan, tkdr.type_kendaraan, usr.realname, eksp.nama_ekspedisi, cv.nama_cv, "
                . "tod.no_delivery_order "
                . "From t_transaksi_jual tj "
                . "Left Join m_customers cust On (tj.m_customer_id = cust.id) "
                . "Left Join m_kendaraan kdr On (tj.m_kendaraan_id = kdr.id) "
                . "Left Join m_type_kendaraan tkdr On (kdr.m_type_kendaraan_id = tkdr.id) "
                . "Left Join users usr On (tj.created_by = usr.id) "
                . "Left Join m_ekspedisi eksp On (tj.m_ekspedisi_id = eksp.id) "
                . "Left Join m_cv cv On (tj.m_cv_id = cv.id) "
                . "Left Join t_delivery_order tod On (tj.t_delivery_order_id = tod.id) "
                . "Where tj.id=".$id);
        return $data;
    }
    
    function cek_kasbon($id){
        $data = $this->db->query("Select kbn.*, agn.nama_agen "
                . "From t_kasbon_agen kbn "
                . "Left Join m_agen agn On(kbn.m_agen_id = agn.id) "
                . "Where kbn.m_agen_id=".$id." And flag_bayar=0");
        return $data;
    }
    
    function list_kas_gelondongan(){
        $data = $this->db->query("Select tb.*, cust.nama_customer, 
                usr.realname 
                From t_transaksi_bayar tb 
                    Left Join m_customers cust On (tb.m_agen_id = cust.id) 
                    Left Join users usr On (tb.created_by = usr.id) 
                Where tb.dk='K' And flag_bayar=0 and flag_cancel=0 
                Order By tb.tanggal");
        return $data;
    }
    
    function cek_piutang($id){
        $data = $this->db->query("Select piutang From m_customers Where id=".$id);
        return $data;
    }
}