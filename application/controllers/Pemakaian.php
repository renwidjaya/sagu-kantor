<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Pemakaian extends CI_Controller{
    function __construct(){
        parent::__construct();

        if($this->session->userdata('status') != "login"){
            redirect(base_url("index.php/Login"));
        }
    }
    
    function index(){
        $module_name = $this->uri->segment(1);
        $muatan      = $this->uri->segment(3);
        $transaksi   = $this->uri->segment(4);
        
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Pemakaian";
        $data['content']= "pemakaian/index";
        $this->load->model('Model_t_timbang');
        $data['list_data'] = $this->Model_t_timbang->list_data_otorisasi($muatan, $transaksi)->result();

        $this->load->view('layout', $data);
    }
    
    function get_data_otorisasi(){
        $id = $this->input->post('id');
        $this->load->model('Model_t_otorisasi');
        $data = $this->Model_t_otorisasi->show_data_masuk($id)->row_array(); 
        
        header('Content-Type: application/json');
        echo json_encode($data);       
    }
    
    function save_timbang_pertama(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $muatan   = $this->input->post('nama_muatan');
        $transaksi= $this->input->post('jenis_transaksi');
        
        $data     = array(
                        't_otorisasi_id'=> $this->input->post('otorisasi_id'),
                        'berat1'=> str_replace('.','', $this->input->post('berat_timbang_1')),                        
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
       
        if($this->db->insert('t_timbang', $data)){ 
            $this->db->where('id', $this->input->post('otorisasi_id'));
            $this->db->update('t_otorisasi', array(
                'status'=>2,
                'modified'=>$tanggal,
                'modified_by'=>$user_id
            ));

            redirect('index.php/Pemakaian/index'.(!empty($muatan)? "/".$muatan: "").(!empty($transaksi)? "/".$transaksi: "")); 
        }else{
            echo "Terjadi kesalahan saat penyimpanan data timbang!<br>";
            echo "<pre>"; die(var_dump($data));
        }
    }      

    #=========================== Pakai Cangkang ===================================
    function pakai_cangkang_timbang_kedua(){
        $module_name  = $this->uri->segment(1);
        $otorisasi_id = $this->uri->segment(3);        
        $group_id     = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Pemakaian";
        $data['content']= "pemakaian/pakai_cangkang_timbang_kedua";
        
        $this->load->model('Model_t_otorisasi');
        $data['data_otorisasi'] = $this->Model_t_otorisasi->show_data_masuk($otorisasi_id)->row_array();
        
        $this->load->model('Model_t_timbang');
        $data['timbang1'] = $this->Model_t_timbang->get_data_timbang($otorisasi_id)->row_array(); 
            
        $this->load->view('layout', $data);
    }
    
    function save_pakai_cangkang_timbang_kedua(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $tgl_produksi = date('Y-m-d', strtotime($this->input->post('tanggal')));
        
        $berat2 = str_replace(".", "", $this->input->post('berat_timbang2'));
        $berat_kotor  = str_replace(".", "", $this->input->post('berat_kotor'));
        $berat_bersih = str_replace(".", "", $this->input->post('berat_bersih'));
        
        $data = array(
                        'berat2'=> $berat2,
                        'berat_kotor'=> $berat_kotor,  
                        'berat_bersih'=> $berat_bersih,  
                        'keterangan'=> $this->input->post('keterangan'), 
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
        $this->db->trans_start();
        
        $this->db->where('id', $this->input->post('timbang_id'));
        $this->db->update('t_timbang', $data);
        
        //Update data otorisasi, set status = Timbang 2
        $this->db->where('id', $this->input->post('otorisasi_id'));
        $this->db->update('t_otorisasi', array('status'=>3, 'modified'=>$tanggal, 'modified_by'=>$user_id));
        
        $input_tgl = date('Y-m-d');
        $this->load->model('Model_m_numberings');        

        //Save data ke tabel inventory
        //Lihat stok terakhir
        $this->load->model('Model_t_timbang');
        $get_stok = $this->Model_t_timbang->cek_stok('CANGKANG')->row_array(); 
        $stok_id  = $get_stok['id'];
        $stok     = $get_stok['stok']- $berat_bersih;

        #Update Stok Singkong ke tabel inventory
        $this->db->where('id', $stok_id);
        $this->db->update('t_inventory', array('stok'=>$stok, 'modified'=>$tanggal, 'modified_by'=>$user_id));

        #Save data ke tabel detail inventory
        $this->db->insert('t_inventory_detail', array(
            't_inventory_id'=>$stok_id,
            'tanggal'=>$tgl_produksi,
            'jumlah_keluar'=>$berat_bersih,
            'referensi_no'=>'Produksi tanggal '.$tgl_produksi
        ));

        #=======================Save Ongkos===============================
        $this->load->model('Model_m_biaya');
        $biaya = $this->Model_m_biaya->get_ongkos('PAKAI CANGKANG', 'Ongkos')->result();
        if($biaya){
            foreach ($biaya as $idx=>$value){
                $uraian_biaya = "Bayar uang ".$value->nama_biaya." agen <strong>";
                $uraian_biaya .= $this->input->post('nama_agen')."</strong> dengan nomor polisi <strong>".$this->input->post('no_kendaraan');
                $uraian_biaya .= "</strong> sebanyak ".number_format($berat_bersih,0,',','.');
                if($value->type_biaya=="Qty"){
                    $uraian_biaya .= " @Rp. ".number_format($value->jumlah,0,',','.')." = Rp. ";
                    $jumlah_biaya = $value->jumlah * $berat_bersih;
                    $uraian_biaya .= number_format($jumlah_biaya,0,',','.');
                }else{
                    $jumlah_biaya = $value->jumlah;
                    $uraian_biaya .= " = Rp. ".number_format($jumlah_biaya,0,',','.');
                }
                $uraian_biaya .= " pada tanggal <strong>".date('d/m/Y', strtotime($tanggal))."</strong> untuk proses produksi ";
                $uraian_biaya .= "tanggal <strong>".date('d/m/Y', strtotime($tgl_produksi))."</strong>";

                $this->db->insert('t_transaksi_bayar', array(
                    'tanggal'=>$input_tgl,
                    'no_nota'=>$this->Model_m_numberings->getNumbering('NDOKS', $input_tgl),
                    'm_kendaraan_id'=>$this->input->post('m_kendaraan_id'),
                    'm_agen_id'=>$this->input->post('m_agen_id'),
                    'supir'=>$this->input->post('supir'),
                    'jenis_barang'=>'CANGKANG',                        
                    'uraian'=>$uraian_biaya,
                    'total_harga'=>$jumlah_biaya,
                    'created'=>$tanggal,
                    'created_by'=>$user_id
                ));
            }
        }

        if($this->db->trans_complete()){   
            redirect('index.php/Pemakaian/index/CANGKANG/Pakai'); 
        }else{
            echo "Terjadi kesalahan saat penyimpanan data timbang!<br>";
            echo "<pre>"; die(var_dump($this->input->post()));
        }                   
    }     
    
    #=========================== Pakai Merah ===================================
    function pakai_merah_timbang_kedua(){
        $module_name  = $this->uri->segment(1);
        $otorisasi_id = $this->uri->segment(3);        
        $group_id     = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Pemakaian";
        $data['content']= "pemakaian/pakai_merah_timbang_kedua";
        
        $this->load->model('Model_t_otorisasi');
        $data['data_otorisasi'] = $this->Model_t_otorisasi->show_data_masuk($otorisasi_id)->row_array();
        
        $this->load->model('Model_t_timbang');
        $data['timbang1'] = $this->Model_t_timbang->get_data_timbang($otorisasi_id)->row_array(); 
            
        $this->load->view('layout', $data);
    }
    
    function save_pakai_merah_timbang_kedua(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $tgl_produksi = date('Y-m-d', strtotime($this->input->post('tanggal')));
        
        $berat2 = str_replace(".", "", $this->input->post('berat_timbang2'));
        $berat_kotor  = str_replace(".", "", $this->input->post('berat_kotor'));
        $berat_bersih = str_replace(".", "", $this->input->post('berat_bersih'));

        $data = array(
                        'berat2'=> $berat2,
                        'berat_kotor'=> $berat_kotor,   
                        'berat_bersih'=> $berat_bersih,  
                        'keterangan'=> $this->input->post('keterangan'), 
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );
        $this->db->trans_start();
        
        $this->db->where('id', $this->input->post('timbang_id'));
        $this->db->update('t_timbang', $data);
        
        //Update data otorisasi, set status = Timbang 2
        $this->db->where('id', $this->input->post('otorisasi_id'));
        $this->db->update('t_otorisasi', array('status'=>3, 'modified'=>$tanggal, 'modified_by'=>$user_id));
        

        //Save data ke tabel inventory
        //Lihat stok terakhir
        $this->load->model('Model_t_timbang');
        $get_stok = $this->Model_t_timbang->cek_stok('MERAH')->row_array(); 
        $stok_id  = $get_stok['id'];
        $stok     = $get_stok['stok']- $berat_bersih;

        #Update Stok Singkong ke tabel inventory
        $this->db->where('id', $stok_id);
        $this->db->update('t_inventory', array('stok'=>$stok, 'modified'=>$tanggal, 'modified_by'=>$user_id));

        #Save data ke tabel detail inventory
        $this->db->insert('t_inventory_detail', array(
            't_inventory_id'=>$stok_id,
            'tanggal'=>$tgl_produksi,
            'jumlah_keluar'=>$berat_bersih,
            'referensi_no'=>'Produksi tanggal '.$tgl_produksi
        ));                       

        if($this->db->trans_complete()){   
            redirect('index.php/Pemakaian/index/MERAH/Pakai'); 
        }else{
            echo "Terjadi kesalahan saat penyimpanan data timbang!<br>";
            echo "<pre>"; die(var_dump($this->input->post()));
        }
    }

}