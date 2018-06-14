<?php
class Model_pembayaran extends CI_Model{
    function list_data(){
        $data = $this->db->query("Select trf.*, cust.nama_customer, cv.nama_cv 
                From tb_transfer trf
                    Left Join m_customers cust On (trf.m_customer_id = cust.id) 
                    Left Join m_cv cv On (trf.m_cv_id = cv.id) 
                Order By tanggal");
        
        return $data;
    }

    function list_customer(){
        $data = $this->db->query("Select id, nama_customer From m_customers Order By nama_customer");        
        return $data;
    }
    
    function list_cv(){
        $data = $this->db->query("Select id, nama_cv From m_cv Order By nama_cv");        
        return $data;
    }
    
    function get_list_invoice($m_customer_id, $m_cv_id){
        $data = $this->db->query("Select inv.id, inv.tanggal, inv.no_delivery_order,
                    (Select Sum(dtl.total_harga) From t_do_cv_detail dtl Where dtl.t_do_cv_id = inv.id)As total_invoice 
                From t_do_cv inv 
                Where
                    inv.m_customer_id = ".$m_customer_id." And 
                    inv.m_cv_id = ".$m_cv_id." And 
                    inv.flag_bayar=0 
                Order By inv.tanggal");
        
        return $data;        
    }
    
    function get_list_bayar($m_customer_id, $m_cv_id){
        $data = $this->db->query("Select * From tb_transfer
                Where
                    m_customer_id = ".$m_customer_id." And 
                    m_cv_id = ".$m_cv_id." And 
                    jenis_tagihan='SAGU' And 
                    flag_bayar=0 
                Order By tanggal");
        
        return $data;        
    }
    
    function get_sum_bayar($m_customer_id, $m_cv_id){
        $data = $this->db->query("Select Sum(amount) As total_bayar From tb_transfer
                Where
                    m_customer_id = ".$m_customer_id." And 
                    m_cv_id = ".$m_cv_id." And 
                    jenis_tagihan='SAGU' And 
                    flag_bayar=0");
        
        return $data;        
    }
    
}