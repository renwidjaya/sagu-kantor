<?php
class Model_groups extends CI_Model{
    function list_data(){
        $data = $this->db->get('groups');
        return $data;
    }

    function cek_data($name){
        $data = $this->db->query("Select * From groups Where name='".$name."'");        
        return $data;
    }
    
    function show_data($id){
        $data = $this->db->query("Select * From groups Where id=".$id);        
        return $data;
    }
}