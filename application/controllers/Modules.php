<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modules extends CI_Controller{   
    function __construct(){
        parent::__construct();

        if($this->session->userdata('status') != "login"){
            redirect(base_url("index.php/Login"));
        }
        $this->load->helper('csv');
    }
    
    function index(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul'] = "Modules";
        $data['content']= "modules/index";
        $this->load->model('Model_modules');
        $data['groups'] = $this->Model_modules->list_group()->result();
        $modules = $this->Model_modules->list_modules()->result();
        $konten = "";
        foreach ($modules as $value){
            if($value->parent_id==1){
                $konten .= "<tr style='background-color:#E7FCC9'>";
                $konten .= "<td>";
                $konten .= "<a href='javascript:;' data-toggle='collapse' data-target='.".$value->id."collapsed'><i class='fa fa-folder-open-o'></i></a> ".$value->alias;
                $konten .= "</td>";
                $konten .= "<td></td>";
                foreach ($data['groups'] as $row){
                    $konten .= "<td></td>";
                }
                $konten .= "</tr>";
            }else{
                $konten .= "<tr class='collapse out ".$value->parent_id."collapsed'>";
                $konten .= "<td>";
                $konten .= "&nbsp; &nbsp; <i class='fa fa-plane'></i> ".$value->alias;
                $konten .= "</td>";
                $konten .= "<td style='text-align:center'><i class='fa fa-check-square-o'></i></td>";
                $id_module = $value->id;
                foreach ($data['groups'] as $row){
                    $id_group = $row->id;
                    $akses = $this->Model_modules->cek_akses($id_module, $id_group)->result();
                    if($akses){
                        if($akses[0]->akses==1){
                            $konten .= "<td style='text-align:center'><input type='checkbox' "
                                    . "id='chk_".$value->id."-".$row->id."' class='mycheck' checked onclick='update_roles(this.id)'></td>";
                        }else{
                            $konten .= "<td style='text-align:center'><input type='checkbox' "
                                    . "id='chk_".$value->id."-".$row->id."' class='mycheck' onclick='update_roles(this.id)'></td>";
                        }
                    }else{
                        $konten .= "<td style='text-align:center'><input type='checkbox' "
                                . "id='chk_".$value->id."-".$row->id."' class='mycheck' onclick='update_roles(this.id)'></td>";
                    }
                }
                $konten .= "</tr>";
            }
            
        }
        $data['konten'] = $konten;
        $this->load->view('layout', $data);                          		
    }
    
    function update(){
        $post_data= $this->input->post('data');
        $isi_data = explode("^", $post_data);
        
        $module_id  = $isi_data[0];
        $group_id   = $isi_data[1];
        $nilai      = $isi_data[2];
        
        $data = array(
                'module_id'=> $module_id,
                'group_id'=> $group_id,
                'akses'=> $nilai
            );
        
        $this->load->model('Model_modules');
        //Cek if exist
        $cek = $this->Model_modules->cek_akses($module_id, $group_id)->result();
        if($cek){
            $role_id = $cek[0]->id;
            $this->db->where('id', $role_id);
            $this->db->update('roles', $data);
        }else{
            $this->db->insert('roles', $data); 
        }
    }
    
    function export(){
        $query = $this->db->query('SELECT * FROM modules');        
        $num = $query->num_fields();
        $var = array();
        $i   = 1;
        $fname = "";
        while($i<=$num){
            $test  = $i;
            $value = $this->input->post($test);

            if($value != ''){
                $fname = $fname." ".$value;
                array_push($var, $value);
            }
            $i++;
        }
        $fname = trim($fname);
        $fname = str_replace(' ', ',', $fname);

        $this->db->select($fname);
        $quer = $this->db->get('modules');
        query_to_csv($quer, TRUE, 'Modules_'.date('dMy').'.csv');
    }
    
    function import(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul'] = "Modules";
        $data['content']= "modules/import";
        $this->load->view('layout', $data); 
    }
    
    function upload(){
        if (!empty($_FILES['document_url']['tmp_name'])) {
            $ekstensi = pathinfo($_FILES['document_url']['name'], PATHINFO_EXTENSION);
        }
        if($ekstensi=="csv"){
            $this->db->query('TRUNCATE TABLE modules'); 
            
            $handle = fopen($_FILES['document_url']['tmp_name'], "r");
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $row = array(
                        'id'=>$data[0],
                        'parent_id'=>$data[1],
                        'alias'=>$data[2]
                    );
                $this->db->insert('modules', $row); 
            }
            
            fclose($handle); 
            redirect('index.php/Modules');
        }else{
            echo "Your file type is not supported";
            header("refresh:2;url=".base_url()."index.php/Modules");
        }
    }

}