<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SisaProduksi extends CI_Controller{
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
        
        $data['judul']  = "SisaProduksi";
        $data['content']= "sisa_produksi/index";
        $this->load->model('Model_t_sisa_produksi');
        $data['list_data'] = $this->Model_t_sisa_produksi->list_data()->result();
        $this->load->view('layout', $data);
    }
    
    function load_last_data(){
        $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $this->load->model('Model_t_sisa_produksi');
        $last_date = $this->Model_t_sisa_produksi->get_last_date($tanggal)->row_array();
        $produksi = array();
        if($last_date){
            $get_data1 = $this->Model_t_sisa_produksi->get_last_data($last_date['tanggal'], 1, 25)->row_array();
            if($get_data1){
                $produksi[25][1]= $get_data1['sisa_sak'];
            }else{
                $produksi[25][1]= 0;
            }
            $get_data2 = $this->Model_t_sisa_produksi->get_last_data($last_date['tanggal'], 1, 50)->row_array();
            if($get_data2){
                $produksi[50][1]= $get_data2['sisa_sak'];
            }else{
                $produksi[50][1]= 0;
            }
            $get_data3 = $this->Model_t_sisa_produksi->get_last_data($last_date['tanggal'], 2, 25)->row_array();
            if($get_data3){
                $produksi[25][2]= $get_data3['sisa_sak'];
            }else{
                $produksi[25][2]= 0;
            }
            $get_data4 = $this->Model_t_sisa_produksi->get_last_data($last_date['tanggal'], 2, 50)->row_array();
            if($get_data4){
                $produksi[50][2]= $get_data4['sisa_sak'];
            }else{
                $produksi[50][2]= 0;
            }
            $produksi['total']['25'] = array_sum($produksi[25])*25;
            $produksi['total']['50'] = array_sum($produksi[50])*50;
            $produksi['total']['all']= $produksi['total']['25']+ $produksi['total']['50'];
            $produksi['last_date']   = date('d-m-Y', strtotime($last_date['tanggal']));
        }else{
            $produksi[25][1] = 0;
            $produksi[25][2] = 0;
            $produksi[50][1] = 0;
            $produksi[50][2] = 0;
            $produksi['total'][25] = 0;
            $produksi['total'][50] = 0;
            $produksi['total']['all'] = 0;
            $produksi['last_date'] = "";
        }
        
        header('Content-Type: application/json');
        echo json_encode($produksi);  
    }
    
    function cek_tanggal(){
        $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $this->load->model('Model_t_sisa_produksi');
        $cek_data = $this->Model_t_sisa_produksi->cek_tanggal($tanggal)->row_array();
        $return_data = ($cek_data)? "ADA": "TIDAK ADA";        
        
        header('Content-Type: application/json');
        echo json_encode($return_data);  
    }
    
    function save(){
        $this->load->model('Model_t_sisa_produksi');
        $user_id = $this->session->userdata('user_id');
        $tanggal = date('Y-m-d h:m:s');
        $input_tgl = date('Y-m-d', strtotime($this->input->post('tanggal')));

        $this->db->trans_start(); 

        $sisa[0]['oven'] = 1;
        $sisa[0]['sak']  = 25;        
        $sisa[0]['sisa_sak'] = $this->input->post('sisa[1][25][jumlah]');
        $sisa[0]['jumlah']   = $sisa[0]['sisa_sak']* 25;
        $sisa[0]['selisih']  = $this->input->post('prod[1][25][jumlah]')- $this->input->post('sisa[1][25][jumlah]');
        
        $sisa[1]['oven'] = 1;
        $sisa[1]['sak']  = 50;
        $sisa[1]['sisa_sak'] = $this->input->post('sisa[1][50][jumlah]');
        $sisa[1]['jumlah']   = $sisa[1]['sisa_sak']* 50;
        $sisa[1]['selisih']  = $this->input->post('prod[1][50][jumlah]')- $this->input->post('sisa[1][50][jumlah]');
        
        $sisa[2]['oven'] = 2;
        $sisa[2]['sak']  = 25;
        $sisa[2]['sisa_sak'] = $this->input->post('sisa[2][25][jumlah]');
        $sisa[2]['jumlah']   = $sisa[2]['sisa_sak']* 25;
        $sisa[2]['selisih']  = $this->input->post('prod[2][25][jumlah]')- $this->input->post('sisa[2][25][jumlah]');
        
        $sisa[3]['oven'] = 2;
        $sisa[3]['sak']  = 50;
        $sisa[3]['sisa_sak'] = $this->input->post('sisa[2][50][jumlah]');
        $sisa[3]['jumlah']   = $sisa[3]['sisa_sak']* 50;
        $sisa[3]['selisih']  = $this->input->post('prod[2][50][jumlah]')- $this->input->post('sisa[2][50][jumlah]');

        foreach ($sisa as $key=>$value){
            $cek_data = $this->Model_t_sisa_produksi->get_last_data($input_tgl, $value['oven'], $value['sak'])->row_array();
            if($cek_data){
                $this->db->where(array('tanggal'=> $input_tgl, 'oven'=>$value['oven'], 'sak'=>$value['sak']));
                $this->db->update('t_sisa_produksi', array(
                    'sisa_sak'=> $value['sisa_sak'], 
                    'jumlah'=> $value['jumlah'],
                    'selisih'=>$value['selisih'],
                    'modified'=> $tanggal,
                    'modified_by'=>$user_id 
                ));
            }else{
                $this->db->insert('t_sisa_produksi', array(
                    'tanggal'=> $input_tgl, 
                    'oven'=> $value['oven'], 
                    'sak'=>$value['sak'],
                    'sisa_sak'=> $value['sisa_sak'], 
                    'jumlah'=> $value['jumlah'],
                    'selisih'=>$value['selisih'],
                    'created'=> $tanggal,
                    'created_by'=> $user_id,
                    'modified'=> $tanggal,
                    'modified_by'=>$user_id
                ));
            }
        }
 
        if($this->db->trans_complete()){
            redirect('index.php/SisaProduksi'); 
        }else{
            echo "Terjadi kesalahan saat penyimpanan data sisa produksi!<br>";
            echo "<pre>"; die(var_dump($this->input->post()));
        }
    }

}