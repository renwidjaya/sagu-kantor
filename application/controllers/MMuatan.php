<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MMuatan extends CI_Controller{
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
        
        $data['judul']  = "MMuatan";
        $data['content']= "m_muatan/index";
        $this->load->model('Model_m_muatan');
        $data['list_data'] = $this->Model_m_muatan->list_data()->result();

        $this->load->view('layout', $data);
    }
    
    function cek_code(){
        $code = $this->input->post('data');
        $this->load->model('Model_m_muatan');
        $cek_data = $this->Model_m_muatan->cek_data($code)->row_array();
        $return_data = ($cek_data)? "ADA": "TIDAK ADA";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function save(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                        'nama_muatan'=> $this->input->post('nama_muatan'),
                        'keterangan'=> $this->input->post('keterangan'),
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
       
        $this->db->insert('m_muatan', $data); 
        $this->session->set_flashdata('flash_msg', 'Data berhasil disimpan');
        redirect('index.php/MMuatan');       
    }
    
    function delete(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('m_muatan');            
        }
        $this->session->set_flashdata('flash_msg', 'Data berhasil dihapus');
        redirect('index.php/MMuatan');
    }
    
    function edit(){
        $id = $this->input->post('id');
        $this->load->model('Model_m_muatan');
        $data = $this->Model_m_muatan->show_data($id)->row_array(); 
        
        header('Content-Type: application/json');
        echo json_encode($data);       
    }
    
    function update(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                'nama_muatan'=> $this->input->post('nama_muatan'),
                'keterangan'=> $this->input->post('keterangan'),
                'flag_sinkronisasi'=>0,
                'flag_action'=>'U',
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('m_muatan', $data);
        
        $this->session->set_flashdata('flash_msg', 'Data berhasil disimpan');
        redirect('index.php/MMuatan');
    }
    
    function generate_kategori(){
        $id = $this->input->post('id');
        $this->load->model('Model_m_muatan');
        $return_data = "";
        $no = 1;
        $myKategori = $this->Model_m_muatan->get_muatan_type($id)->result();
        foreach ($myKategori as $index=>$value){
            $return_data .= '<tr><td style="text-align:center">'.$no.'</td>';
            $return_data .= '<td>'.$value->muatan_type.'</td>';
            $return_data .= '<td style="text-align:center"><a href="javascript:;" class="btn btn-circle btn-xs red" onclick="hapusKategori('.$value->id.');">&nbsp; <i class="fa fa-trash-o"></i> Hapus &nbsp;</a></td>';
            $return_data .= '</tr>';
            $no++;
        }

        $return_data .='<tr><td style="text-align:center">'.$no.'</td>';
        $return_data .= '<td><input type="text" id="muatan_type" name="muatan_type" class="form-control myline" onkeyup="this.value = this.value.toUpperCase()"></td>';
        $return_data .= '<td style="text-align:center"><a href="javascript:;" class="btn btn-circle btn-xs green" onclick="saveKategori();">&nbsp; <i class="fa fa-floppy-o"></i> Simpan </a></td>';
        $return_data .= '</tr>';

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function save_kategori(){
        $m_muatan_id = $this->input->post('m_muatan_id');
        $muatan_type = $this->input->post('muatan_type');

        if($this->db->insert('m_muatan_type', array('m_muatan_id'=>$m_muatan_id, 'muatan_type'=>$muatan_type))){
            $return_data = "sukses";
        }else{
            $return_data = "gagal";
        }
        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function delete_kategori(){
        $id = $this->input->post('id');
        $this->db->where('id', $id);

        if($this->db->delete('m_muatan_type')){
            $return_data = "sukses";
        }else{
            $return_data = "gagal";
        }
        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
}