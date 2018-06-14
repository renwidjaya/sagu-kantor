<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Oven extends CI_Controller{
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
        
        $data['judul']  = "Oven";
        $data['content']= "oven/index";
        $this->load->model('Model_t_oven');
        $data['list_data']   = $this->Model_t_oven->list_data()->result();
        $data['list_giling'] = $this->Model_t_oven->list_giling()->result();
        $data['list_cv'] = $this->Model_t_oven->list_cv()->result();
        
        $this->load->view('layout', $data);
    }
    
    function save(){
        $user_id = $this->session->userdata('user_id');
        $tanggal = date('Y-m-d h:m:s');
        
        $input_tgl   = date('Y-m-d');
        $t_giling_id = $this->input->post('t_giling_id');
        $m_cv_id     = $this->input->post('m_cv_id');
        
        $this->load->model('Model_t_oven');
        $giling = $this->Model_t_oven->get_no_giling($t_giling_id)->row_array();
        $no_giling = $giling['no_giling'];
        
        $this->db->trans_start(); 
        
        $this->db->where('t_giling_id', $this->input->post('t_giling_id'));
        $this->db->update('t_oven', array(
                    'm_cv_id'=>$this->input->post('m_cv_id'),
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id
        ));        
        
        $data_oven = $this->Model_t_oven->get_data_oven($t_giling_id)->result();
        
        #Update ke tabel inventory
        $produk = array();
        $produk['PULAU']['25'] = 0;
        $produk['PULAU']['50'] = 0;
        $produk['KWR']['25']   = 0;
        $produk['KWR']['50']   = 0;
        $produk['PH']['25']    = 0;
        $produk['PH']['50']    = 0;
        $produk['POLOS']['25'] = 0;
        $produk['POLOS']['50'] = 0;

        foreach ($data_oven as $key=>$value){
            if($value->sak == 25){
                $produk['PULAU']['25']  += $value->sagu_pulau;
                $produk['KWR']['25']    += $value->sagu_kwr;
                $produk['PH']['25']     += $value->sagu_ph;
                $produk['POLOS']['25']  += $value->sagu_polos;
            }else{
                $produk['PULAU']['50']  += $value->sagu_pulau;
                $produk['KWR']['50']    += $value->sagu_kwr;
                $produk['PH']['50']     += $value->sagu_ph;
                $produk['POLOS']['50']  += $value->sagu_polos;
            }
        }
        
        foreach ($produk as $index=>$val){
            foreach ($val as $idx=>$nilai){
                $get_stok = $this->Model_t_oven->cek_stok('SAGU '.$index, $m_cv_id, $idx)->row_array(); 
                $stok_id  = $get_stok['id'];
                $stok     = $get_stok['stok']+ $nilai;

                $this->db->where('id', $stok_id);
                $this->db->update('t_inventory', array('stok'=>$stok, 
                                'modified'=>$tanggal, 'modified_by'=>$user_id));

                #Save data ke tabel detail inventory
                $this->db->insert('t_inventory_detail', array(
                    't_inventory_id'=>$stok_id,
                    'tanggal'=>$input_tgl,
                    'jumlah_masuk'=>$nilai,
                    'referensi_name'=>'t_giling',
                    'referensi_id'=>$t_giling_id,
                    'referensi_no'=>$no_giling,
                ));
            }
        }
        
        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Data berhasil disimpan');
            redirect('index.php/Laporan/hasil_oven'); 
        }else{
            echo "Terjadi kesalahan saat penyimpanan data!<br>";
            echo "<pre>"; die(var_dump($this->input->post()));
        }
    }
}