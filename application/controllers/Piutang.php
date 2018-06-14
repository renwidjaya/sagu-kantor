<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Piutang extends CI_Controller{
    function __construct(){
        parent::__construct();

        if($this->session->userdata('status') != "login"){
            redirect(base_url("index.php/Login"));
        }
    }
    
    function list_invoice(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Piutang/list_invoice";
        $data['content']= "piutang/list_invoice";
        $this->load->model('Model_back_office');
        $data['list_data'] = $this->Model_back_office->list_do_cv()->result();

        $this->load->view('layout', $data);
    }
    
    function pembayaran(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Piutang/pembayaran";
        $data['content']= "piutang/pembayaran";
        $this->load->model('Model_pembayaran');
        $data['list_data'] = $this->Model_pembayaran->list_data()->result();  
        $data['list_customer'] = $this->Model_pembayaran->list_customer()->result();
        $data['list_cv'] = $this->Model_pembayaran->list_cv()->result();

        $this->load->view('layout', $data);
    }
    
    function save_pembayaran(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                        'tanggal'=> date('Y-m-d', strtotime($this->input->post('tanggal'))),
                        'm_customer_id'=> $this->input->post('m_customer_id'),
                        'm_cv_id'=> $this->input->post('m_cv_id'),
                        'jenis_tagihan'=> $this->input->post('jenis_tagihan'),
                        'payment_method'=> $this->input->post('payment_method'),
                        'nama_bank'=> $this->input->post('nama_bank'),
                        'no_rekening'=> $this->input->post('no_rekening'),
                        'amount'=> str_replace('.','', $this->input->post('amount')),
                        'no_referensi'=> $this->input->post('no_referensi'),
                        'keterangan'=> $this->input->post('keterangan'),
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
       
        $this->db->insert('tb_transfer', $data); 
        $this->session->set_flashdata('flash_msg', 'Data berhasil disimpan');

        redirect('index.php/Piutang/pembayaran');       
    }
    
    function delete_pembayaran(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('tb_transfer');            
        }
        $this->session->set_flashdata('flash_msg', 'Data berhasil dihapus');
        redirect('index.php/Piutang/pembayaran');
    }
    
    function proses_pembayaran(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Piutang/proses_pembayaran";
        $data['content']= "piutang/proses_pembayaran";
        
        $this->load->model('Model_pembayaran');
        #$data['list_data'] = $this->Model_pembayaran->list_data()->result();  
        $data['list_customer'] = $this->Model_pembayaran->list_customer()->result();
        $data['list_cv'] = $this->Model_pembayaran->list_cv()->result();

        $this->load->view('layout', $data);
    }
    
    function show_list(){
        $m_customer_id = $this->input->post('m_customer_id');
        $m_cv_id = $this->input->post('m_cv_id');
        
        $return_data = array();
        
        $this->load->model('Model_pembayaran');
        $getListInvoice = $this->Model_pembayaran->get_list_invoice($m_customer_id, $m_cv_id)->result();
        
        if($getListInvoice){
            $return_data['jumlah_invoice']= sizeof($getListInvoice);
            $return_data['invoice_list']= '';
            $no=0;
            foreach($getListInvoice as $index=>$value){
                $no++;
                $return_data['invoice_list'].= '<tr>';
                $return_data['invoice_list'].= '<td style="text-align:center">'.$no.'</td>';
                $return_data['invoice_list'].= '<td>'.date('d-m-Y', strtotime($value->tanggal)).'</td>';
                $return_data['invoice_list'].= '<td>'.$value->no_delivery_order.'</td>';
                $return_data['invoice_list'].= '<td style="text-align:right">'.number_format($value->total_invoice,2,',','.').'</td>';
                $return_data['invoice_list'].= '<td style="text-align:center">';
                $return_data['invoice_list'].= '<div id="boxStatus_'.$no.'"></div>';
                $return_data['invoice_list'].= '</td>';
                $return_data['invoice_list'].= '</tr>';
            }
            
        }else{
            $return_data['jumlah_invoice']= 0;
            $return_data['invoice_list']= '<tr><td colspan="5">Tidak ada list invoice untuk customer dan CV yang Anda pilih</td>';
        }
        
        $getListBayar = $this->Model_pembayaran->get_list_bayar($m_customer_id, $m_cv_id)->result();
        if($getListBayar){
            $return_data['jumlah_bayar']= sizeof($getListBayar);
            $return_data['bayar_list']= '';
            $tb=0;
            foreach($getListBayar as $index=>$value){
                $tb++;
                $return_data['bayar_list'].= '<tr>';
                $return_data['bayar_list'].= '<td style="text-align:center">'.$tb.'</td>';
                $return_data['bayar_list'].= '<td>'.date('d-m-Y', strtotime($value->tanggal)).'</td>';
                $return_data['bayar_list'].= '<td>'.$value->payment_method.'</td>';
                $return_data['bayar_list'].= '<td>'.$value->nama_bank.'</td>';
                $return_data['bayar_list'].= '<td>'.$value->no_rekening.'</td>';
                $return_data['bayar_list'].= '<td style="text-align:right">'.number_format($value->amount,2,',','.').'</td>';
                $return_data['bayar_list'].= '</tr>';
            }
            
        }else{
            $return_data['jumlah_bayar']= 0;
            $return_data['bayar_list']= '<tr><td colspan="6">Tidak ada list pembayaran untuk customer dan CV yang Anda pilih</td>';
        }
        
        header('Content-Type: application/json');
        echo json_encode($return_data);        
    }
    
    function simulasi_pembayaran(){
        $m_customer_id = $this->input->post('m_customer_id');
        $m_cv_id = $this->input->post('m_cv_id');
        
        $return_data = array();
        
        $this->load->model('Model_pembayaran');
        $getListInvoice = $this->Model_pembayaran->get_list_invoice($m_customer_id, $m_cv_id)->result();
        $return_data['jumlah_invoice'] = sizeof($getListInvoice);
        
        $getSumBayar    = $this->Model_pembayaran->get_sum_bayar($m_customer_id, $m_cv_id)->row_array();
        $total_bayar    = $getSumBayar['total_bayar'];
        
        $no=0;
        foreach ($getListInvoice as $index=>$value){
            $no++;
            if($total_bayar>=$value->total_invoice){
                $return_data['status'][$no] = "Lunas";
                $total_bayar = $total_bayar - $value->total_invoice;
            }else{
                $return_data['status'][$no] = "Pending";
            }
        }
        $return_data['sisa_cash']= number_format($total_bayar,2,',','.');
        
        header('Content-Type: application/json');
        echo json_encode($return_data); 
    }
    
    function seatle(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $m_customer_id = $this->input->post('m_customer_id');
        $m_cv_id = $this->input->post('m_cv_id');
        
        
        $this->load->model('Model_pembayaran');
        $getListInvoice = $this->Model_pembayaran->get_list_invoice($m_customer_id, $m_cv_id)->result();
        $return_data['jumlah_invoice'] = sizeof($getListInvoice);
        
        $getSumBayar  = $this->Model_pembayaran->get_sum_bayar($m_customer_id, $m_cv_id)->row_array();
        $cash_awal    = $getSumBayar['total_bayar'];
        $cash_akhir   = $getSumBayar['total_bayar'];
        
        $no=0;
        $this->db->trans_start();
        foreach ($getListInvoice as $index=>$value){
            $no++;
            if($cash_akhir>=$value->total_invoice){
                $this->db->where('id', $value->id);
                $this->db->update('t_do_cv', array(
                    'flag_bayar'=>1,
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id));
                
                $cash_akhir = $cash_akhir - $value->total_invoice;
            }
        }

        if($cash_akhir<$cash_awal){
            $this->db->where(array('m_customer_id'=>$m_customer_id, 'm_cv_id'=>$m_cv_id, 'flag_bayar'=>0, 'jenis_tagihan'=>'SAGU'));
            $this->db->update('tb_transfer', array(
                    'flag_bayar'=>1,
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id));
            
            if($cash_akhir>0){
                $this->db->insert('tb_transfer', array(
                    'tanggal'=>date('Y-m-d'),
                    'm_customer_id'=>$m_customer_id, 
                    'm_cv_id'=>$m_cv_id,
                    'jenis_tagihan'=>'SAGU',
                    'payment_method'=>'Cash',
                    'amount'=>$cash_akhir,
                    'keterangan'=>'Sisa seatle tanggal '.date('Y-m-d')
                ));
            }
        }
        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Data berhasil diproses');
            redirect('index.php/Piutang/pembayaran');
        }else{
            $this->session->set_flashdata('flash_msg', 'Terjadi error saat menyimpan data');
            redirect('index.php/Piutang/pembayaran');
        }
    }
    
    function update_invoice(){
        $user_id = $this->session->userdata('user_id');
        $tanggal = date('Y-m-d h:m:s');
        
        foreach ($this->input->post('mydata') as $value){
            if(isset($value['check']) && $value['check']==1){
                $this->db->where('id', $value['do_id']);
                $this->db->update('t_do_cv', array(
                    'flag_bayar'=>1,
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id
                ));
            }
        }
        $this->session->set_flashdata('flash_msg', 'Data berhasil diproses');
        redirect('index.php/Piutang/list_invoice');
    }
    
}