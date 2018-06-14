<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kapasitas extends CI_Controller{
    function __construct(){
        parent::__construct();

        if($this->session->userdata('status') != "login"){
            redirect(base_url("index.php/Login"));
        }
    }
    
    function kapasitas_mesin(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Kapasitas/kapasitas_mesin";
        $data['content']= "kapasitas/kapasitas_mesin";
        $this->load->model('Model_t_kapasitas');
        $data['list_data'] = $this->Model_t_kapasitas->list_data_kapasitas_mesin()->result();
        $this->load->view('layout', $data);
    }
    
    function save_mesin(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $jam_start = new DateTime($this->input->post('jam_start'));
        $jam_stop  = new DateTime($this->input->post('jam_stop'));
        $selisih   = $jam_stop->diff($jam_start);

        $jam   = $selisih->format('%h');
        $menit = $selisih->format('%i');

        if($menit >= 0 && $menit <= 9){
            $menit = "0".$menit;
        }
        $waktu  = $jam.":".$menit;
        $menit2 = round(($menit/60)* 100);
        $waktu2 = $jam.".".$menit2;
        
        $data = array(
                        'type_mesin'=>9,
                        'tanggal_start'=> date('Y-m-d', strtotime($this->input->post('tanggal_start'))),
                        'jam_start'=> $this->input->post('jam_start'),
                        'tanggal_stop'=> date('Y-m-d', strtotime($this->input->post('tanggal_stop'))),
                        'jam_stop'=> $this->input->post('jam_stop'),
                        'delay'=> $this->input->post('delay'),
                        'waktu'=>$waktu,
                        'waktu2'=>$waktu2,
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
       
        if($this->db->insert('t_kapasitas_mesin', $data)){
            redirect('index.php/Kapasitas/kapasitas_mesin');   
        }else{
            echo "Terjadi kesalahan saat menyimpan data!<br>";
            echo "<pre>"; die(var_dump($data));
        }
    }
    
    function edit_mesin(){
        $id = $this->input->post('id');
        $this->load->model('Model_t_kapasitas');
        $data = $this->Model_t_kapasitas->get_kapasitas_mesin($id)->row_array(); 
        $data['tanggal_start'] = date('d-m-Y', strtotime(($data['tanggal_start'])));
        $data['tanggal_stop'] = date('d-m-Y', strtotime(($data['tanggal_stop'])));
        
        header('Content-Type: application/json');
        echo json_encode($data);       
    }
    
    function update_mesin(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $jam_start = new DateTime($this->input->post('jam_start'));
        $jam_stop  = new DateTime($this->input->post('jam_stop'));
        $selisih   = $jam_stop->diff($jam_start);

        $jam   = $selisih->format('%h');
        $menit = $selisih->format('%i');

        if($menit >= 0 && $menit <= 9){
            $menit = "0".$menit;
        }
        $waktu  = $jam.":".$menit;
        $menit2 = round(($menit/60)* 100);
        $waktu2 = $jam.".".$menit2;  
        
        $data = array(
                'tanggal_start'=> date('Y-m-d', strtotime($this->input->post('tanggal_start'))),
                'jam_start'=> $this->input->post('jam_start'),
                'tanggal_stop'=> date('Y-m-d', strtotime($this->input->post('tanggal_stop'))),
                'jam_stop'=> $this->input->post('jam_stop'),
                'delay'=> $this->input->post('delay'),
                'waktu'=>$waktu,
                'waktu2'=>$waktu2,
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('t_kapasitas_mesin', $data);
        
        redirect('index.php/Kapasitas/kapasitas_mesin');
    }
    
    function delete_mesin(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('t_kapasitas_mesin');            
        }
        redirect('index.php/Kapasitas/kapasitas_mesin');
    }
    
    function kapasitas_oven(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Kapasitas/kapasitas_oven";
        $data['content']= "kapasitas/kapasitas_oven";
        $this->load->model('Model_t_kapasitas');
        $data['list_data'] = $this->Model_t_kapasitas->list_data_kapasitas_oven()->result();
        $this->load->view('layout', $data);
    }
    
    function save_oven(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $this->db->trans_start();
        $mydata = $this->input->post('mydata');
        foreach ($mydata as $key=>$value){              
            $jam_start = new DateTime($value['jam_start']);
            $jam_stop  = new DateTime($value['jam_stop']);
            $selisih   = $jam_stop->diff($jam_start);

            $jam   = $selisih->format('%h');
            $menit = $selisih->format('%i');

            if($menit >= 0 && $menit <= 9){
                $menit = "0".$menit;
            }
            $waktu  = $jam.":".$menit;
            $menit2 = round(($menit/60)* 100);
            $waktu2 = $jam.".".$menit2;

            $data = array(
                        'type_mesin'=>$value['type_mesin'],
                        'tanggal_start'=> date('Y-m-d', strtotime($value['tanggal_start'])),
                        'jam_start'=> $value['jam_start'],
                        'tanggal_stop'=> date('Y-m-d', strtotime($value['tanggal_stop'])),
                        'jam_stop'=> $value['jam_stop'],
                        'delay'=> $value['delay'],
                        'waktu'=>$waktu,
                        'waktu2'=>$waktu2,
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
            $this->db->insert('t_kapasitas_mesin', $data);
        }
        if($this->db->trans_complete()){
            redirect('index.php/Kapasitas/kapasitas_oven');   
        }else{
            echo "Terjadi kesalahan saat menyimpan data!<br>";
            echo "<pre>"; die(var_dump($data));
        }
    }
    
    function update_oven(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $jam_start = new DateTime($this->input->post('jam_start'));
        $jam_stop  = new DateTime($this->input->post('jam_stop'));
        $selisih   = $jam_stop->diff($jam_start);

        $jam   = $selisih->format('%h');
        $menit = $selisih->format('%i');

        if($menit >= 0 && $menit <= 9){
            $menit = "0".$menit;
        }
        $waktu  = $jam.":".$menit;
        $menit2 = round(($menit/60)* 100);
        $waktu2 = $jam.".".$menit2; 
        
        $data = array(
                'tanggal_start'=> date('Y-m-d', strtotime($this->input->post('tanggal_start'))),
                'jam_start'=> $this->input->post('jam_start'),
                'tanggal_stop'=> date('Y-m-d', strtotime($this->input->post('tanggal_stop'))),
                'jam_stop'=> $this->input->post('jam_stop'),
                'delay'=> $this->input->post('delay'),
                'waktu'=>$waktu,
                'waktu2'=>$waktu2,
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('t_kapasitas_mesin', $data);
        
        redirect('index.php/Kapasitas/kapasitas_oven');
    }
    
    function delete_oven(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('t_kapasitas_mesin');            
        }
        redirect('index.php/Kapasitas/kapasitas_oven');
    }

}