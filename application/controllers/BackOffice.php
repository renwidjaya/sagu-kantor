<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BackOffice extends CI_Controller{
    function __construct(){
        parent::__construct();

        if($this->session->userdata('status') != "login"){
            redirect(base_url("index.php/Login"));
        }
    }
    #================================ List CV ==================================
    function list_cv(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "BackOffice/list_cv";
        $data['content']= "back_office/list_cv";
        $this->load->model('Model_back_office');
        $data['list_data'] = $this->Model_back_office->list_cv()->result();

        $this->load->view('layout', $data);
    }
    
    function cek_cv(){
        $code = $this->input->post('data');
        $this->load->model('Model_back_office');
        $cek_data = $this->Model_back_office->cek_data_cv($code)->row_array();
        $return_data = ($cek_data)? "ADA": "TIDAK ADA";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function save_cv(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $limit = str_replace(".", "", $this->input->post('limit_penjualan'));
        
        $data = array(
                        'kode_cv'=> $this->input->post('kode_cv'),
                        'nama_cv'=> $this->input->post('nama_cv'),
                        'limit_penjualan'=> $limit,
                        'sisa_limit'=> $limit,
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
       
        $this->db->insert('m_cv', $data); 
        redirect('index.php/BackOffice/list_cv');       
    }
    
    function delete_cv(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('m_cv');            
        }
        redirect('index.php/BackOffice/list_cv');
    }
    
    function edit_cv(){
        $id = $this->input->post('id');
        $this->load->model('Model_back_office');
        $data = $this->Model_back_office->show_data_cv($id)->row_array(); 
        $data['limit_penjualan']= number_format($data['limit_penjualan'],0,',','.');
        
        header('Content-Type: application/json');
        echo json_encode($data);       
    }
    
    function update_cv(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $limit = str_replace(".", "", $this->input->post('limit_penjualan')); 
        $total_penjualan = $this->input->post('total_penjualan');        
        $sisa_limit = $limit - $total_penjualan;
        
        $data = array(
                'kode_cv'=> $this->input->post('kode_cv'),
                'nama_cv'=> $this->input->post('nama_cv'),
                'limit_penjualan'=>$limit,
                'sisa_limit'=>$sisa_limit,
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('m_cv', $data);
        
        redirect('index.php/BackOffice/list_cv');
    }
    
    #================================ Register Customer ==================================
    function register_customer(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "BackOffice/register_customer";
        $data['content']= "back_office/register_customer";
        $this->load->model('Model_back_office');
        $data['list_data'] = $this->Model_back_office->list_data_customer()->result();
        $data['list_customer'] = $this->Model_back_office->list_customer()->result();
        
        $data['list_provinsi'] = $this->Model_back_office->list_provinsi()->result();
        $data['list_city'] = $this->Model_back_office->list_kota(1)->result();

        $this->load->view('layout', $data);
    }
    
    function get_city_list(){ 
        $id = $this->input->post('id');
        $this->load->model('Model_back_office');
        $cities = $this->Model_back_office->list_kota($id)->result(); 
        $arr_city = array();
        foreach ($cities as $row) {
            $arr_city[$row->id] = $row->city_name;
        } 
        print form_dropdown('m_city_id', $arr_city);
    }
    
    function cek_customer(){
        $code = $this->input->post('data');
        $this->load->model('Model_back_office');
        $cek_data = $this->Model_back_office->cek_data_customer($code)->row_array();
        $return_data = ($cek_data)? "ADA": "TIDAK ADA";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function save_customer(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                        'nama_customer'=> $this->input->post('nama_customer'),
                        'm_customer_id'=> $this->input->post('m_customer_id'),
                        'pic'=> $this->input->post('pic'),
                        'telepon'=> $this->input->post('telepon'),
                        'hp'=> $this->input->post('hp'),
                        'alamat'=> $this->input->post('alamat'),
                        'm_province_id'=> $this->input->post('m_province_id'),
                        'm_city_id'=> $this->input->post('m_city_id'),
                        'kode_pos'=> $this->input->post('kode_pos'),
                        'keterangan'=> $this->input->post('keterangan'),
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
       
        $this->db->insert('m_customers', $data); 
        redirect('index.php/BackOffice/register_customer');       
    }
    
    function delete_customer(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('m_customers');            
        }
        redirect('index.php/BackOffice/register_customer');
    }
    
    function edit_customer(){
        $id = $this->input->post('id');
        $this->load->model('Model_back_office');
        $data = $this->Model_back_office->show_data_customer($id)->row_array(); 
        
        header('Content-Type: application/json');
        echo json_encode($data);       
    }
    
    function update_customer(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                'nama_customer'=> $this->input->post('nama_customer'),
                'm_customer_id'=> $this->input->post('m_customer_id'),
                'pic'=> $this->input->post('pic'),
                'telepon'=> $this->input->post('telepon'),
                'hp'=> $this->input->post('hp'),
                'alamat'=> $this->input->post('alamat'),
                'm_province_id'=> $this->input->post('m_province_id'),
                'm_city_id'=> $this->input->post('m_city_id'),
                'kode_pos'=> $this->input->post('kode_pos'),
                'keterangan'=> $this->input->post('keterangan'),
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('m_customers', $data);
        
        redirect('index.php/BackOffice/register_customer');
    }
    
    #sales order ===============================================================
    function sales_order(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "BackOffice/sales_order";
        $data['content']= "sales_order/index";
        $this->load->model('Model_back_office');
        $data['list_data'] = $this->Model_back_office->list_data_so()->result();

        $this->load->view('layout', $data);
    }
    
    function add_sales_order(){                
        $data['judul']  = "BackOffice/sales_order";
        $data['content']= "sales_order/add";
        
        $this->load->model('Model_back_office');
        $data['list_customer'] = $this->Model_back_office->list_customer()->result();
        $data['list_cv']       = $this->Model_back_office->list_cv()->result();

        $this->load->view('layout', $data);
    }
    
    function save_sales_order(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $input_tgl = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $this->load->model('Model_m_numberings');
        $code = $this->Model_m_numberings->getNumbering('SO', $input_tgl); 
        
        if($code){
            $data = array(
                        'tanggal'=> $input_tgl,
                        'm_customer_id'=> $this->input->post('m_customer_id'),
                        'no_sales_order'=> $code,
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id
                    );
            $this->db->insert('t_sales_order', $data); 
            $id = $this->db->insert_id();
            redirect('index.php/BackOffice/edit_sales_order/'.$id);
        }else{
            echo "<pre>"; die("Gagal menyimpan data! Anda belum melakukan setup untuk penomoran sales order.");
        }
    }
    
    function delete_sales_order(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('t_sales_order');     
            
            $this->db->where('t_sales_order_id', $id);
            $this->db->delete('t_sales_order_detail'); 
        }
        redirect('index.php/BackOffice/sales_order');
    }
    
    function edit_sales_order(){
        $id = $this->uri->segment(3);
        if($id){
            $this->load->model('Model_back_office');
            $data['mydata'] = $this->Model_back_office->show_data_so($id)->row_array(); 
            $data['mydetails'] = $this->Model_back_office->show_detail_so($id)->result(); 

            $data['list_customer'] = $this->Model_back_office->list_customer()->result();
            $data['list_cv']       = $this->Model_back_office->list_cv()->result();

            $data['judul']  = "BackOffice/sales_order";
            $data['content']= "sales_order/edit";

            $this->load->view('layout', $data); 
        }else{
            redirect('index.php/BackOffice/sales_order');
        }         
    }
    
    function update_sales_order(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $input_tgl = date('Y-m-d', strtotime($this->input->post('tanggal')));
        
        $data = array(
                    'tanggal'=> $input_tgl,
                    'm_customer_id'=> $this->input->post('m_customer_id'),
                    'nilai_order'=>str_replace(".", "", $this->input->post('nilai_order')),
                    'modified'=> $tanggal,
                    'modified_by'=> $user_id
                );
        $this->db->where('id', $this->input->post('header_id'));        
        $this->db->update('t_sales_order', $data); 

        redirect('index.php/BackOffice/sales_order');        
    }
    
    function save_produk(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                    't_sales_order_id'=> $this->input->post('t_sales_order_id'),                        
                    'merek'=> $this->input->post('merek'),
                    'jumlah_sak'=> str_replace(".", "", $this->input->post('jumlah_sak')),
                    'harga'=> str_replace(".", "", $this->input->post('harga')),
                    'catatan'=> $this->input->post('catatan'),                    
                    'created'=> $tanggal,
                    'created_by'=> $user_id,
                    'modified'=> $tanggal,
                    'modified_by'=> $user_id,
                );  
        $this->db->trans_start();
        $this->db->insert('t_sales_order_detail', $data);
        
        $this->load->model('Model_back_office');
        $sum_order   = $this->Model_back_office->sum_nilai_order($this->input->post('t_sales_order_id'))->row_array();
        $nilai_order = $sum_order['nilai_order'];
        
        $this->db->where('id', $this->input->post('t_sales_order_id'));
        $this->db->update('t_sales_order', array('nilai_order'=>$nilai_order));
        
        if($this->db->trans_complete()){            
            redirect('index.php/BackOffice/edit_sales_order/'.$this->input->post('t_sales_order_id'));
        }else{
            echo "Terjadi kesalahan saat menyimpan data item produk..";
            echo "<pre>"; die(var_dump($data));
        }
    }
    
    function edit_produk(){        
        $id = $this->input->post('id');
        $this->load->model('Model_back_office');
        $data = $this->Model_back_office->get_detail_so($id)->row_array();
        $data['jumlah_sak']= number_format($data['jumlah_sak'],0,',','.');
        $data['harga']= number_format($data['harga'],0,',','.');
        
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    function update_produk(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                    'merek'=> $this->input->post('merek'),
                    'jumlah_sak'=> str_replace(".", "", $this->input->post('jumlah_sak')),
                    'harga'=> str_replace(".", "", $this->input->post('harga')),
                    'catatan'=> $this->input->post('catatan'),  
                    'modified'=> $tanggal,
                    'modified_by'=> $user_id,
                );
        
        $this->db->trans_start();
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('t_sales_order_detail', $data);
        
        $this->load->model('Model_back_office');
        $sum_order   = $this->Model_back_office->sum_nilai_order($this->input->post('t_sales_order_id'))->row_array();
        $nilai_order = $sum_order['nilai_order'];
        
        $this->db->where('id', $this->input->post('t_sales_order_id'));
        $this->db->update('t_sales_order', array('nilai_order'=>$nilai_order));
        
        if($this->db->trans_complete()){
            redirect('index.php/BackOffice/edit_sales_order/'.$this->input->post('t_sales_order_id'));
        }else{
            echo "Terjadi kesalahan saat menyimpan data item produk..";
            echo "<pre>"; die(var_dump($data));
        }
    }
    
    function delete_produk(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->load->model('Model_back_office');
            $header = $this->Model_back_office->get_detail_so($id)->row_array(); 
            $header_id = $header['t_sales_order_id'];

            $this->db->where('id', $id);
            $this->db->delete('t_sales_order_detail');  
            redirect('index.php/BackOffice/edit_sales_order/'.$header_id);
        }
        redirect('index.php/BackOffice/sales_order');
    }
    
    #delivery order ===============================================================
    function delivery_order(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "BackOffice/delivery_order";
        $data['content']= "delivery_order/index";
        $this->load->model('Model_back_office');
        $data['list_data'] = $this->Model_back_office->list_data_do()->result();

        $this->load->view('layout', $data);
    }
    
    function add_delivery_order(){                
        $data['judul']  = "BackOffice/delivery_order";
        $data['content']= "delivery_order/add";
        
        $this->load->model('Model_back_office');
        $data['list_customer'] = $this->Model_back_office->list_customer()->result();
        
        $data['list_so'] = $this->Model_back_office->list_so(1)->result();
        $data['list_ekspedisi'] = $this->Model_back_office->list_data_ekspedisi()->result();
        $data['list_cv'] = $this->Model_back_office->list_cv()->result();

        $this->load->view('layout', $data);
    }
    
    function get_so_list(){ 
        $id = $this->input->post('id');
        $this->load->model('Model_back_office');
        $ls = $this->Model_back_office->list_so($id)->result(); 
        foreach ($ls as $row) {
            $arr_so[$row->id] = $row->no_sales_order.' -- '.$row->tanggal;
        } 
        print form_dropdown('t_sales_order_id', $arr_so, 'large', array('id'=>'t_sales_order_id'));
    }
    
    function save_delivery_order(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $input_tgl = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $this->load->model('Model_m_numberings');
        $code = $this->Model_m_numberings->getNumbering('DO', $input_tgl); 
        
        if($code){
            $data = array(
                        'tanggal'=> $input_tgl,
                        'no_delivery_order'=> $code,
                        'm_customer_id'=> $this->input->post('m_customer_id'),
                        't_sales_order_id'=> $this->input->post('t_sales_order_id'),
                        'm_cv_id'=> $this->input->post('m_cv_id'),                        
                        'm_ekspedisi_id'=> $this->input->post('m_ekspedisi_id'),
                        'catatan'=> $this->input->post('catatan'),
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id
                    );
            $this->db->insert('t_delivery_order', $data); 
            $id = $this->db->insert_id();
            redirect('index.php/BackOffice/edit_delivery_order/'.$id);
        }else{
            echo "<pre>"; die("Gagal menyimpan data! Anda belum melakukan setup untuk penomoran delivery order.");
        }
    }
    
    function set_harga(){
        $id = $this->uri->segment(3);
        if($id){
            $this->load->model('Model_back_office');
            $data['mydata'] = $this->Model_back_office->show_data_do($id)->row_array();             
            $data['mydetails'] = $this->Model_back_office->show_detail_do($id)->result(); 
            
            $data['list_so'] = $this->Model_back_office->list_so($data['mydata']['m_customer_id'])->result();
            #echo "<pre>"; die(var_dump($data['list_so']));
            $data['judul']  = "BackOffice/delivery_order";
            $data['content']= "delivery_order/edit";

            $this->load->view('layout', $data); 
        }else{
            redirect('index.php/BackOffice/delivery_order');
        }         
    }
    
    function update_delivery_order(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $myDetail = $this->input->post('myDetail');
        $this->db->trans_start();

        $this->db->where('id', $this->input->post('id'));        
        $this->db->update('t_delivery_order', array(
            't_sales_order_id'=> $this->input->post('t_sales_order_id'),
            'flag_set_harga'=>1,
            'modified'=> $tanggal,
            'modified_by'=> $user_id
        )); 
        
        foreach ($myDetail as $value){
            $this->db->where('id', $value['id']); 
            $this->db->update('t_delivery_order_detail', array(
                'harga'=>str_replace('.','',$value['harga']),
                'total_harga'=>str_replace('.','',$value['total_harga'])
            ));
        }
        
        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Data harga berhasil disimpan');
            redirect('index.php/BackOffice/delivery_order');  
        }else{
            echo "Terjadi kesalahan saat menyimpan data item produk..";
            echo "<pre>"; die(var_dump($data));
        }
    }
    
    function delete_delivery_order(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('t_delivery_order');     
            
            $this->db->where('t_delivery_order_id', $id);
            $this->db->delete('t_delivery_order_detail'); 
        }
        redirect('index.php/BackOffice/delivery_order');
    }
    
    function cetak_delivery_order(){
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_back_office');
            $header = $this->Model_back_office->show_data_do($id)->row_array(); 
            $detail = $this->Model_back_office->show_detail_do($id)->result(); 

            require('fpdf/fpdf.php');
            
            $pdf = new FPDF();
            $pdf->AliasNbPages();
            $pdf->AddPage();
            
            $pdf->SetFont('times','B',13);
            $pdf->Cell(105,8, 'DELIVERY ORDER');
            $pdf->SetFont('times','B',8);
            $pdf->Cell(20,4,'Delivery No');
            $pdf->Cell(65,4,': '.$header['no_delivery_order']);
            $pdf->Ln(4);
            $pdf->SetFont('times','',8);
            $pdf->Cell(105);
            $pdf->Cell(20,4,'Delivery Date');
            $pdf->Cell(65,4,': '.date('d-m-Y', strtotime($header['tanggal'])));
            $pdf->Ln(4);
            
            $pdf->Cell(105);
            $pdf->Cell(20,4,'Ekspedisi');
            $pdf->Cell(65,4,': '.$header['nama_ekspedisi']);
            $pdf->Ln(4);
            
            $pdf->Cell(105,4,'PT. UNGGUL MEKAR SARI');
            $pdf->Cell(20,4,'Bill/Ship To');
            $pdf->Cell(65,4,': '.$header['nama_customer']);
            $pdf->Ln(4);
            
            $pdf->Cell(105,4,'DESA BINA KARYA II');
            $pdf->Cell(20,4,'Address');
            $pdf->Cell(65,4,': '.$header['alamat']);
            $pdf->Ln(4);
            
            $pdf->Cell(105,4,'KEC. RUMBIA');
            $pdf->Cell(20,4,'');
            $pdf->Cell(65,4,'');
            $pdf->Ln(4);

            $pdf->Cell(105,4,'LAMPUNG TENGAH');
            $pdf->Cell(20,4,'Phone');
            $pdf->Cell(65,4,': '.$header['telepon']);
            $pdf->Ln(4);
            
            $pdf->Cell(105);
            $pdf->Cell(20,4,'PIC');
            $pdf->Cell(65,4,': '.$header['pic']);
            $pdf->Ln(8);
            
            $pdf->SetFont('times','B',8);
            $pdf->Cell(10,4,'No','LBTR',0,'C');
            $pdf->Cell(60,4,'Item','BTR',0,'C');
            $pdf->Cell(10,4,'Sak','BTR',0,'C');
            $pdf->Cell(50,4,'Price (Rp)','BTR',0,'C');
            $pdf->Cell(10,4,'Qty','BTR',0,'C');
            $pdf->Cell(50,4,'Total Price (Rp)','BTR',0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('times','',8);
            
            $no=0;
            foreach ($detail as $key=>$value){
                $no++;
                $pdf->Cell(10,4,$no,'LR',0,'C');
                $pdf->Cell(60,4,$value->merek,'R',0,'L');
                $pdf->Cell(10,4,$value->sak,'R',0,'C');
                $pdf->Cell(50,4,number_format($value->harga,0,',','.'),'R',0,'R');
                $pdf->Cell(10,4,number_format($value->jumlah_sak,0,',','.'),'R',0,'C');
                $pdf->Cell(50,4,number_format($value->total_harga,0,',','.'),'R',0,'R');
                $pdf->Ln(4);
            }
            $pdf->Cell(10,10,'','LBR');
            $pdf->Cell(60,10,'','BR');
            $pdf->Cell(10,10,'','BR');
            $pdf->Cell(50,10,'','BR');
            $pdf->Cell(10,10,'','BR');
            $pdf->Cell(50,10,'','BR');
            $pdf->Ln(10);
            
            $pdf->Cell(140,4,'Total Order (Rp) : ','LBR',0,'R');
            $pdf->Cell(50,4,number_format($header['total_order'],0,',','.'),'BR',0,'R');
            $pdf->Ln(10);
            
            $pdf->Cell(100,4);
            $pdf->Cell(90,4,'Remarks');
            $pdf->Ln(4);
            
            $pdf->Cell(35,4,'Prepared By');
            $pdf->Cell(35,4,'Approved By');
            $pdf->Cell(30,4,'Received By');
            $pdf->Cell(90,4,'','LTR');
            $pdf->Ln(4);
            
            $pdf->Cell(100,12);
            $pdf->Cell(90,12,'','LR');
            $pdf->Ln(12);
            
            $pdf->Cell(35,4,'-----------------');
            $pdf->Cell(35,4,'-----------------');
            $pdf->Cell(30,4,'-----------------');
            $pdf->Cell(90,4,'','LBR');
            $pdf->Ln(4);
            
            $pdf->Output('delivery_order_'.$header['no_delivery_order'].'.pdf', 'D');
                     
        }else{
            redirect('index.php/BackOffice/delivery_order'); 
        }
    }
    
    function print_do(){
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_back_office');
            $header = $this->Model_back_office->show_data_do($id)->row_array(); 
            $detail = $this->Model_back_office->show_detail_do($id)->result(); 

            require('fpdf/fpdf.php');
            
            $pdf = new FPDF();
            $pdf->AliasNbPages();
            $pdf->AddPage();
            
            $pdf->SetFont('times','B',13);
            $pdf->Cell(105,8, 'DELIVERY ORDER');
            $pdf->SetFont('times','B',8);
            $pdf->Cell(20,4,'Delivery No');
            $pdf->Cell(65,4,': '.$header['no_delivery_order']);
            $pdf->Ln(4);
            $pdf->SetFont('times','',8);
            $pdf->Cell(105);
            $pdf->Cell(20,4,'Delivery Date');
            $pdf->Cell(65,4,': '.date('d-m-Y', strtotime($header['tanggal'])));
            $pdf->Ln(4);            
            
            $pdf->Cell(105,4,''); //PT. UNGGUL MEKAR SARI
            $pdf->Cell(20,4,'Bill/Ship To');
            $pdf->Cell(65,4,': '.$header['nama_customer']);
            $pdf->Ln(4);
            
            $pdf->Cell(105,4,''); //DESA BINA KARYA II
            $pdf->Cell(20,4,'Address');
            $pdf->Cell(65,4,': '.$header['alamat']);
            $pdf->Ln(4);
            
            $pdf->Cell(105,4,''); //KEC. RUMBIA
            $pdf->Cell(20,4,'');
            $pdf->Cell(65,4,'');
            $pdf->Ln(4);

            $pdf->Cell(105,4,''); //LAMPUNG TENGAH
            $pdf->Cell(20,4,'Phone');
            $pdf->Cell(65,4,': '.$header['telepon']);
            $pdf->Ln(4);
            
            $pdf->Cell(105);
            $pdf->Cell(20,4,'PIC');
            $pdf->Cell(65,4,': '.$header['pic']);
            $pdf->Ln(4);
            
            $pdf->Cell(105);
            $pdf->Cell(20,4,'Delivery By');
            $pdf->Cell(65,4,': '.$header['nama_ekspedisi']);
            $pdf->Ln(8);
            
            $pdf->SetFont('times','B',8);
            $pdf->Cell(10,4,'No','LBTR',0,'C');
            $pdf->Cell(60,4,'Item','BTR',0,'C');
            $pdf->Cell(40,4,'Sak','BTR',0,'C');
            $pdf->Cell(30,4,'Qty','BTR',0,'C');
            $pdf->Cell(50,4,'Sak x Qty','BTR',0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('times','',8);
            
            $no=0;
            $total = 0;
            foreach ($detail as $key=>$value){
                $no++;
                $pdf->Cell(10,4,$no,'LR',0,'C');
                $pdf->Cell(60,4,$value->merek,'R',0,'L');
                $pdf->Cell(40,4,$value->sak.' Kg','R',0,'C');
                $pdf->Cell(30,4,number_format($value->jumlah_sak,0,',','.'),'R',0,'C');
                $sub_total = $value->sak * $value->jumlah_sak;
                $total += $sub_total;
                $pdf->Cell(50,4,number_format($sub_total,0,',','.').' Kg','R',0,'R');
                $pdf->Ln(4);
            }
            $pdf->Cell(10,10,'','LBR');
            $pdf->Cell(60,10,'','BR');
            $pdf->Cell(40,10,'','BR');
            $pdf->Cell(30,10,'','BR');
            $pdf->Cell(50,10,'','BR');
            $pdf->Ln(10);
            
            $pdf->Cell(140,4,'Total Order : ','LBR',0,'R');
            $pdf->Cell(50,4,number_format($total,0,',','.').' Kg','BR',0,'R');
            
            $pdf->Ln(4);
            
            $getDataTimbang = $this->Model_back_office->get_nilai_timbangan($id)->row_array(); 
            $berat1 = number_format($getDataTimbang['berat1'],0,',','.');
            $berat2 = number_format($getDataTimbang['berat2'],0,',','.');
            $berat_sagu = $getDataTimbang['berat2'] - $getDataTimbang['berat1'];
            $pdf->SetFont('times','I',8);
            $pdf->Cell(140,4,'Berat timbangan : '.number_format($berat_sagu,0,',','.').' Kg ('.$berat2.' - '.$berat1.')');
            
            $pdf->SetFont('times','B',8);
            $pdf->Ln(10);
            
            $pdf->Cell(100,4);
            $pdf->Cell(90,4,'Remarks');
            $pdf->Ln(4);
            
            $pdf->Cell(35,4,'Prepared By');
            $pdf->Cell(35,4,'Approved By');
            $pdf->Cell(30,4,'Received By');
            $pdf->Cell(90,4,'','LTR');
            $pdf->Ln(4);
            
            $pdf->Cell(100,12);
            $pdf->Cell(90,12,'','LR');
            $pdf->Ln(12);
            
            $pdf->Cell(35,4,'-----------------');
            $pdf->Cell(35,4,'-----------------');
            $pdf->Cell(30,4,'-----------------');
            $pdf->Cell(90,4,'','LBR');
            $pdf->Ln(4);
            
            $pdf->Output('delivery_order_'.$header['no_delivery_order'].'.pdf', 'D');
            #$pdf->Output();         
        }else{
            redirect('index.php/BackOffice/delivery_order'); 
        }
    }
    
    function print_do_onggok(){
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_back_office');
            $header = $this->Model_back_office->show_data_do($id)->row_array(); 
            $detail = $this->Model_back_office->show_detail_do($id)->result(); 

            require('fpdf/fpdf.php');
            
            $pdf = new FPDF();
            $pdf->AliasNbPages();
            $pdf->AddPage();
            
            $pdf->SetFont('times','B',13);
            $pdf->Cell(105,8, 'DELIVERY ORDER');
            $pdf->SetFont('times','B',8);
            $pdf->Cell(20,4,'Delivery No');
            $pdf->Cell(65,4,': '.$header['no_delivery_order']);
            $pdf->Ln(4);
            $pdf->SetFont('times','',8);
            $pdf->Cell(105);
            $pdf->Cell(20,4,'Delivery Date');
            $pdf->Cell(65,4,': '.date('d-m-Y', strtotime($header['tanggal'])));
            $pdf->Ln(4);            
            
            $pdf->Cell(105,4,''); //PT. UNGGUL MEKAR SARI
            $pdf->Cell(20,4,'Bill/Ship To');
            $pdf->Cell(65,4,': '.$header['nama_customer']);
            $pdf->Ln(4);
            
            $pdf->Cell(105,4,''); //DESA BINA KARYA II
            $pdf->Cell(20,4,'Address');
            $pdf->Cell(65,4,': '.$header['alamat']);
            $pdf->Ln(4);
            
            $pdf->Cell(105,4,''); //KEC. RUMBIA
            $pdf->Cell(20,4,'');
            $pdf->Cell(65,4,'');
            $pdf->Ln(4);

            $pdf->Cell(105,4,''); //LAMPUNG TENGAH
            $pdf->Cell(20,4,'Phone');
            $pdf->Cell(65,4,': '.$header['telepon']);
            $pdf->Ln(4);
            
            $pdf->Cell(105);
            $pdf->Cell(20,4,'PIC');
            $pdf->Cell(65,4,': '.$header['pic']);
            $pdf->Ln(4);
            
            $pdf->Cell(105);
            $pdf->Cell(20,4,'Delivery By');
            $pdf->Cell(65,4,': '.$header['nama_ekspedisi']);
            $pdf->Ln(8);
            
            $pdf->SetFont('times','B',8);
            $pdf->Cell(10,4,'No','LBTR',0,'C');
            $pdf->Cell(60,4,'Item','BTR',0,'C');
            $pdf->Cell(40,4,'Harga per Kg (Rp)','BTR',0,'C');
            $pdf->Cell(30,4,'Total Berat (Kg)','BTR',0,'C');
            $pdf->Cell(50,4,'Total Harga (Rp)','BTR',0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('times','',8);
            
            $no=0;
            $total_berat = 0;
            $total_harga = 0;
            foreach ($detail as $key=>$value){
                $no++;
                $pdf->Cell(10,4,$no,'LR',0,'C');
                $pdf->Cell(60,4,$value->merek,'R',0,'L');
                $pdf->Cell(40,4,number_format($value->harga,0,',','.'),'R',0,'R');
                $pdf->Cell(30,4,number_format($value->total_berat,0,',','.'),'R',0,'R');                
                $pdf->Cell(50,4,number_format($value->total_harga,0,',','.'),'R',0,'R');
                $pdf->Ln(4);
                
                $total_berat += $value->total_berat;
                $total_harga += $value->total_harga;
            }
            $pdf->Cell(10,10,'','LBR');
            $pdf->Cell(60,10,'','BR');
            $pdf->Cell(40,10,'','BR');
            $pdf->Cell(30,10,'','BR');
            $pdf->Cell(50,10,'','BR');
            $pdf->Ln(10);
            
            $pdf->Cell(110,4,'Total: ','LBR',0,'R');
            $pdf->Cell(30,4,number_format($total_berat,0,',','.'),'LBR',0,'R');
            $pdf->Cell(50,4,number_format($total_harga,0,',','.'),'BR',0,'R');
            $pdf->Ln(10);
            
            $pdf->Cell(100,4);
            $pdf->Cell(90,4,'Remarks');
            $pdf->Ln(4);
            
            $pdf->Cell(35,4,'Prepared By');
            $pdf->Cell(35,4,'Approved By');
            $pdf->Cell(30,4,'Received By');
            $pdf->Cell(90,4,'','LTR');
            $pdf->Ln(4);
            
            $pdf->Cell(100,12);
            $pdf->Cell(90,12,'','LR');
            $pdf->Ln(12);
            
            $pdf->Cell(35,4,'-----------------');
            $pdf->Cell(35,4,'-----------------');
            $pdf->Cell(30,4,'-----------------');
            $pdf->Cell(90,4,'','LBR');
            $pdf->Ln(4);
            
            $pdf->Output('delivery_order_'.$header['no_delivery_order'].'.pdf', 'D');
            #$pdf->Output();         
        }else{
            redirect('index.php/BackOffice/delivery_order'); 
        }
    }
    
    function pecah_do(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "BackOffice/pecah_do";
        $data['content']= "delivery_order/pecah_do";
        $this->load->model('Model_back_office');
        $data['list_data'] = $this->Model_back_office->list_do_pabrik()->result();

        $this->load->view('layout', $data);
    }
    
    function new_pecah_do(){
        $id = $this->uri->segment(3);
        if($id){
            $this->load->model('Model_back_office');
            $data['mydata'] = $this->Model_back_office->show_data_do($id)->row_array(); 
            $data['mydetails'] = $this->Model_back_office->show_detail_do($id)->result(); 
            #$data['list_ekspedisi'] = $this->Model_back_office->list_data_ekspedisi()->result();
            
            $data['list_cv'] = $this->Model_back_office->list_cv()->result();

            if (!empty($this->input->post('id'))){  
                $mylist = array();
                $this->load->model('Model_back_office');
                $produks = $this->Model_back_office->show_detail_do($id)->result();

                foreach ($produks as $index=>$value){
                    #Periksa stok ke tabel inventory
                    $berat = $value->sak * $value->jumlah_sak;
                    $cek_stok = $this->Model_back_office->cek_stok('SAGU '.$value->merek, $value->sak, $berat)->result();
                    if($cek_stok){
                        #Ada stok yang sesuai kriteria
                        $mylist[$index]['merek']      = $value->merek;
                        $mylist[$index]['sak']        = $value->sak;
                        $mylist[$index]['harga']      = $value->harga;
                        $mylist[$index]['jumlah_sak'] = $value->jumlah_sak;
                        $mylist[$index]['total_berat']= $value->sak * $value->jumlah_sak;
                        $mylist[$index]['total_harga']= $value->total_harga;
                        $mylist[$index]['id']= $value->id;

                        foreach ($cek_stok as $key=>$val){
                            $mylist[$index]['list_simulasi'][$key]['m_cv_id'] = $val->m_cv_id;
                            $mylist[$index]['list_simulasi'][$key]['nama_cv'] = $val->nama_cv;
                            $mylist[$index]['list_simulasi'][$key]['kode_cv'] = $val->kode_cv;
                            $mylist[$index]['list_simulasi'][$key]['merek'] = $value->merek;
                            $mylist[$index]['list_simulasi'][$key]['sak']   = $value->sak;
                            $mylist[$index]['list_simulasi'][$key]['harga'] = $value->harga;
                            $mylist[$index]['list_simulasi'][$key]['jumlah_sak']  = $value->jumlah_sak;
                            $mylist[$index]['list_simulasi'][$key]['total_berat'] = $value->sak * $value->jumlah_sak;
                            $mylist[$index]['list_simulasi'][$key]['total_harga'] = $value->total_harga;
                            $mylist[$index]['list_simulasi'][$key]['sisa_limit']  = $val->sisa_limit;
                            $mylist[$index]['list_simulasi'][$key]['stok']  = $val->stok;
                            #$mylist[$index]['list_simulasi'][$key]['m_ekspedisi_id'] = $data['mydata']['m_ekspedisi_id'];
                        }
                    }else{
                        #Cek stok yang lebih kecil
                        $cek_ulang_stok = $this->Model_back_office->cek_ulang_stok('SAGU '.$value->merek, $value->sak, $berat)->result();
                        if($cek_ulang_stok){
                            $mylist[$index]['merek']      = $value->merek;
                            $mylist[$index]['sak']        = $value->sak;
                            $mylist[$index]['harga']      = $value->harga;
                            $mylist[$index]['jumlah_sak'] = $value->jumlah_sak;
                            $mylist[$index]['total_berat']= $value->sak * $value->jumlah_sak;
                            $mylist[$index]['total_harga']= $value->total_harga;
                            $mylist[$index]['id']= $value->id;
                            
                            foreach ($cek_ulang_stok as $key=>$val){
                                $mylist[$index]['list_simulasi'][$key]['m_cv_id'] = $val->m_cv_id;
                                $mylist[$index]['list_simulasi'][$key]['nama_cv'] = $val->nama_cv;
                                $mylist[$index]['list_simulasi'][$key]['kode_cv'] = $val->kode_cv;
                                $mylist[$index]['list_simulasi'][$key]['merek'] = $value->merek;
                                $mylist[$index]['list_simulasi'][$key]['sak']   = $value->sak;
                                $mylist[$index]['list_simulasi'][$key]['harga'] = $value->harga;
                                $mylist[$index]['list_simulasi'][$key]['jumlah_sak']  = floor($val->stok/ $value->sak);
                                $mylist[$index]['list_simulasi'][$key]['total_berat'] = $val->stok;
                                $mylist[$index]['list_simulasi'][$key]['total_harga'] = $value->harga * $mylist[$index]['list_simulasi'][$key]['jumlah_sak'];
                                $mylist[$index]['list_simulasi'][$key]['sisa_limit']  = $val->sisa_limit;
                                $mylist[$index]['list_simulasi'][$key]['stok']  = $val->stok;
                                #$mylist[$index]['list_simulasi'][$key]['m_ekspedisi_id'] = $data['mydata']['m_ekspedisi_id'];
                            }
                        }else{
                            #Tidak ada stok sama sekali
                            $mylist[$index]['merek']      = $value->merek;
                            $mylist[$index]['sak']        = $value->sak;
                            $mylist[$index]['harga']      = $value->harga;
                            $mylist[$index]['jumlah_sak'] = $value->jumlah_sak;
                            $mylist[$index]['total_berat']= $value->sak * $value->jumlah_sak;
                            $mylist[$index]['total_harga']= $value->total_harga;
                            $mylist[$index]['id']= $value->id;
                            
                            $mylist[$index]['list_simulasi'] = "";
                        }
                    }
                }
                $data['simulasi'] = $mylist; 
            }

            $data['judul']  = "BackOffice/pecah_do";
            $data['content']= "delivery_order/new_pecah_do";

            $this->load->view('layout', $data); 
        }else{
            redirect('index.php/BackOffice/pecah_do');
        }         
    }    
    
    function save_pecah_do(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $id       = $this->input->post('id');
        $input_tgl= date('Y-m-d');
        
        $this->load->model('Model_m_numberings');
        $this->load->model('Model_t_oven');
        $this->load->model('Model_back_office');
        
        $ekspedisi_id    = $this->input->post('m_ekspedisi_id');
        $customer_id     = $this->input->post('m_customer_id');
        $getBeratEksp    = $this->Model_back_office->getBeratEksp($id)->row_array();
        
        $berat_ekspedisi = $getBeratEksp['total_berat'];
        
        $mydata = $this->input->post('mydata');        
        $hasil_pecah = array();       
        
        foreach ($mydata as $index=>$value){
            foreach ($value['simulasi'] as $key=>$val){
                if(isset($val['check']) && $val['check']==1){
                    $hasil_pecah[$val['m_cv_id']]['m_cv_id']= $val['m_cv_id'];
                    $hasil_pecah[$val['m_cv_id']]['kode_cv']= $val['kode_cv'];
                    $hasil_pecah[$val['m_cv_id']]['m_ekspedisi_id']= $ekspedisi_id;
                    
                    $hasil_pecah[$val['m_cv_id']]['detail'][$key]['merek']      = $value['merek'];
                    $hasil_pecah[$val['m_cv_id']]['detail'][$key]['sak']        = $val['sak'];
                    $hasil_pecah[$val['m_cv_id']]['detail'][$key]['jumlah_sak'] = $val['jumlah_sak'];
                    $hasil_pecah[$val['m_cv_id']]['detail'][$key]['harga']      = $val['harga'];
                    $hasil_pecah[$val['m_cv_id']]['detail'][$key]['total_berat']= $val['total_berat'];
                    $hasil_pecah[$val['m_cv_id']]['detail'][$key]['total_harga']= $val['total_harga'];
                }
            }            
        }
        
        $this->db->trans_start();   
        #Catat biaya pengiriman/ekspedisi
        $tarif  = $this->hitung_biaya_ekspedisi($customer_id, $ekspedisi_id, $berat_ekspedisi);
        $tarif_per_kg = $tarif['tarif_per_kg'];
        $uraian = "Bayar biaya ekspedisi <strong>".$tarif['ekspedisi']."</strong> untuk pengiriman SAGU ke "
                . "customer <strong>".$tarif['customer']."</strong> di <strong>".$tarif['kota']."</strong> "
                . "dengan total berat <strong>".number_format($berat_ekspedisi,0,',','.')." kg</strong> pada "
                . "tanggal <strong>".date('d/m/Y', strtotime($input_tgl))."</strong>, nomor "
                . "pengiriman <strong>".$this->input->post('no_delivery_order')."</strong>";

        $this->db->insert('t_transaksi_bayar', array(
                'tanggal'=>$input_tgl,
                'no_nota'=>$this->Model_m_numberings->getNumbering('NDOKS', $input_tgl),
                'dk'=>'D',
                'm_agen_id'=>$ekspedisi_id,
                'jenis_barang'=>'EKSPEDISI',
                'berat_bersih'=>$berat_ekspedisi,
                'total_harga'=>($berat_ekspedisi * $tarif_per_kg),
                'uraian'=>$uraian,
                'created'=>$tanggal,
                'created_by'=>$user_id,
                'modified'=>$tanggal,
                'modified_by'=>$user_id
        ));
        
        $tb_id = $this->db->insert_id();    
        
        foreach ($hasil_pecah as $idx=>$row){
            #Create DO CV
            $no_do_cv = $this->Model_m_numberings->getNumbering('INV.'.$row['kode_cv'], $input_tgl);
            $this->db->insert('t_do_cv', array(
                'tanggal'=>$input_tgl,
                'm_cv_id'=>$row['m_cv_id'],
                'no_delivery_order'=>$no_do_cv,
                'm_customer_id'=>$this->input->post('m_customer_id'),
                'm_ekspedisi_id'=>$row['m_ekspedisi_id'],
                'do_pabrik_id'=>$id,
                'created'=>$tanggal,
                'created_by'=>$user_id,
                'modified'=>$tanggal,
                'modified_by'=>$user_id
            ));
            
            $do_cv_id = $this->db->insert_id();                       
                    
            #Insert ke tabel DO CV Detail
            $penjualan = 0;
            $berat_cv  = 0;
            foreach ($row['detail'] as $index=>$value){
                $total_berat = str_replace(".", "", $value['total_berat']);
                $total_harga = str_replace(".", "", $value['total_harga']);
                $penjualan += $total_harga;
                
                $berat_cv += $total_berat;
                
                $this->db->insert('t_do_cv_detail', array(
                    't_do_cv_id'=>$do_cv_id,
                    'merek'=>$value['merek'],
                    'sak'=>$value['sak'],
                    'jumlah_sak'=>$value['jumlah_sak'],
                    'harga'=>$value['harga'],
                    'total_berat'=>$total_berat,
                    'total_harga'=>$total_harga,
                    'created'=>$tanggal,
                    'created_by'=>$user_id,
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id
                ));
                
                #Update stok CV
                $get_stok = $this->Model_t_oven->cek_stok('SAGU '.$value['merek'], $row['m_cv_id'], $value['sak'])->row_array(); 
                $stok_id  = $get_stok['id'];
                $stok     = $get_stok['stok']- $total_berat;

                $this->db->where('id', $stok_id);
                $this->db->update('t_inventory', array('stok'=>$stok, 
                                'modified'=>$tanggal, 'modified_by'=>$user_id));

                #Save data ke tabel detail inventory
                $this->db->insert('t_inventory_detail', array(
                    't_inventory_id'=>$stok_id,
                    'tanggal'=>$input_tgl,
                    'jumlah_keluar'=>$total_berat,
                    'referensi_name'=>'t_do_cv',
                    'referensi_id'=>$do_cv_id,
                    'referensi_no'=>$no_do_cv
                ));                
            }
            #Update sisa limit CV
            $cek_cv       = $this->Model_back_office->show_data_cv($row['m_cv_id'])->row_array();
            $penjualan_cv = $cek_cv['total_penjualan']+ $penjualan;
            $limit_cv     = $cek_cv['sisa_limit']- $penjualan;
            
            $this->db->where('id', $row['m_cv_id']);
            $this->db->update('m_cv', array(
                        'total_penjualan'=>$penjualan_cv, 
                        'sisa_limit'=>$limit_cv,
                        'modified'=>$tanggal,
                        'modified_by'=>$user_id
            ));
            
            #Catat biaya pengiriman/ekspedisi            
            $this->db->insert('t_tagihan_ekspedisi', array(
                    'tanggal'=>$input_tgl,
                    'm_cv_id'=>$row['m_cv_id'],
                    'm_ekspedisi_id'=>$ekspedisi_id,
                    't_delivery_order_id'=>$id,
                    'm_customer_id'=>$customer_id,
                    'berat'=>$berat_cv,
                    'jumlah'=>($berat_cv * $tanggal),
                    't_transaksi_bayar_id'=>$tb_id,
                    'created'=>$tanggal,
                    'created_by'=>$user_id,
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id
            ));
        }
        #Update flag pecah di do pabrik
        $this->db->where('id', $id);
        $this->db->update('t_delivery_order', array(
                    'flag_pecah'=>1, 
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id
        ));
        if($this->db->trans_complete()){   
            $this->session->set_flashdata('flash_msg', 'Data berhasil disimpan');
            redirect('index.php/BackOffice/pecah_do');
        }else{
            echo "Terjadi kesalahan saat menyimpan data item produk..";
            echo "<pre>"; die(var_dump($this->input->post()));
        }
    }
    
    function print_do_cv(){
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_back_office');
            $header = $this->Model_back_office->show_do_cv($id)->row_array(); 
            $detail = $this->Model_back_office->show_detail_do_cv($id)->result(); 

            require('fpdf/fpdf.php');
            
            $pdf = new FPDF();
            $pdf->AliasNbPages();
            $pdf->AddPage();
            
            $pdf->SetFont('times','B',13);
            $pdf->Cell(105,8, 'INVOICE');
            $pdf->SetFont('times','B',8);
            $pdf->Cell(20,4,'Invoice No');
            $pdf->Cell(65,4,': '.$header['no_delivery_order']);
            $pdf->Ln(4);
            $pdf->SetFont('times','',8);
            $pdf->Cell(105);
            $pdf->Cell(20,4,'Invoice Date');
            $pdf->Cell(65,4,': '.date('d-m-Y', strtotime($header['tanggal'])));
            $pdf->Ln(4);            
            
            $pdf->Cell(105,4,'PT. UNGGUL MEKAR SARI');
            $pdf->Cell(20,4,'Bill To');
            $pdf->Cell(65,4,': '.$header['nama_customer']);
            $pdf->Ln(4);
            
            $pdf->Cell(105,4,'DESA BINA KARYA II');
            $pdf->Cell(20,4,'Address');
            $pdf->Cell(65,4,': '.$header['alamat']);
            $pdf->Ln(4);
            
            $pdf->Cell(105,4,'KEC. RUMBIA');
            $pdf->Cell(20,4,'');
            $pdf->Cell(65,4,'');
            $pdf->Ln(4);

            $pdf->Cell(105,4,'LAMPUNG TENGAH');
            $pdf->Cell(20,4,'Phone');
            $pdf->Cell(65,4,': '.$header['telepon']);
            $pdf->Ln(4);
            
            $pdf->Cell(105);
            $pdf->Cell(20,4,'PIC');
            $pdf->Cell(65,4,': '.$header['pic']);
            $pdf->Ln(4);
            
            $pdf->SetFont('times','B',8);
            $pdf->Cell(10,4,'No','LBTR',0,'C');
            $pdf->Cell(60,4,'Item','BTR',0,'C');
            $pdf->Cell(40,4,'Sak','BTR',0,'C');
            $pdf->Cell(30,4,'Qty','BTR',0,'C');
            $pdf->Cell(50,4,'Sak x Qty','BTR',0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('times','',8);
            
            $no=0;
            $total = 0;
            foreach ($detail as $key=>$value){
                $no++;
                $pdf->Cell(10,4,$no,'LR',0,'C');
                $pdf->Cell(60,4,$value->merek,'R',0,'L');
                $pdf->Cell(40,4,$value->sak.' Kg','R',0,'C');
                $pdf->Cell(30,4,number_format($value->jumlah_sak,0,',','.'),'R',0,'C');
                $sub_total = $value->sak * $value->jumlah_sak;
                $total += $sub_total;
                $pdf->Cell(50,4,number_format($sub_total,0,',','.').' Kg','R',0,'R');
                $pdf->Ln(4);
            }
            $pdf->Cell(10,10,'','LBR');
            $pdf->Cell(60,10,'','BR');
            $pdf->Cell(40,10,'','BR');
            $pdf->Cell(30,10,'','BR');
            $pdf->Cell(50,10,'','BR');
            $pdf->Ln(10);
            
            $pdf->Cell(140,4,'Total Order : ','LBR',0,'R');
            $pdf->Cell(50,4,number_format($total,0,',','.').' Kg','BR',0,'R');
            $pdf->Ln(10);
            
            $pdf->Cell(100,4);
            $pdf->Cell(90,4,'Remarks');
            $pdf->Ln(4);
            
            $pdf->Cell(35,4,'Prepared By');
            $pdf->Cell(35,4,'Approved By');
            $pdf->Cell(30,4,'Received By');
            $pdf->Cell(90,4,'','LTR');
            $pdf->Ln(4);
            
            $pdf->Cell(100,12);
            $pdf->Cell(90,12,'','LR');
            $pdf->Ln(12);
            
            $pdf->Cell(35,4,'-----------------');
            $pdf->Cell(35,4,'-----------------');
            $pdf->Cell(30,4,'-----------------');
            $pdf->Cell(90,4,'','LBR');
            $pdf->Ln(4);
            
            $pdf->Output('delivery_order_'.$header['no_delivery_order'].'.pdf', 'D');
            #$pdf->Output();         
        }else{
            redirect('index.php/BackOffice/list_do_cv'); 
        }
    }
                
    function cek_harga(){
        $sagu = $this->input->post('type_sagu');
        $sak  = $this->input->post('type_sak');
        
        $this->load->model('Model_m_biaya');
        $get_harga = $this->Model_m_biaya->get_harga('Penjualan', 'HARGA SAGU '.$sagu, 'Harga Item', 'sak='.$sak)->row_array();
        $harga = ($get_harga)? number_format($get_harga['jumlah'],0,',', '.'): 0;

        header('Content-Type: application/json');
        echo json_encode($harga);
    }
    
    function save_produk_do(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                    't_delivery_order_id'=> $this->input->post('t_delivery_order_id'),                        
                    'merek'=> $this->input->post('merek'),
                    'sak'=> $this->input->post('sak'),
                    'jumlah_sak'=> str_replace(".", "", $this->input->post('jumlah_sak')),
                    'harga'=> str_replace(".", "", $this->input->post('harga')),
                    'total_harga'=> str_replace(".", "", $this->input->post('total_harga')),
                    'catatan'=> $this->input->post('dtl_catatan'),                    
                    'created'=> $tanggal,
                    'created_by'=> $user_id,
                    'modified'=> $tanggal,
                    'modified_by'=> $user_id,
                );  
        $this->db->trans_start();
        $this->db->insert('t_delivery_order_detail', $data);
        
        $this->load->model('Model_back_office');
        $sum_order   = $this->Model_back_office->sum_total_do($this->input->post('t_delivery_order_id'))->row_array();
        $total_order = $sum_order['total_order'];
        
        $this->db->where('id', $this->input->post('t_delivery_order_id'));
        $this->db->update('t_delivery_order', array('total_order'=>$total_order));
        
        if($this->db->trans_complete()){            
            redirect('index.php/BackOffice/edit_delivery_order/'.$this->input->post('t_delivery_order_id'));
        }else{
            echo "Terjadi kesalahan saat menyimpan data item produk..";
            echo "<pre>"; die(var_dump($data));
        }
    }
    
    function edit_produk_do(){        
        $id = $this->input->post('id');
        $this->load->model('Model_back_office');
        $data = $this->Model_back_office->get_detail_do($id)->row_array();
        $data['jumlah_sak']= number_format($data['jumlah_sak'],0,',','.');
        $data['harga']= number_format($data['harga'],0,',','.');
        $data['total_harga']= number_format($data['total_harga'],0,',','.');
        
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    function update_produk_do(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                    'merek'=> $this->input->post('merek'),
                    'sak'=> $this->input->post('sak'),
                    'jumlah_sak'=> str_replace(".", "", $this->input->post('jumlah_sak')),
                    'harga'=> str_replace(".", "", $this->input->post('harga')),
                    'total_harga'=> str_replace(".", "", $this->input->post('total_harga')),
                    'catatan'=> $this->input->post('dtl_catatan'),   
                    'modified'=> $tanggal,
                    'modified_by'=> $user_id,
                );
        
        $this->db->trans_start();
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('t_delivery_order_detail', $data);
        
        $this->load->model('Model_back_office');
        $sum_order   = $this->Model_back_office->sum_total_do($this->input->post('t_delivery_order_id'))->row_array();
        $total_order = $sum_order['total_order'];
        
        $this->db->where('id', $this->input->post('t_delivery_order_id'));
        $this->db->update('t_delivery_order', array('total_order'=>$total_order));
        
        if($this->db->trans_complete()){
            redirect('index.php/BackOffice/edit_delivery_order/'.$this->input->post('t_delivery_order_id'));
        }else{
            echo "Terjadi kesalahan saat menyimpan data item produk..";
            echo "<pre>"; die(var_dump($data));
        }
    }
    
    function delete_produk_do(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->load->model('Model_back_office');
            $header = $this->Model_back_office->get_detail_do($id)->row_array(); 
            $header_id = $header['t_delivery_order_id'];

            $this->db->where('id', $id);
            $this->db->delete('t_delivery_order_detail');  
            redirect('index.php/BackOffice/edit_delivery_order/'.$header_id);
        }
        redirect('index.php/BackOffice/delivery_order');
    }
    
    
    function list_do_cv(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "BackOffice/list_do_cv";
        $data['content']= "delivery_order/list_do_cv";
        $this->load->model('Model_back_office');
        $data['list_data'] = $this->Model_back_office->list_do_cv()->result();

        $this->load->view('layout', $data);
    }
    #============================== Ekspedisi ===================================
    function list_ekspedisi(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "BackOffice/list_ekspedisi";
        $data['content']= "back_office/list_ekspedisi";
        $this->load->model('Model_back_office');
        $data['list_data'] = $this->Model_back_office->list_data_ekspedisi()->result();
        
        $data['list_provinsi'] = $this->Model_back_office->list_provinsi()->result();
        $data['list_city'] = $this->Model_back_office->list_kota(1)->result();

        $this->load->view('layout', $data);
    }
    
    function cek_ekspedisi(){
        $code = $this->input->post('data');
        $this->load->model('Model_back_office');
        $cek_data = $this->Model_back_office->cek_data_ekspedisi($code)->row_array();
        $return_data = ($cek_data)? "ADA": "TIDAK ADA";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function save_ekspedisi(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                        'nama_ekspedisi'=> $this->input->post('nama_ekspedisi'),
                        'telepon'=> $this->input->post('telepon'),
                        'hp'=> $this->input->post('hp'),
                        'alamat'=> $this->input->post('alamat'),
                        'm_province_id'=> $this->input->post('m_province_id'),
                        'm_city_id'=> $this->input->post('m_city_id'),
                        'kode_pos'=> $this->input->post('kode_pos'),
                        'keterangan'=> $this->input->post('keterangan'),
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
       
        $this->db->insert('m_ekspedisi', $data); 
        redirect('index.php/BackOffice/list_ekspedisi');       
    }
    
    function delete_ekspedisi(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('m_ekspedisi');            
        }
        redirect('index.php/BackOffice/list_ekspedisi');
    }
    
    function edit_ekspedisi(){
        $id = $this->input->post('id');
        $this->load->model('Model_back_office');
        $data = $this->Model_back_office->show_data_ekspedisi($id)->row_array(); 
        
        header('Content-Type: application/json');
        echo json_encode($data);       
    }
    
    function update_ekspedisi(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                'nama_ekspedisi'=> $this->input->post('nama_ekspedisi'),
                'telepon'=> $this->input->post('telepon'),
                'hp'=> $this->input->post('hp'),
                'alamat'=> $this->input->post('alamat'),
                'm_province_id'=> $this->input->post('m_province_id'),
                'm_city_id'=> $this->input->post('m_city_id'),
                'kode_pos'=> $this->input->post('kode_pos'),
                'keterangan'=> $this->input->post('keterangan'),
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('m_ekspedisi', $data);
        
        redirect('index.php/BackOffice/list_ekspedisi');
    }
    
    function tarif_ekspedisi(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $id = $this->uri->segment(3);           
        $data['judul']  = "BackOffice/list_ekspedisi";
        $data['content']= "back_office/tarif_ekspedisi";
        $this->load->model('Model_back_office');
        $data['header_id']   = $id;
        $data['header_data'] = $this->Model_back_office->show_data_ekspedisi($id)->result(); 
        $data['list_data']   = $this->Model_back_office->list_tarif($id)->result();
        
        $data['list_city'] = $this->Model_back_office->list_all_kota()->result();

        $this->load->view('layout', $data);
    }  
    
    function save_tarif(){        
        $data = array(
                        'asal_id'=> $this->input->post('asal_id'),
                        'm_ekspedisi_id'=> $this->input->post('m_ekspedisi_id'),
                        'tujuan_id'=> $this->input->post('tujuan_id'),
                        'tarif'=> str_replace(".", "", $this->input->post('tarif'))
                    );
        $this->db->insert('m_tarif_ekspedisi', $data);  
        redirect('index.php/BackOffice/tarif_ekspedisi/'.$this->input->post('m_ekspedisi_id'));
    }
    
    function delete_tarif(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->load->model('Model_back_office');
            $header_data = $this->Model_back_office->show_tarif($id)->row_array();
            $header_id = $header_data['m_ekspedisi_id'];
            
            $this->db->where('id', $id);
            $this->db->delete('m_tarif_ekspedisi'); 
            
            redirect('index.php/BackOffice/tarif_ekspedisi/'.$header_id);
        }        
    }
    
    function edit_tarif(){         
        $id = $this->input->post('id');
        $this->load->model('Model_back_office');
        $data = $this->Model_back_office->show_tarif($id)->row_array(); 
        
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    function update_tarif(){        
        $data = array(
                'asal_id'=> $this->input->post('asal_id'),
                'tujuan_id'=> $this->input->post('tujuan_id'),
                'tarif'=> str_replace(".", "", $this->input->post('tarif'))
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('m_tarif_ekspedisi', $data);
        
        redirect('index.php/BackOffice/tarif_ekspedisi/'.$this->input->post('m_ekspedisi_id'));
    }
    
    function hitung_biaya_ekspedisi($customer_id, $ekspedisi_id, $berat_ekspedisi){
        #Get kota customer
        $return_data = array();
        $this->load->model('Model_back_office');
        $customer = $this->Model_back_office->get_data_customer($customer_id)->row_array();
        $return_data['kota']      = $customer['city_name'];        
        $return_data['customer']  = $customer['nama_customer'];
        
        if(!empty($customer['m_city_id'])){
            #get tarif ekspedisi ke kota customer
            $get_tarif = $this->Model_back_office->get_tarif($ekspedisi_id, $customer['m_city_id'])->row_array(); 
            $return_data['ekspedisi'] = $get_tarif['nama_ekspedisi'];
            if($get_tarif){
                $tarif = $get_tarif['tarif']* $berat_ekspedisi;
                $return_data['tarif'] = $tarif; 
                $return_data['tarif_per_kg'] = $get_tarif['tarif']; 
            }else{
                 $return_data['tarif'] = 0;
                 $return_data['tarif_per_kg']=0;
            }
        }else{
            $return_data['tarif'] = 0;
            $return_data['tarif_per_kg']=0;
        }
        return $return_data;
    }
}