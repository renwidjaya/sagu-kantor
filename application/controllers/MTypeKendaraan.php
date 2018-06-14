<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MTypeKendaraan extends CI_Controller{
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
        
        $data['judul']  = "MTypeKendaraan";
        $data['content']= "m_type_kendaraan/index";
        $this->load->model('Model_m_type_kendaraan');
        $data['list_data'] = $this->Model_m_type_kendaraan->list_data()->result();

        $this->load->view('layout', $data);
    }
    
    function cek_code(){
        $code = $this->input->post('data');
        $this->load->model('Model_m_type_kendaraan');
        $cek_data = $this->Model_m_type_kendaraan->cek_data($code)->row_array();
        $return_data = ($cek_data)? "ADA": "TIDAK ADA";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function save(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                        'type_kendaraan'=> $this->input->post('type_kendaraan'),
                        'keterangan'=> $this->input->post('keterangan'),
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
       
        $this->db->insert('m_type_kendaraan', $data); 
        redirect('index.php/MTypeKendaraan');       
    }
    
    function delete(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('m_type_kendaraan');            
        }
        redirect('index.php/MTypeKendaraan');
    }
    
    function edit(){
        $id = $this->input->post('id');
        $this->load->model('Model_m_type_kendaraan');
        $data = $this->Model_m_type_kendaraan->show_data($id)->row_array(); 
        
        header('Content-Type: application/json');
        echo json_encode($data);       
    }
    
    function update(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                'type_kendaraan'=> $this->input->post('type_kendaraan'),
                'keterangan'=> $this->input->post('keterangan'),
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('m_type_kendaraan', $data);
        
        redirect('index.php/MTypeKendaraan');
    }
}