<?php
class Model_t_kapasitas extends CI_Model{
    function list_data_kapasitas_mesin(){
        $data = $this->db->query("Select * From t_kapasitas_mesin Where type_mesin=9 "
                . "Order By tanggal_start");
        return $data;
    }
    
    function get_kapasitas_mesin($id){
        $data = $this->db->query("Select * From t_kapasitas_mesin Where id=".$id);
        return $data;
    }
    
    function list_data_kapasitas_oven(){
        $data = $this->db->query("Select * From t_kapasitas_mesin Where type_mesin in(1,2) "
                . "Order By tanggal_start");
        return $data;
    }
    
    function get_operasional_mesin($tanggal, $type_mesin){
        $data = $this->db->query("Select jam_start, jam_stop, waktu, waktu2 From "
                . "t_kapasitas_mesin Where tanggal_start='".$tanggal."' "
                . "And type_mesin=".$type_mesin." Limit 1");
        return $data;
    }
}