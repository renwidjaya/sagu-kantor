<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Controller{
    function __construct(){
        parent::__construct();

        if($this->session->userdata('status') != "login"){
            redirect(base_url("index.php/Login"));
        }
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
        
        $data['judul']  = "Groups";
        $data['content']= "groups/index";
        $this->load->model('Model_groups');
        $data['list_data'] = $this->Model_groups->list_data()->result();

        $this->load->view('layout', $data);
    }
    
    function save(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');               
        
        $data = array(
                        'name'=> $this->input->post('group_name'),
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id
                    );
        $this->db->insert('groups', $data);  
        redirect('index.php/Groups');
    }
    
    function cek_code(){
        $code = $this->input->post('data');
        $this->load->model('Model_groups');
        $cek_data = $this->Model_groups->cek_data($code)->row_array();
        $return_data = ($cek_data)? "ADA": "TIDAK ADA";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function edit(){
        $id = $this->input->post('id');
        $this->load->model('Model_groups');
        $data = $this->Model_groups->show_data($id)->row_array(); 
        
        header('Content-Type: application/json');
        echo json_encode($data);       
    }
    
    function update(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');        
                
        $data = array(
                'name'=> $this->input->post('group_name'),
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('groups', $data);
        
        redirect('index.php/Groups');
    }
    
    function delete(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('groups');            
        }
        redirect('index.php/Groups');
    }
}