<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MAgen extends CI_Controller{
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
        
        $data['judul']  = "MAgen";
        $data['content']= "m_agen/index";
        $this->load->model('Model_m_agen');
        $data['list_data'] = $this->Model_m_agen->list_data()->result();
        
        $this->load->model('Model_back_office');
        $data['list_provinsi']  = $this->Model_back_office->list_provinsi()->result();
        $data['list_city']      = $this->Model_back_office->list_kota(1)->result();
        #$data['list_ekspedisi'] = $this->Model_back_office->list_data_ekspedisi()->result();

        $this->load->view('layout', $data);
    }
    
    function cek_code(){
        $code = $this->input->post('data');
        $this->load->model('Model_m_agen');
        $cek_data = $this->Model_m_agen->cek_data($code)->row_array();
        $return_data = ($cek_data)? "ADA": "TIDAK ADA";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function get_city_list(){ 
        $id = $this->input->post('id');
        $this->load->model('Model_back_office');
        $cities = $this->Model_back_office->list_kota($id)->result(); 
        foreach ($cities as $row) {
            $arr_city[$row->id] = $row->city_name;
        } 
        print form_dropdown('m_city_id', $arr_city);
    }
    
    function save(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                        'nama_agen'=> $this->input->post('nama_agen'),
                        'alamat'=> $this->input->post('alamat'),
                        'm_province_id'=> $this->input->post('m_province_id'),
                        'm_city_id'=> $this->input->post('m_city_id'),
                        'pic'=> $this->input->post('pic'),
                        'telepon'=> $this->input->post('telepon'),
                        'jenis_agen'=> $this->input->post('jenis_agen'),
                        #'m_ekspedisi_id'=> $this->input->post('m_ekspedisi_id'),
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
       
        $this->db->insert('m_agen', $data); 
        redirect('index.php/MAgen');       
    }
    
    function delete(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('m_agen');            
        }
        redirect('index.php/MAgen');
    }
    
    function edit(){
        $id = $this->input->post('id');
        $this->load->model('Model_m_agen');
        $data = $this->Model_m_agen->show_data($id)->row_array(); 
        
        header('Content-Type: application/json');
        echo json_encode($data);       
    }
    
    function update(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                'nama_agen'=> $this->input->post('nama_agen'),
                'alamat'=> $this->input->post('alamat'),
                'm_province_id'=> $this->input->post('m_province_id'),
                'm_city_id'=> $this->input->post('m_city_id'),
                'pic'=> $this->input->post('pic'),
                'telepon'=> $this->input->post('telepon'),
                'jenis_agen'=> $this->input->post('jenis_agen'),
                #'m_ekspedisi_id'=> $this->input->post('m_ekspedisi_id'),
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('m_agen', $data);
        
        redirect('index.php/MAgen');
    }

}