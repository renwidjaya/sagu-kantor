<?php
class Model_modules extends CI_Model{    
    function list_group(){
        $data = $this->db->query("Select id, name AS group_name From groups Where id>1 Order By id");        
        return $data;
    }  
    
    function list_modules(){
        $data = $this->db->query("Select * From modules Where id>1 Order By id");        
        return $data;
    }  
    
    function cek_akses($id_module, $id_group){
        $data = $this->db->query("Select id, akses From roles Where module_id=".$id_module." And group_id=".$id_group." Limit 1");        
        return $data;
    }
    
    function get_akses($module_name, $group_id){
        //Get ID Parent
        $qry_parent = $this->db->query("Select * From modules Where alias='".$module_name."' and parent_id=1"); 
        $parent = $qry_parent->result_array();
        if($parent){
            $parent_id = $parent[0]['id'];
        
            //Get List Modules for this Parent
            $qry_modules = $this->db->query("Select id From modules Where parent_id=".$parent_id." Order By id"); 
            $modules = $qry_modules->result_array();
            $module_id = array();
            foreach ($modules as $value){
                $module_id[] = $value['id'];
            }
            $id_module = implode(',', $module_id);
            //Get role for each modules
            $qry_role = $this->db->query("Select a.*,b.alias From roles a "
                    . "Left Join modules b ON (a.module_id=b.id) "
                    . "Where a.group_id=".$group_id." And a.module_id IN(".$id_module.")"); 
            $role = $qry_role->result_array();

            $hak_akses = array();
            foreach ($role as $key=>$value){
                $hak_akses[$value['alias']] = $value['akses'];
            }            
        }else{
            $hak_akses['index'] = 0;
        }
        return $hak_akses;
    }
}