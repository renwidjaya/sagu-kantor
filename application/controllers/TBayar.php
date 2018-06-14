<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TBayar extends CI_Controller{
    function __construct(){
        parent::__construct();

        if($this->session->userdata('status') != "login"){
            redirect(base_url("index.php/Login"));
        }
    }
    
    function create_pembayaran(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "TBayar/create_pembayaran";
        $data['content']= "bayar/create_pembayaran";
        $this->load->model('Model_bayar');
        $data['list_data'] = $this->Model_bayar->list_data_timbang()->result();

        $this->load->view('layout', $data);
    }
    
    function create_nota_bayar(){
        $id = $this->uri->segment(3);
        if($id){        
            $data['judul']  = "TBayar/create_pembayaran";
            $data['content']= "bayar/create_nota_bayar";
            $this->load->model('Model_bayar');
            $data['mydata'] = $this->Model_bayar->create_nota($id)->row_array();
            $data['mydata']['total_harga']= $data['mydata']['berat_bersih']* $data['mydata']['harga'];
            $this->load->view('layout', $data);
        }else{
            redirect('index.php/TBayar/create_pembayaran'); 
        }
    }
    
    function save_nota_bayar(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $input_tgl = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $this->load->model('Model_m_numberings');
        $code = $this->Model_m_numberings->getNumbering('IFS', $input_tgl); 
        
        if($code){        
            $data = array(
                            'tanggal'=> $input_tgl,
                            'no_nota'=> $code,
                            'tempat_transaksi'=> $this->input->post('tempat_transaksi'),
                            'm_kendaraan_id'=> $this->input->post('m_kendaraan_id'),
                            'm_agen_id'=> $this->input->post('m_agen_id'),
                            'supir'=> $this->input->post('supir'),
                            'jenis_barang'=> $this->input->post('jenis_barang'),
                            'berat_bersih'=> str_replace(".", "", $this->input->post('berat_bersih')),
                            'harga'=> str_replace(".", "", $this->input->post('harga')),
                            'total_harga'=> str_replace(".", "", $this->input->post('total_harga')),
                            'catatan'=> $this->input->post('catatan'),
                            'created'=> $tanggal,
                            'created_by'=> $user_id,
                            'modified'=> $tanggal,
                            'modified_by'=> $user_id,
                        );
            $this->db->trans_start();
            $this->db->insert('t_nota_bayar', $data); 
            
            $id = $this->db->insert_id();
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('t_timbang', array('t_bayar_id'=>$id)); 
            
            if($this->db->trans_complete()){
                redirect('index.php/TBayar/create_pembayaran');   
            }else{
                echo "Terjadi kesalahan saat menyimpan data nota pembayaran..";
                echo "<pre>"; die(var_dump($data));
            }
        }else{
            echo "<pre>"; die("Gagal menyimpan data! Anda belum melakukan setup untuk penomoran nota bayar.");
        }
    }
    
    function list_pembayaran(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "TBayar/list_pembayaran";
        $data['content']= "bayar/list_pembayaran";
        $this->load->model('Model_bayar');
        $data['list_data'] = $this->Model_bayar->list_nota()->result();

        $this->load->view('layout', $data);
    }

}