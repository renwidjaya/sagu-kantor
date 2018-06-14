<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kas extends CI_Controller{
    function __construct(){
        parent::__construct();

        if($this->session->userdata('status') != "login"){
            redirect(base_url("index.php/Login"));
        }
    }
    
    function list_nota_bayar(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Kas/list_nota_bayar";
        $data['content']= "kas/list_nota_bayar";
        $this->load->model('Model_kas');
        if (!empty($this->input->post('tgl_awal'))){            
            $data['tgl_awal']  = date('Y-m-d', strtotime($this->input->post('tgl_awal')));            
            $data['tgl_akhir'] = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
        }else{
            $data['tgl_awal']  = date('d-m-Y');
            $data['tgl_akhir'] = date('d-m-Y');
        }
        $data['list_data'] = $this->Model_kas->list_nota_bayar($data['tgl_awal'], $data['tgl_akhir'])->result();

        $this->load->view('layout', $data);
    }
    
    function bayar_nota(){
        $id = $this->input->post('id');
        $this->load->model('Model_kas');
        $data = $this->Model_kas->get_transaksi_bayar($id)->row_array(); 
        $data['tanggal'] = date('d/m/Y', strtotime($data['tanggal']));
        $data['berat_bersih'] = number_format($data['berat_bersih'],0,',','.');
        $data['harga'] = number_format($data['harga'],0,',','.');
        $data['total_harga'] = number_format($data['total_harga'],0,',','.');
        
        header('Content-Type: application/json');
        echo json_encode($data);  
    }
    
    function save_bayar_nota(){
        $user_id   = $this->session->userdata('user_id');
        $tanggal   = date('Y-m-d h:m:s');        
        $input_tgl = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $jumlah    = str_replace(".", "", $this->input->post('total_harga'));

        $data = array(
                        'tanggal'=> $input_tgl,
                        'uraian'=> $this->input->post('uraian'),
                        'dk'=> 'D',
                        'debet'=> $jumlah,
                        'no_referensi'=> $this->input->post('no_nota'),
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
        $this->db->trans_start();
        $this->db->insert('t_kas_kantor', $data); 

        $id = $this->db->insert_id();
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('t_transaksi_bayar', array('flag_bayar'=>1, 
                    'tempat_transaksi'=>$this->input->post('tempat_transaksi'))); 
        
        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo_id  = $get_saldo['id'];
        $saldo     = $get_saldo['saldo_akhir_kantor'] - $jumlah;
        $this->db->where('id', $saldo_id);
        $this->db->update('t_saldo', array('saldo_akhir_kantor'=>$saldo)); 

        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Data pembayaran nota dengan nomor '.$this->input->post('no_nota').' berhasil disimpan');
            redirect('index.php/Kas/list_nota_bayar');   
        }else{
            echo "Terjadi kesalahan saat menyimpan data...";
            echo "<pre>"; die(var_dump($this->input->post()));
        }        
    }
    
    function save_nota_manual(){
        $user_id   = $this->session->userdata('user_id');
        $tanggal   = date('Y-m-d h:m:s');        
        $input_tgl = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $jumlah    = str_replace(".", "", $this->input->post('jumlah'));
        
        $this->db->trans_start();
        
        $this->load->model('Model_m_numberings');
        $code = $this->Model_m_numberings->getNumbering('NDMNL', $input_tgl); 

        $data = array(
                        'tanggal'=> $input_tgl,
                        'uraian'=> $this->input->post('uraian'),
                        'dk'=> 'D',
                        'debet'=> $jumlah,
                        'no_referensi'=> $code,
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
        
        $this->db->insert('t_kas_kantor', $data); 

        $this->db->insert('t_transaksi_bayar', array(
            'tanggal'=>$input_tgl,
            'no_nota'=>$code,
            'dk'=>'D',
            'tempat_transaksi'=>$this->input->post('tempat_transaksi'),
            'total_harga'=>$jumlah,
            'uraian'=>$this->input->post('uraian'),
            'flag_bayar'=>1,
            'created'=>$tanggal,
            'created_by'=>$user_id,
            'modified'=>$tanggal,
            'modified_by'=>$user_id,
        )); 
        
        
        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo_id  = $get_saldo['id'];
        $saldo     = $get_saldo['saldo_akhir_kantor'] - $jumlah;
        $this->db->where('id', $saldo_id);
        $this->db->update('t_saldo', array('saldo_akhir_kantor'=>$saldo)); 

        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Transaksi nota manual berhasil dibuat dengan nomor '.$code);
            redirect('index.php/Kas/list_nota_bayar');   
        }else{
            echo "Terjadi kesalahan saat menyimpan data...";
            echo "<pre>"; die(var_dump($this->input->post()));
        }        
    }
    
    function list_biaya(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Kas/list_biaya";
        $data['content']= "kas/list_biaya";
        $this->load->model('Model_kas');
        $data['list_data'] = $this->Model_kas->list_biaya()->result();

        $this->load->view('layout', $data);
    }
    
    function save_cancel_transaksi(){
        $user_id   = $this->session->userdata('user_id');
        $tanggal   = date('Y-m-d h:m:s');        

        $this->db->trans_start();
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('t_transaksi_bayar', array('flag_cancel'=>1, 
                'alasan_cancel'=>$this->input->post('alasan_cancel'), 
                'modified'=>$tanggal, 'modified_by'=>$user_id));         

        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Transaksi dengan nomor '.$this->input->post('no_nota').' berhasil dibatalkan');
            redirect('index.php/Kas/list_nota_bayar');   
        }else{
            echo "Terjadi kesalahan saat menyimpan data...";
            echo "<pre>"; die(var_dump($this->input->post()));
        }        
    }
    
    function pembayaran_nota_gelondongan(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Kas/pembayaran_nota_gelondongan";
        $data['content']= "kas/pembayaran_nota_gelondongan";
        $this->load->model('Model_kas');
        if (!empty($this->input->post('tgl_awal'))){            
            $data['tgl_awal']  = date('Y-m-d', strtotime($this->input->post('tgl_awal')));            
            $data['tgl_akhir'] = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
        }else{
            $data['tgl_awal']  = date('d-m-Y');
            $data['tgl_akhir'] = date('d-m-Y');;
        }
        $data['list_data'] = $this->Model_kas->list_nota_bayar_gelondongan($data['tgl_awal'], $data['tgl_akhir'])->result();

        $this->load->view('layout', $data);
    }
    
    function save_nota_gelondongan(){
        $user_id   = $this->session->userdata('user_id');
        $tanggal   = date('Y-m-d h:m:s');        
        $input_tgl = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $sisa_bayar= str_replace(".", "", $this->input->post('total_bayar'));
        
        $item   = $this->input->post('mydata');
        $uraian = "Pembayaran nota gelondongan sebesar Rp. ".$this->input->post('total_bayar')." untuk nota bayar dengan nomor : ";
        
        foreach ($item as $index=>$value){
            if(isset($value['check']) && $value['check']==1){
                $uraian .= $value['no_nota']." (Rp. ".number_format($value['jumlah'],0,',','.')."), ";
            }else{
                unset($item[$index]);
            }
        }
        
        $data = array(
                    'tanggal'=> $input_tgl,
                    'uraian'=> $uraian,
                    'dk'=> 'D',
                    'debet'=> $sisa_bayar,
                    'no_referensi'=> 'NOTA GELONDONGAN',
                    'created'=> $tanggal,
                    'created_by'=> $user_id,
                    'modified'=> $tanggal,
                    'modified_by'=> $user_id,
                );
        $this->db->trans_start();
        $this->db->insert('t_kas_kantor', $data); 

        $id = $this->db->insert_id();
        foreach($item as $key=>$val){
            $this->db->where('id', $val['nota_id']);
            $this->db->update('t_transaksi_bayar', array(
                                'tempat_transaksi'=>$this->input->post('tempat_transaksi'),
                                'flag_bayar'=>1, 
                                'modified'=>$tanggal,
                                'modified_by'=>$user_id,
            )); 
        }        
        
        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo_id  = $get_saldo['id'];
        $saldo     = $get_saldo['saldo_akhir_kantor'] - $sisa_bayar;
        $this->db->where('id', $saldo_id);
        $this->db->update('t_saldo', array('saldo_akhir_kantor'=>$saldo));         

        if($this->db->trans_complete()){
            redirect('index.php');   
        }else{
            echo "Terjadi kesalahan saat menyimpan data...";
            echo "<pre>"; die(var_dump($this->input->post()));
        } 
    }
    
    function list_nota_jual(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Kas/list_nota_jual";
        $data['content']= "kas/list_nota_jual";
        $this->load->model('Model_kas');
        if (!empty($this->input->post('tgl_awal'))){            
            $data['tgl_awal']  = date('Y-m-d', strtotime($this->input->post('tgl_awal')));            
            $data['tgl_akhir'] = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
        }else{
            $data['tgl_awal']  = date('d-m-Y');
            $data['tgl_akhir'] = date('d-m-Y');;
        } 
        $data['list_data'] = $this->Model_kas->list_nota_jual($data['tgl_awal'], $data['tgl_akhir'])->result();

        $this->load->view('layout', $data);
    }
    
    function terima_nota(){
        $id = $this->input->post('id');
        $this->load->model('Model_kas');
        $data = $this->Model_kas->get_transaksi_bayar($id)->row_array(); 
        $data['tanggal'] = date('d-m-Y', strtotime($data['tanggal']));
        $data['total_harga'] = number_format($data['total_harga'],0,',','.');
        
        header('Content-Type: application/json');
        echo json_encode($data);  
    }
    
    function save_terima_nota(){
        $user_id   = $this->session->userdata('user_id');
        $tanggal   = date('Y-m-d h:m:s');        
        $input_tgl = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $jumlah    = str_replace(".", "", $this->input->post('total_harga'));

        $data = array(
                        'tanggal'=> $input_tgl,
                        'uraian'=> $this->input->post('uraian'),
                        'dk'=> 'K',
                        'kredit'=> $jumlah,
                        'no_referensi'=> $this->input->post('no_nota'),
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
        $this->db->trans_start();
        $this->db->insert('t_kas_kantor', $data); 

        $id = $this->db->insert_id();
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('t_transaksi_bayar', array('flag_bayar'=>1, 
                    'tempat_transaksi'=>$this->input->post('tempat_transaksi'))); 
        
        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo_id  = $get_saldo['id'];
        $saldo     = $get_saldo['saldo_akhir_kantor'] + $jumlah;
        $this->db->where('id', $saldo_id);
        $this->db->update('t_saldo', array('saldo_akhir_kantor'=>$saldo)); 

        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Data penerimaan kas dengan nomor '.$this->input->post('no_nota').' berhasil disimpan');
            redirect('index.php/Kas/list_nota_jual');   
        }else{
            echo "Terjadi kesalahan saat menyimpan data...";
            echo "<pre>"; die(var_dump($this->input->post()));
        }        
    }
    
    function cek_kasbon(){
        $agen = $this->input->post('agen');  
        $return_data = array();
        $this->load->model('Model_kas');
        $kasbon = $this->Model_kas->cek_kasbon($agen)->result();
        if($kasbon){
            $return_data['status']= "ADA";
            $no = 0;
            $total = 0;
            $cetak = "";
            foreach ($kasbon as $index=>$value){
                $no++;
                $total += $value->jumlah; 
                $cetak .= "<tr>";
                $cetak .= "<td style='text-align:center'>".$no;
                $cetak .= "<input type='hidden' id='kasbon_id_".$no."' name='mykasbon[".$no."][kasbon_id]' value='".$value->id."'>";
                $cetak .= "</td>";
                $cetak .= "<td>".date('d-m-Y', strtotime($value->tanggal))."</td>";
                $cetak .= "<td>".$value->no_nota."</td>";
                $cetak .= "<td>".$value->nama_agen."</td>";
                $cetak .= "<td>".$value->supir."</td>";
                $cetak .= "<td>".$value->uraian."</td>";
                $cetak .= "<td style='text-align:right'>".number_format($value->jumlah,0,',','.')."</td>";
                $cetak .= "</tr>";
            }
            $return_data['konten']= $cetak;
            $return_data['kasbon']= number_format($total,0,',','.');
        }else{
            $return_data['status']= "TIDAK";
        }
        
        header('Content-Type: application/json');
        echo json_encode($return_data);  
    }
    
    function terima_kas_gelondongan(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Kas/terima_kas_gelondongan";
        $data['content']= "kas/terima_kas_gelondongan";
        $this->load->model('Model_kas');
        $data['list_data'] = $this->Model_kas->list_kas_gelondongan()->result();
        
        $this->load->model('Model_back_office');
        $data['customer_list'] = $this->Model_back_office->list_data_customer()->result();

        $this->load->view('layout', $data);
    }
    
    function cek_piutang(){
        $customer = $this->input->post('customer');  
        $return_data = array();
        $this->load->model('Model_kas');
        $piutang = $this->Model_kas->cek_piutang($customer)->row_array();
        if($piutang){
            $return_data['status']= "ADA";
            $return_data['piutang']= number_format($piutang['piutang'],0,',','.');
        }else{
            $return_data['status']= "TIDAK";
        }
        
        header('Content-Type: application/json');
        echo json_encode($return_data);  
    }
    
    function save_kas_gelondongan(){
        $user_id   = $this->session->userdata('user_id');
        $tanggal   = date('Y-m-d h:m:s');   
        #echo "<pre>"; die(var_dump($this->input->post()));
        $input_tgl   = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $jumlah_bayar= str_replace(".", "", $this->input->post('jumlah_bayar'));
        $piutang_lama= str_replace(".", "", $this->input->post('piutang_lama'));
        $total_bayar = str_replace(".", "", $this->input->post('total_bayar'));        
        $piutang     = str_replace(".", "", $this->input->post('sisa_bayar'));
        
        $this->db->trans_start();
        if($total_bayar>0){
            $item   = $this->input->post('mydata');
            $uraian = "Terima kas sebesar Rp. ".$this->input->post('jumlah_bayar')." untuk pelunasan nota dengan nomor : ";

            foreach ($item as $index=>$value){
                if(isset($value['check']) && $value['check']==1){
                    $uraian .= $value['no_nota']." (Rp. ".number_format($value['jumlah'],0,',','.')."), ";
                    
                    $this->db->where('id', $value['nota_id']);
                    $this->db->update('t_transaksi_bayar', array(
                                        'tempat_transaksi'=>$this->input->post('tempat_transaksi'),
                                        'flag_bayar'=>1, 
                                        'modified'=>$tanggal,
                                        'modified_by'=>$user_id,
                    )); 
                }
            }
            $uraian .= ", piutang sebelumnya Rp. ".$this->input->post('piutang_lama').", piutang sekarang Rp. ".$this->input->post('sisa_bayar');
            $this->db->insert('t_kas_kantor', array(
                    'tanggal'=> $input_tgl,
                    'uraian'=> $uraian,
                    'dk'=> 'K',
                    'kredit'=> $jumlah_bayar,
                    'no_referensi'=> 'KAS GELONDONGAN',
                    'created'=> $tanggal,
                    'created_by'=> $user_id,
                    'modified'=> $tanggal,
                    'modified_by'=> $user_id,
            )); 
        }else{
            if($piutang>0){
                $uraian = "Terima kas sebagai piutang customer <strong>".$this->input->post('nama_customer')."</strong> "
                        . "pada tanggal <strong>".date('d/m/Y', strtotime($input_tgl))."</strong>";
                
                $piutang_new = $piutang - $piutang_lama;
            
                $this->db->insert('t_kas_kantor', array(
                    'tanggal'=> $input_tgl,
                    'uraian'=> $uraian,
                    'dk'=> 'K',
                    'kredit'=> $piutang_new,
                    'no_referensi'=> 'PIUTANG AGEN',
                    'created'=> $tanggal,
                    'created_by'=> $user_id,
                    'modified'=> $tanggal,
                    'modified_by'=> $user_id,
                ));
            }
        }

        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo_id  = $get_saldo['id'];
        $saldo     = $get_saldo['saldo_akhir_kantor'] + $total_bayar + $piutang;
        $this->db->where('id', $saldo_id);
        $this->db->update('t_saldo', array('saldo_akhir_kantor'=>$saldo)); 
        
        $this->db->where('id', $this->input->post('m_customer_id'));
        $this->db->update('m_customers', array(
                    'piutang'=>$piutang,
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id,
        )); 
        
        
        if($this->db->trans_complete()){
            redirect('index.php');   
        }else{
            echo "Terjadi kesalahan saat menyimpan data...";
            echo "<pre>"; die(var_dump($this->input->post()));
        } 
    }
}