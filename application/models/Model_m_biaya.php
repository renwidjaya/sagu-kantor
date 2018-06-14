<?php
class Model_m_biaya extends CI_Model{
    function list_data(){
        $data = $this->db->get('m_biaya');
        return $data;
    }

    function cek_data($code){
        $data = $this->db->query("Select * From m_biaya Where nama_biaya='".$code."'");        
        return $data;
    }
    
    function show_data($id){
        $data = $this->db->query("Select * From m_biaya Where id=".$id);        
        return $data;
    }
    
    function get_harga($jenis_transaksi, $nama_biaya, $kategori, $parameter=null){
        $sql = "Select * From m_biaya "
                . "Where jenis_transaksi='".$jenis_transaksi."' "
                . "And nama_biaya='".$nama_biaya."' And kategori='".$kategori."' ";
        if(!empty($parameter)){
            $sql .= " And parameter='".$parameter."' ";
        }
        $sql .= "Limit 1";
        
        $data = $this->db->query($sql);
        return $data;
    }
    
    function get_ongkos($jenis_transaksi, $kategori, $parameter=array()){
        $sql = "Select * From m_biaya "
                . "Where jenis_transaksi='".$jenis_transaksi."' "
                . "And kategori='".$kategori."' ";
        if(!empty($parameter)){
            $sql .= " And (";
            $my_parameter = "";
            foreach ($parameter as $key=>$val){
                $my_parameter .= "parameter='".$key."=".$val."' OR ";
            }
            $sql .= substr($my_parameter, 0, strlen($my_parameter)-3);;
            $sql .= ")";
        }
        
        $data = $this->db->query($sql);
        return $data;
    }
}