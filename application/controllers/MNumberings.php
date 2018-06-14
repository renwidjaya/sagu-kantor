<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MNumberings extends CI_Controller{
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
        
        $data['judul']  = "MNumberings";
        $data['content']= "m_numberings/index";
        $this->load->model('Model_m_numberings');
        $data['list_data'] = $this->Model_m_numberings->list_data()->result();

        $this->load->view('layout', $data);
    }
    
    function cek_code(){
        $code = $this->input->post('data');
        $this->load->model('Model_m_numberings');
        $cek_data = $this->Model_m_numberings->cek_data($code)->row_array();
        $return_data = ($cek_data)? "ADA": "TIDAK ADA";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function save(){        
        $data = array(
                    'prefix'=> $this->input->post('prefix'),
                    'date_info'=> ($this->input->post('date_info')=="on")? 1: 0,
                    'padding'=> $this->input->post('padding'),
                    'prefix_separator'=> $this->input->post('prefix_separator'),
                    'date_separator'=> $this->input->post('date_separator')
                );
        
        $this->db->insert('m_numberings', $data); 
        redirect('index.php/MNumberings');
    }
    
    function delete(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('m_numberings');            
        }
        redirect('index.php/MNumberings');
    }
    
    function edit(){
        $id = $this->input->post('id');
        $this->load->model('Model_m_numberings');
        $data = $this->Model_m_numberings->show_data($id)->row_array(); 
        
        header('Content-Type: application/json');
        echo json_encode($data);        
    }
    
    function update(){        
        $data = array(
                'prefix'=> $this->input->post('prefix'),
                'date_info'=> ($this->input->post('date_info')=="on")? 1: 0,
                'padding'=> $this->input->post('padding'),
                'prefix_separator'=> $this->input->post('prefix_separator'),
                'date_separator'=> $this->input->post('date_separator')
            );
        #echo "<pre>"; die(var_dump($this->input->post()));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('m_numberings', $data);
        
        redirect('index.php/MNumberings');
    }
}