<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Otorisasi extends CI_Controller{
    function __construct(){
        parent::__construct();

        if($this->session->userdata('status') != "login"){
            redirect(base_url("index.php/Login"));
        }
    }
    
    function otorisasi_masuk(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Otorisasi/otorisasi_masuk";
        $data['content']= "otorisasi/otorisasi_masuk";
        $this->load->model('Model_t_otorisasi');
        $data['list_data'] = $this->Model_t_otorisasi->list_data_in()->result();
        
        $this->load->model('Model_m_agen');
        $data['agen_list'] = $this->Model_m_agen->list_data()->result();
        
        $this->load->model('Model_m_kendaraan');
        $data['kendaraan_list'] = $this->Model_m_kendaraan->list_data()->result();
        
        $this->load->model('Model_m_muatan');
        $data['muatan_list'] = $this->Model_m_muatan->list_data()->result();

        $this->load->view('layout', $data);
    }
    
    function add_masuk(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Otorisasi/otorisasi_masuk";
        $data['content']= "otorisasi/add_masuk";
        
        $this->load->model('Model_m_agen');
        $data['agen_list'] = $this->Model_m_agen->list_data()->result();
        
        $this->load->model('Model_m_kendaraan');
        $data['kendaraan_list'] = $this->Model_m_kendaraan->list_data()->result();
        
        $this->load->model('Model_m_muatan');
        $data['muatan_list'] = $this->Model_m_muatan->list_muatan()->result();
        
        $this->load->model('Model_m_type_kendaraan');
        $data['mtk_list'] = $this->Model_m_type_kendaraan->list_data()->result();

        $this->load->view('layout', $data);
    }
    
    function cek_kendaraan_masuk(){        
        $code = $this->input->post('data');
        $this->load->model('Model_t_otorisasi');
        $cek_data = $this->Model_t_otorisasi->cek_data_kendaraan_masuk($code)->row_array();
        $return_data = ($cek_data)? "ADA": "TIDAK ADA";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function save_masuk(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');       
        
        $this->db->trans_start();
        $data = array(
                        'm_agen_id'=> $this->input->post('m_agen_id'),
                        'm_kendaraan_id'=> $this->input->post('m_kendaraan_id'),
                        'supir'=> $this->input->post('supir'),
                        'jenis_transaksi'=> $this->input->post('jenis_transaksi'),
                        'm_muatan_id'=> $this->input->post('m_muatan_id'),
                        'deskripsi'=> $this->input->post('deskripsi'),
                        'time_in'=> $tanggal,
                        'status'=> 1,
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
       
        $this->db->insert('t_otorisasi', $data); 
        $id = $this->db->insert_id();
        if($this->input->post('jenis_transaksi')=="Jual"){
            $muatan = $this->input->post('mymuatan');
            foreach ($muatan as $index=>$value){
                if(empty($value['item'])){
                    unset($muatan[$index]);
                }
            }
            //Simpan data ke tabel otorisasi muatan
            if(!empty($muatan)){
                foreach ($muatan as $index=>$value){
                    $this->db->insert('t_otorisasi_muatan', array(
                        't_otorisasi_id'=>$id, 
                        'item'=>$value['item'],
                        'type_produk'=>$value['type'],
                        'sak'=>$value['sak'],
                        'jumlah'=>$value['jumlah'],
                    ));
                }
            }
        }
        if($this->db->trans_complete()){  
            redirect('index.php/Otorisasi/otorisasi_masuk');   
        }else{
            echo "Terjadi kesalahan saat menyimpan data!";
            echo "<pre>"; die(var_dump($this->input->post()));
        }
    }
    
    function save_agen(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                        'nama_agen'=> $this->input->post('nama_agen'),
                        'alamat'=> $this->input->post('alamat'),
                        'pic'=> $this->input->post('pic'),
                        'telepon'=> $this->input->post('telepon'),
                        'jenis_agen'=> $this->input->post('jenis_agen'),
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
       
        $this->db->insert('m_agen', $data); 
        redirect('index.php/Otorisasi/add_masuk');       
    }
    
    function save_kendaraan(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                        'no_kendaraan'=> $this->input->post('no_kendaraan'),
                        'm_type_kendaraan_id'=> $this->input->post('m_type_kendaraan_id'),
                        'keterangan'=> $this->input->post('keterangan'),
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
       
        $this->db->insert('m_kendaraan', $data); 
        redirect('index.php/Otorisasi/add_masuk');       
    }
    
    function delete(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('t_otorisasi');            
        }
        redirect('index.php/Otorisasi/otorisasi_masuk');
    }
    
    function edit_masuk(){
        $id = $this->uri->segment(3);
        if($id){        
            $module_name = $this->uri->segment(1);
            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;

            $data['judul']  = "Otorisasi/otorisasi_masuk";
            $data['content']= "otorisasi/edit_masuk";
            
            $this->load->model('Model_t_otorisasi');
            $data['mydata'] = $this->Model_t_otorisasi->show_data_masuk($id)->row_array();
            $data['myproduk'] = $this->Model_t_otorisasi->show_produk($id)->result();

            $this->load->model('Model_m_agen');
            $data['agen_list'] = $this->Model_m_agen->list_data()->result();
            

            $this->load->model('Model_m_kendaraan');
            $data['kendaraan_list'] = $this->Model_m_kendaraan->list_data()->result();

            $this->load->model('Model_m_muatan');
            $data['muatan_list'] = $this->Model_m_muatan->list_muatan()->result();

            $this->load->model('Model_m_type_kendaraan');
            $data['mtk_list'] = $this->Model_m_type_kendaraan->list_data()->result();

            $this->load->view('layout', $data);
        }else{
            redirect('index.php/Otorisasi/otorisasi_masuk');
        }
    }
    
    function update_masuk(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');

        $this->db->trans_start();
        
        $data = array(
                'm_agen_id'=> $this->input->post('m_agen_id'),
                'm_kendaraan_id'=> $this->input->post('m_kendaraan_id'),
                'supir'=> $this->input->post('supir'),
                'jenis_transaksi'=> $this->input->post('jenis_transaksi'),
                'm_muatan_id'=> $this->input->post('m_muatan_id'),
                'deskripsi'=> $this->input->post('deskripsi'),
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('t_otorisasi', $data);
        
        if($this->input->post('jenis_transaksi')=="Jual"){
            $muatan = $this->input->post('mymuatan');
            foreach ($muatan as $index=>$value){
                if(empty($value['item'])){
                    unset($muatan[$index]);
                }
            }
            //Simpan data ke tabel otorisasi muatan
            if(!empty($muatan)){
                foreach ($muatan as $index=>$value){
                    if(empty($value['id'])){
                        $this->db->insert('t_otorisasi_muatan', array(
                            't_otorisasi_id'=>$this->input->post('id'), 
                            'item'=>$value['item'],
                            'type_produk'=>$value['type'],
                            'sak'=>$value['sak'],
                            'jumlah'=>$value['jumlah'],
                        ));
                    }else{
                        $this->db->where('id', $value['id']);
                        $this->db->update('t_otorisasi_muatan', array(
                            'item'=>$value['item'],
                            'type_produk'=>$value['type'],
                            'sak'=>$value['sak'],
                            'jumlah'=>$value['jumlah'],
                        ));
                    }
                }
            }
        }
        
        if($this->db->trans_complete()){         
            redirect('index.php/Otorisasi/otorisasi_masuk');
        }else{
            echo "Terjadi kesalahan saat menyimpan data!<br>";
            echo "<pre>"; die(var_dump($this->input->post()));
        }
    }
    
    function otorisasi_keluar(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Otorisasi/otorisasi_keluar";
        $data['content']= "otorisasi/otorisasi_keluar";
        $this->load->model('Model_t_otorisasi');
        $data['list_data'] = $this->Model_t_otorisasi->list_data_out()->result();

        $this->load->view('layout', $data);
    }
    
    function save_keluar(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        foreach ($this->input->post('mydata') as $key=>$value){  
            if(isset($value['check'])&&($value['check']==1)){
                $this->db->where('id', $value['otorisasi_id']);
                $this->db->update('t_otorisasi', array(
                            'time_out'=>$tanggal, 
                            'status'=>9, 
                            'modified'=>$tanggal, 
                            'modified_by'=>$user_id));
            }
        }        
        
        redirect('index.php/Otorisasi/otorisasi_keluar');       
    }
    
    function get_type_agen(){
        $id = $this->input->post('id');
        $this->load->model('Model_m_agen');
        $data = $this->Model_m_agen->show_data($id)->row_array(); 
        
        header('Content-Type: application/json');
        echo json_encode($data);  
    }
    
    function list_otorisasi(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Otorisasi/list_otorisasi";
        $data['content']= "otorisasi/list_otorisasi";
        $this->load->model('Model_t_otorisasi');
        $data['list_data'] = $this->Model_t_otorisasi->list_dt_otorisasi()->result();
        
        $this->load->view('layout', $data);
    }
    
    function print_list_otorisasi(){
        require_once ("excel/PHPExcel.php");
        
        $file = new PHPExcel ();
	$file->getProperties ()->setCreator ("Taruna Aang");
	$file->getProperties ()->setLastModifiedBy ("Taruna Aang");
	$file->getProperties ()->setTitle ("List Kendaraan Keluar - Masuk ke Pabrik");
	$file->getProperties ()->setSubject ("Otorisasi Kendaraan");
	$file->getProperties ()->setDescription ("Otorisasi Kendaraan");
	$file->getProperties ()->setKeywords ("Otorisasi Kendaraan");
	$file->getProperties ()->setCategory ("Otorisasi Kendaraan");
        
        $file->createSheet (NULL,0);
	$file->setActiveSheetIndex (0);
	$sheet = $file->getActiveSheet(0);
	$sheet->setTitle ("Otorisasi Kendaraan");
        
        $sheet	->setCellValue ("A1", "NO")
		->setCellValue ("B1", "TANGGAL")
		->setCellValue ("C1", "AGEN")
		->setCellValue ("D1", "TYPE AGEN")
		->setCellValue ("E1", "NO POLISI")
                ->setCellValue ("F1", "NAMA SUPIR")
                ->setCellValue ("G1", "TRANSAKSI")
                ->setCellValue ("H1", "MUATAN");
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(30);
        
        $sheet->getStyle('A1:H1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));
        
        $this->load->model('Model_t_otorisasi');
        $data = $this->Model_t_otorisasi->list_dt_otorisasi()->result();
        $no = 1;
        foreach ($data as $index=>$value){
            $no++;
            $sheet  ->setCellValue ("A".$no, $no-1)
                    ->setCellValue ("B".$no, date('d-m-Y h:m:s', strtotime($value->time_in)))
                    ->setCellValue ("C".$no, $value->nama_agen)
                    ->setCellValue ("D".$no, $value->jenis_agen)
                    ->setCellValue ("E".$no, $value->no_kendaraan)
                    ->setCellValue ("F".$no, $value->supir)
                    ->setCellValue ("G".$no, $value->jenis_transaksi);
            if(!empty($value->nama_muatan)){
                $sheet  ->setCellValue ("H".$no, ($value->nama_muatan=="LAIN-LAIN")? $value->deskripsi: $value->nama_muatan);
            }else{
                $sheet  ->setCellValue ("H".$no, "Kendaraan Kosong");
            }            
        }
        
        header ('Content-Type: application/vnd.ms-excel');
	header ('Content-Disposition: attachment;filename="List-Otorisasi-Kendaraan.xls"'); 
	header ('Cache-Control: max-age=0');
	$writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
	$writer->save ('php://output');
    }
}