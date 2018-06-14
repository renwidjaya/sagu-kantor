<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller{   
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
        $data['judul']     = "Users";
        $data['content']   = "users/index";
        
        $this->load->model('Model_users');
        $data['list_data'] = $this->Model_users->list_data()->result();
        
        $this->load->model('Model_groups');
        $data['list_group'] = $this->Model_groups->list_data()->result();
        
        $this->load->view('layout', $data);  
    }
        
    function save(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        if (!empty($_FILES['photo_profile_url']['tmp_name'])) {
            $config['upload_path']   = './uploads/users'; 
            $config['allowed_types'] = 'gif|jpg|png'; 
            $config['max_size']      = 2 * 1024; 
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('photo_profile_url')) {
                $data = array('upload_data' => $this->upload->data()); 
                $file_url = $data['upload_data']['file_name'];                
            }else { 
                $error = array('error' => $this->upload->display_errors()); 
                $file_url = "";
            }
        }else{
            $file_url = "";
        }
        
        $data = array(
                        'username'=> $this->input->post('username'),
                        'realname'=> $this->input->post('realname'),
                        'password'=> base64_encode($this->input->post('password')),
                        'group_id'=> $this->input->post('group_id'),
                        'active'=> ($this->input->post('active')=="on")? 1: 0,
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                        'photo_profile_url'=>$file_url
                    );
        $this->db->insert('users', $data);  
        redirect('index.php/Users');
    }
    
    function cek_code(){
        $code = $this->input->post('data');
        $this->load->model('Model_users');
        $cek_data = $this->Model_users->cek_data($code)->row_array();
        $return_data = ($cek_data)? "ADA": "TIDAK ADA";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function edit(){
        $id = $this->input->post('id');
        $this->load->model('Model_users');
        $data = $this->Model_users->show_data($id)->row_array(); 
        $data['password'] = base64_decode($data['password']);
        
        header('Content-Type: application/json');
        echo json_encode($data);       
    }
    
    function update(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        if (!empty($_FILES['photo_profile_url']['tmp_name'])) {
            $config['upload_path']   = './uploads/users'; 
            $config['allowed_types'] = 'gif|jpg|png'; 
            $config['max_size']      = 2 * 1024; 
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('photo_profile_url')) {
                $data = array('upload_data' => $this->upload->data()); 
                $file_url = $data['upload_data']['file_name'];                
            }else { 
                $error = array('error' => $this->upload->display_errors()); 
                $file_url = "";
            }
        }else{
            if(!empty($this->input->post('photo_url'))){
                $file_url = $this->input->post('photo_url');
            }else{
                $file_url = "";
            }
        }
        
        $data = array(
                'username'=> $this->input->post('username'),
                'realname'=> $this->input->post('realname'),
                'password'=> base64_encode($this->input->post('password')),
                'group_id'=> $this->input->post('group_id'),
                'active'=> ($this->input->post('active')=="on")? 1: 0,
                'modified'=> $tanggal,
                'modified_by'=> $user_id,
                'photo_profile_url'=>$file_url
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('users', $data);
        
        redirect('index.php/Users');
    }
    
    function delete(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('users');            
        }
        redirect('index.php/Users');
    }

    function change_password(){  
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']   = $group_id;
        $data['judul']      = "Users";
        $data['content']    = "users/change_password";
        $this->load->view('layout', $data); 
    }
    
    function update_password(){
        $user_id    = $this->session->userdata('user_id');
        $user_name  = $this->session->userdata('username');
        $post_data  = $this->input->post('data');
        $isi_data   = explode("^", $post_data);
        
        $old_password = base64_encode($isi_data[0]);
        $new_password = base64_encode($isi_data[1]);
        $tanggal = date('Y-m-d h:m:s');
        
        $this->load->model('Model_users');
        $cek = $this->Model_users->cek_login($user_name, $old_password)->row_array();
        if($cek){
            $data = array(
                    'id'=>$user_id,
                    'password'=> $new_password,
                    'modified'=> $tanggal,
                );
            
            $this->db->where('id', $user_id);
            $this->db->update('users', $data);
            
            $url = "SUKSES";
        }else{
            $url = "SALAH";
        }
        header('Content-Type: application/json');
        echo json_encode($url);
    }
}