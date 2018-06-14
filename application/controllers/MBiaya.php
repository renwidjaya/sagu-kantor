<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MBiaya extends CI_Controller{
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
        
        $data['judul']  = "MBiaya";
        $data['content']= "m_biaya/index";
        $this->load->model('Model_m_biaya');
        $data['list_data'] = $this->Model_m_biaya->list_data()->result();

        $this->load->view('layout', $data);
    }
    
    /*function cek_code(){
        $code = $this->input->post('data');
        $this->load->model('Model_m_biaya');
        $cek_data = $this->Model_m_biaya->cek_data($code)->row_array();
        $return_data = ($cek_data)? "ADA": "TIDAK ADA";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }*/
    
    function save(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                        'jenis_transaksi'=> $this->input->post('jenis_transaksi'),
                        'nama_biaya'=> $this->input->post('nama_biaya'),
                        'kategori'=> $this->input->post('kategori'),
                        'parameter'=> $this->input->post('parameter'),
                        'keterangan'=> $this->input->post('keterangan'),
                        'type_biaya'=> $this->input->post('type_biaya'),
                        'satuan'=> $this->input->post('satuan'),
                        'jumlah'=> str_replace('.', '', $this->input->post('jumlah')),
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
       
        $this->db->insert('m_biaya', $data); 
        redirect('index.php/MBiaya');       
    }
    
    function delete(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('m_biaya');            
        }
        redirect('index.php/MBiaya');
    }
    
    function edit(){
        $id = $this->input->post('id');
        $this->load->model('Model_m_biaya');
        $data = $this->Model_m_biaya->show_data($id)->row_array(); 
        $data['jumlah'] = number_format($data['jumlah'],0,',','.');
        
        header('Content-Type: application/json');
        echo json_encode($data);       
    }
    
    function update(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $jumlah     = str_replace('.', '', $this->input->post('jumlah'));
        $old_jumlah = str_replace('.', '', $this->input->post('old_jumlah'));
        $parameter  = $this->input->post('parameter');
        $old_parameter = $this->input->post('old_parameter');
        
        $data = array(
                'jenis_transaksi'=> $this->input->post('jenis_transaksi'),
                'nama_biaya'=> $this->input->post('nama_biaya'),
                'kategori'=> $this->input->post('kategori'),
                'parameter'=> $parameter,
                'keterangan'=> $this->input->post('keterangan'),
                'type_biaya'=> $this->input->post('type_biaya'),
                'satuan'=> $this->input->post('satuan'),
                'jumlah'=> $jumlah,
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->trans_start();
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('m_biaya', $data);
        
        if(($jumlah != $old_jumlah)||($parameter!= $old_parameter)){
            $this->db->insert('m_biaya_detail', array(
                'm_biaya_id'=>$this->input->post('id'),
                'jenis_transaksi'=> $this->input->post('jenis_transaksi'),
                'nama_biaya'=> $this->input->post('nama_biaya'),
                'kategori'=> $this->input->post('kategori'),
                'parameter'=> $old_parameter,
                'keterangan'=> $this->input->post('keterangan'),
                'type_biaya'=> $this->input->post('type_biaya'),
                'satuan'=> $this->input->post('satuan'),
                'jumlah'=> $old_jumlah,
                'created'=> $tanggal,
                'created_by'=> $user_id
            )); 
        }
        
        if($this->db->trans_complete()){
            redirect('index.php/MBiaya');
        }else{
            echo "Error! Terjadi kesalahan saat menyimpan data...<br>";
            echo "<pre>"; die(var_dump($this->input->post()));
        }
    }

}