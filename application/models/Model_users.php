<?php
class Model_users extends CI_Model{
    function cek_login($username, $password){		
        $data = $this->db->query("Select usr.*, grp.name AS group_name From users usr "
                . "Left Join groups grp ON (usr.group_id=grp.id) "
                . "Where usr.username='".$username."' And usr.password='".$password."' And usr.active=1");        
        return $data;
    }	
    
    function list_data(){
        $data = $this->db->query("Select usr.*, grp.name AS group_name From users usr "
                . "Left Join groups grp ON (usr.group_id=grp.id) "
                . "Order By usr.id");        
        return $data;
    }
    
    function cek_data($code){
        $data = $this->db->query("Select * From users Where username='".$code."'");        
        return $data;
    }
    
    function show_data($id){
        $data = $this->db->query("Select usr.*, grp.name AS group_name From users usr "
                . "Left Join groups grp ON (usr.group_id=grp.id) "
                . " Where usr.id=".$id);        
        return $data;
    }
   
}