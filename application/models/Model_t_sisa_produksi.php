<?php
class Model_t_sisa_produksi extends CI_Model{
    function list_data(){
        $data = $this->db->query("Select * From t_sisa_produksi "
                . "Order By tanggal, oven, sak");
        return $data;
    }
    
    function get_last_date($tanggal){        
        $data = $this->db->query("Select distinct tanggal From t_sisa_produksi Where tanggal<'".$tanggal."' "
                . "Order By tanggal Desc Limit 1");
        return $data;
    }
    
    function get_last_data($tanggal, $oven, $sak){
        $data = $this->db->query("Select * From t_sisa_produksi Where tanggal='".$tanggal."' "
                . "And oven=".$oven." And sak=".$sak." Limit 1");
        return $data;
    }
    
    function cek_tanggal($tanggal){
        $data = $this->db->query("Select * From t_sisa_produksi Where tanggal='".$tanggal."'");
        return $data;
    }
}