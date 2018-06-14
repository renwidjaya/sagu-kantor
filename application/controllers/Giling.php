<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Giling extends CI_Controller{
    function __construct(){
        parent::__construct();

        if($this->session->userdata('status') != "login"){
            redirect(base_url("index.php/Login"));
        }
    }
    
    function index(){
        $module_name = $this->uri->segment(3);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Giling";
        $data['content']= "giling/index";
        $this->load->model('Model_t_giling');
        $data['list_data'] = $this->Model_t_giling->list_data_giling()->result_array();

        $this->load->view('layout', $data);
    }
    
    function save_giling(){
        $user_id = $this->session->userdata('user_id');
        $tanggal = date('Y-m-d h:m:s');

        if(!empty($this->input->post('tanggal'))){
            $input_tgl = date('Y-m-d', strtotime($this->input->post('tanggal')));
        }else{
            $input_tgl = date('Y-m-d');
        }
        $berat   = $this->input->post('berat_total');
        
        $this->load->model('Model_m_numberings');
        $code = $this->Model_m_numberings->getNumbering('GI', $input_tgl); 

        if(!empty($code)){             
            $data = array(
                            'tanggal'=> $input_tgl,
                            'no_giling'=> $code, 
                            'berat_diproses'=>$berat,
                            'created'=> $tanggal,
                            'created_by'=> $user_id,
                            'modified'=> $tanggal,
                            'modified_by'=> $user_id,
                        );
            $this->db->trans_start();  
            $this->db->insert('t_giling', $data);
            $giling_id = $this->db->insert_id();
            
            foreach ($this->input->post('mydata') as $index=>$value){
                if(isset($value['check']) && $value['check']==1){
                    $this->db->where('id', $value['timbang_id']);
                    $this->db->update('t_timbang', array('t_giling_id'=>$giling_id));
                }
            }
            
            //Save data ke tabel inventory
            //Lihat stok terakhir
            $this->load->model('Model_t_timbang');
            $get_stok = $this->Model_t_timbang->cek_stok('SINGKONG')->row_array(); 
            $stok_id  = $get_stok['id'];
            $stok     = $get_stok['stok']- $berat;

            #Update Stok Singkong ke tabel inventory
            $this->db->where('id', $stok_id);
            $this->db->update('t_inventory', array('stok'=>$stok, 'modified'=>$tanggal, 'modified_by'=>$user_id));

            #Save data ke tabel detail inventory
            $this->db->insert('t_inventory_detail', array(
                't_inventory_id'=>$stok_id,
                'tanggal'=>$input_tgl,
                'jumlah_keluar'=>$berat,
                'referensi_name'=>'t_giling',
                'referensi_id'=>$giling_id
            ));
            
            if($this->db->trans_complete()){
                redirect('index.php/Giling'); 
            }else{
                echo "Terjadi kesalahan saat penyimpanan data giling!<br>";
                echo "<pre>"; die(var_dump($data));
            }
            
        }else{
            echo "Terjadi kesalahan saat penyimpanan data timbang!<br>";
            echo "Penomoran untuk proses giling belum disetup...";
            die();
        }
    }
    
    function list_hasil_giling(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Giling";
        $data['content']= "giling/list_hasil_giling";
        $this->load->model('Model_t_giling');
        $data['list_data'] = $this->Model_t_giling->list_dt_giling()->result();

        $this->load->view('layout', $data);
    }
    
    function view(){
        $module_name = $this->uri->segment(1);
        $id = $this->uri->segment(3);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Giling";
        $data['content']= "giling/view";
        $this->load->model('Model_t_giling');
        $data['list_data'] = $this->Model_t_giling->view_dt_giling($id)->result();
        $data['header'] = $this->Model_t_giling->header_dt_giling($id)->row_array();

        $this->load->view('layout', $data);
    }

}