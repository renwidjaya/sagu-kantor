<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelian extends CI_Controller{
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
        
        $data['judul']  = "Pembelian";
        $data['content']= "pembelian/index";
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
            if($transaksi=="Jual"){
                redirect('index.php/Penjualan/index/SAGU/Jual'); 
            }else{
                redirect('index.php/Pembelian/index'.(!empty($muatan)? "/".$muatan: "").(!empty($transaksi)? "/".$transaksi: "")); 
            }
        }else{
            echo "Terjadi kesalahan saat penyimpanan data timbang!<br>";
            echo "<pre>"; die(var_dump($data));
        }
    }
    
    function singkong_timbang_kedua(){
        $module_name  = $this->uri->segment(1);
        $otorisasi_id = $this->uri->segment(3);        
        $group_id     = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Pembelian";
        $data['content']= "pembelian/singkong_timbang_kedua";
        
        $this->load->model('Model_t_otorisasi');
        $data['data_otorisasi'] = $this->Model_t_otorisasi->show_data_masuk($otorisasi_id)->row_array();
        
        $agen = $data['data_otorisasi']['jenis_agen'];
        $this->load->model('Model_m_biaya');
        $get_harga = $this->Model_m_biaya->get_harga('PEMBELIAN SINGKONG', 'HARGA SINGKONG', 'Harga Item', 'jenis_agen='.$agen)->row_array();
        $data['harga_singkong'] = ($get_harga)? $get_harga['jumlah']: 0;
        
        $this->load->model('Model_t_timbang');
        $data['timbang1'] = $this->Model_t_timbang->get_data_timbang($otorisasi_id)->row_array(); 
            
        $this->load->view('layout', $data);
    }
    
    function save_singkong_timbang_kedua(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');

        $data = array(
                        'berat2'=> $this->input->post('berat_timbang2'),
                        'berat_kotor'=> str_replace(".", "", $this->input->post('berat_kotor')),  
                        'type_potongan'=> $this->input->post('type_potongan'), 
                        'refraksi_faktor'=> $this->input->post('refraksi_faktor'), 
                        'refraksi_value'=> $this->input->post('refraksi_value'), 
                        'berat_bersih'=> str_replace(".", "", $this->input->post('berat_bersih')), 
                        'harga'=> str_replace(".", "", $this->input->post('harga')), 
                        'total_harga'=> str_replace(".", "", $this->input->post('total_harga')), 
                        'qc01'=> $this->input->post('qc01'), 
                        'qc02'=> $this->input->post('qc02'), 
                        'qc03'=> $this->input->post('qc03'), 
                        'qc04'=> $this->input->post('qc04'), 
                        'qc05'=> $this->input->post('qc05'), 
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
        
        //Save ke tabel transaksi bayar
        $input_tgl = date('Y-m-d');
        $this->load->model('Model_m_numberings');
        $code = $this->Model_m_numberings->getNumbering('NDSKG', $input_tgl); 
        
        $uraian = "Pembelian Singkong ".$this->input->post('jenis_agen')." dari Agen <strong>";
        $uraian .= $this->input->post('nama_agen')."</strong> sebanyak ".number_format($this->input->post('berat_bersih'),0,',','.');
        $uraian .= " Kg menggunakan ".$this->input->post('type_kendaraan')." dengan nomor polisi <strong>".$this->input->post('no_kendaraan');
        $uraian .= "</strong> pada tanggal <strong>".date('d/m/Y', strtotime($tanggal))."</strong>";
        
        if($code){
            $this->db->insert('t_transaksi_bayar', array(
                'tanggal'=> $input_tgl,
                'no_nota'=> $code,
                'm_kendaraan_id'=> $this->input->post('m_kendaraan_id'),
                'm_agen_id'=> $this->input->post('m_agen_id'),
                'supir'=> $this->input->post('supir'),
                'jenis_barang'=> 'SINGKONG',
                'berat_bersih'=> str_replace(".", "", $this->input->post('berat_bersih')),
                'harga'=> str_replace(".", "", $this->input->post('harga')),
                'total_harga'=> str_replace(".", "", $this->input->post('total_harga')),
                't_timbang_id'=>$this->input->post('timbang_id'),
                'uraian'=> $uraian,
                'created'=> $tanggal,
                'created_by'=> $user_id,
                'modified'=> $tanggal,
                'modified_by'=> $user_id,
            )); 
            $reference_id = $this->db->insert_id();
            $netto    = str_replace(".", "", $this->input->post('berat_bersih'));
            
            #============================= Save ongkos ===============================
            $this->load->model('Model_m_biaya');
            $parameter = array('jenis_agen'=>$this->input->post('jenis_agen'), 
                            'type_kendaraan'=>$this->input->post('type_kendaraan'));
            $biaya = $this->Model_m_biaya->get_ongkos('PEMBELIAN SINGKONG', 'Ongkos', $parameter)->result();
            if($biaya){
                foreach ($biaya as $idx=>$value){
                    $uraian_biaya = "Bayar uang ".$value->nama_biaya." agen <strong>";
                    $uraian_biaya .= $this->input->post('nama_agen')."</strong> dengan nomor polisi <strong>".$this->input->post('no_kendaraan');
                    $uraian_biaya .= "</strong> sebanyak ".number_format($netto,0,',','.');
                    if($value->type_biaya=="Qty"){
                        $uraian_biaya .= " @Rp. ".number_format($value->jumlah,0,',','.')." = Rp. ";
                        $jumlah_biaya = $value->jumlah * $netto;
                        $uraian_biaya .= number_format($jumlah_biaya,0,',','.');
                    }else{
                        $jumlah_biaya = $value->jumlah;
                        $uraian_biaya .= " = Rp. ".number_format($jumlah_biaya,0,',','.');
                    }
                    $uraian_biaya .= " pada tanggal <strong>".date('d/m/Y', strtotime($tanggal))."</strong>";

                    $this->db->insert('t_transaksi_bayar', array(
                        'tanggal'=>$input_tgl,
                        'no_nota'=>$this->Model_m_numberings->getNumbering('NDOKS', $input_tgl),
                        'm_kendaraan_id'=> $this->input->post('m_kendaraan_id'),
                        'm_agen_id'=> $this->input->post('m_agen_id'),
                        'supir'=> $this->input->post('supir'),
                        'jenis_barang'=> 'SINGKONG',
                        'uraian'=>$uraian_biaya,
                        'total_harga'=>$jumlah_biaya,
                        't_timbang_id'=>$this->input->post('timbang_id'),
                        't_transaksi_bayar_id'=>$reference_id,
                        'created'=>$tanggal,
                        'created_by'=>$user_id
                    ));
                }
            }
            
            //Save data ke tabel inventory
            //Lihat stok terakhir
            $this->load->model('Model_t_timbang');
            $get_stok = $this->Model_t_timbang->cek_stok('SINGKONG')->row_array(); 
            $stok_id  = $get_stok['id'];            
            $stok     = $get_stok['stok']+ $netto;

            #Update Stok Singkong ke tabel inventory
            $this->db->where('id', $stok_id);
            $this->db->update('t_inventory', array('stok'=>$stok, 'modified'=>$tanggal, 'modified_by'=>$user_id));

            #Save data ke tabel detail inventory
            $this->db->insert('t_inventory_detail', array(
                't_inventory_id'=>$stok_id,
                'tanggal'=>$input_tgl,
                'jumlah_masuk'=>$netto,
                'referensi_name'=>'t_transaksi_bayar',
                'referensi_id'=>$reference_id
            ));
        }else{
            echo "Terjadi kesalahan saat menyimpan data!. Anda belum melakukan setup penomoran nota bayar.";
            echo "<pre>"; die(var_dump($this->input->post()));
        }        
        
        if($this->db->trans_complete()){    
            #Cetak Nota Bayar
            redirect('index.php/Pembelian/create_nota_bayar/'.$reference_id); 
        }else{
            echo "Terjadi kesalahan saat penyimpanan data timbang!<br>";
            echo "<pre>"; die(var_dump($this->input->post()));
        }
    }
    
    function create_nota_bayar(){
        $module_name  = $this->uri->segment(1);
        $group_id     = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Pembelian";
        $data['content']= "pembelian/create_nota_bayar";
        
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_t_timbang');
            $data['mydata'] = $this->Model_t_timbang->create_nota($id)->row_array();            
            $this->load->view('layout', $data);         
        }else{
            redirect('index.php/Pembelian'); 
        }
    }
    
    function print_nota(){
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_t_timbang');
            $data = $this->Model_t_timbang->create_nota($id)->row_array();
            //Generate nota bayar
            require('fpdf/fpdf.php');
            
            $pdf = new FPDF();
            $pdf->AliasNbPages();
            $pdf->AddPage();
            
            $pdf->SetFont('times','',8);
            $pdf->Cell(100,4,'PT. UNGGUL MEKAR SARI');
            $pdf->Cell(35);
            $pdf->SetFont('times','B',14);
            $pdf->Cell(100,8, $data['no_nota']);
            $pdf->SetFont('times','',8);
            $pdf->Ln(4);
            $pdf->Cell(100,4,'DESA BINA KARYA II');
            $pdf->Ln(4);
            $pdf->Cell(100,4,'KEC. RUMBIA');
            $pdf->Ln(4);
            $pdf->Cell(100,4,'LAMPUNG TENGAH');
            $pdf->Ln(4);
            $pdf->Cell(190,4,'=====================================================================================================================');
            $pdf->Ln(4);
            
            $pdf->Cell(70,4,'No. Mobil : '.$data['no_kendaraan']." -- ".$data['type_kendaraan']);
            $pdf->Cell(70,4,'Supplier : '.$data['nama_agen'].' (Agen '.$data['jenis_agen'].')');
            $pdf->Cell(50,4,'Muatan : '.$data['jenis_barang']);
            $pdf->Ln(4);
            $pdf->Cell(190,4,'=====================================================================================================================');
            $pdf->Ln(4);
            
            $pdf->Cell(20,4,'Timbang 1');
            $pdf->Cell(5,4,':');
            $pdf->Cell(20,4,number_format($data['berat1'],0,',','.'),0,0,'R');
            $pdf->Cell(5,4,'Kg');
            $pdf->Cell(20,4);
            $pdf->Cell(20,4, date('d/m/Y', strtotime($data['created'])));
            $pdf->Cell(20,4, date('h:m:s', strtotime($data['created'])));
            $pdf->Cell(10,4);
            if($data['jenis_agen']=="Lokal"){
                $pdf->Cell(20,4, 'Harga/ Kg');
                $pdf->Cell(10,4, ': Rp');
                $pdf->Cell(30,4, number_format($data['harga'],0,',','.'),0,0,'R');
            }
            $pdf->Ln(4);
            
            $pdf->Cell(20,4,'Timbang 2');
            $pdf->Cell(5,4,':');
            $pdf->Cell(20,4,number_format($data['berat2'],0,',','.'),0,0,'R');
            $pdf->Cell(5,4,'Kg');
            $pdf->Cell(20,4);
            $pdf->Cell(20,4, date('d/m/Y', strtotime($data['modified'])));
            $pdf->Cell(20,4, date('h:m:s', strtotime($data['modified'])));
            $pdf->Cell(10,4);
            if($data['jenis_agen']=="Lokal"){
                $pdf->Cell(20,4, 'Total Harga');
                $pdf->Cell(10,4, ': Rp');
                $pdf->Cell(30,4, number_format($data['total_harga'],0,',','.'),0,0,'R');
            }
            $pdf->Ln(4);
            
            $pdf->Cell(20,4,'');
            $pdf->Cell(5,4,'');
            $pdf->Cell(20,4,'-----------------------------');
            $pdf->Cell(5,4,'');
            $pdf->Ln(4);
            
            $pdf->Cell(20,4,'Netto');
            $pdf->Cell(5,4,':');
            $pdf->Cell(20,4,number_format($data['berat_kotor'],0,',','.'),0,0,'R');
            $pdf->Cell(5,4,'Kg');
            $pdf->Ln(4);
            
            $pdf->Cell(20,4,'Total Pot');
            $pdf->Cell(5,4,':');
            $pdf->Cell(20,4,number_format($data['refraksi_value'],0,',','.'),0,0,'R');
            $pdf->Cell(5,4,'Kg');
            $pdf->Cell(20,4);
            $pdf->Cell(50,4, 'Refraksi : '.$data['refraksi_faktor'].'  '.$data['type_potongan']);
            if($data['jenis_agen']=="Lokal"){
                $pdf->SetFont('times','',16);
                $pdf->Cell(20,4);
                $pdf->Cell(40,8, 'Rp.  '.number_format($data['total_harga'],0,',','.'),0,0,'R');
                $pdf->SetFont('times','',8);
            }
            $pdf->Ln(4);
            
            $pdf->Cell(20,4,'');
            $pdf->Cell(5,4,'');
            $pdf->Cell(20,4,'-----------------------------');
            $pdf->Cell(5,4,'');
            $pdf->Ln(4);
            
            $pdf->Cell(20,4,'Berat Bersih');
            $pdf->Cell(5,4,':');
            $pdf->Cell(20,4,number_format($data['berat_bersih'],0,',','.'),0,0,'R');
            $pdf->Cell(5,4,'Kg');
            $pdf->Ln(4);
            
            $pdf->Cell(190,4,'=====================================================================================================================');
            $pdf->Ln(4);
            
            $pdf->Cell(60,4,'Mengetahui',0,0,'C');
            $pdf->Cell(40,4);
            $pdf->Cell(100,4,'Juru Timbang',0,0,'C');
            $pdf->Ln(4);
            
            $pdf->Output('nota_bayar_'.$data['no_nota'].'.pdf', 'D');
            #$pdf->Output();         
        }else{
            redirect('index.php/Pembelian'); 
        }
    }
 
    function timbang_kedua(){
        $module_name  = $this->uri->segment(1);
        $otorisasi_id = $this->uri->segment(3);        
        $group_id     = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Pembelian";
        $data['content']= "pembelian/timbang_kedua";
        
        $this->load->model('Model_t_otorisasi');
        $data['data_otorisasi'] = $this->Model_t_otorisasi->show_data_masuk($otorisasi_id)->row_array(); 
        
        $this->load->model('Model_t_timbang');
        $data['timbang1'] = $this->Model_t_timbang->get_data_timbang($otorisasi_id)->row_array(); 
            
        $this->load->view('layout', $data);
    }
    
    function save_timbang_kedua(){
        $user_id   = $this->session->userdata('user_id');
        $tanggal   = date('Y-m-d h:m:s');
        $input_tgl = date('Y-m-d');
        $muatan   = $this->input->post('nama_muatan');
        
        $berat2 = str_replace(".", "", $this->input->post('berat_timbang2'));
        $berat_kotor  = str_replace(".", "", $this->input->post('berat_kotor'));
        $berat_bersih = str_replace(".", "", $this->input->post('berat_bersih'));

        $data = array(
                        'berat2'=> $berat2,
                        'berat_kotor'=> $berat_kotor,   
                        'berat_bersih'=> $berat_kotor,  
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
        $get_stok = $this->Model_t_timbang->cek_stok($muatan)->row_array(); 
        if($get_stok){
            $stok_id  = $get_stok['id'];            
            $stok     = $get_stok['stok']+ $berat_bersih;

            #Update Stok Singkong ke tabel inventory
            $this->db->where('id', $stok_id);
            $this->db->update('t_inventory', array('stok'=>$stok, 'modified'=>$tanggal, 'modified_by'=>$user_id));
        }else{
            $this->db->insert('t_inventory', array('nama_produk'=>$muatan, 'stok'=>$berat_bersih));
            $stok_id = $this->db->insert_id();
        }
        #Save data ke tabel detail inventory
        $this->db->insert('t_inventory_detail', array(
            't_inventory_id'=>$stok_id,
            'tanggal'=>$input_tgl,
            'jumlah_masuk'=>$berat_bersih,
        ));

        if($this->db->trans_complete()){    
            redirect('index.php/Pembelian/index/MATERIAL/Beli'); 
        }else{
            echo "Terjadi kesalahan saat penyimpanan data timbang!<br>";
            echo "<pre>"; die(var_dump($this->input->post()));
        }
    }
    
    function beli_cangkang_timbang_kedua(){
        $module_name  = $this->uri->segment(1);
        $otorisasi_id = $this->uri->segment(3);        
        $group_id     = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Pembelian";
        $data['content']= "pembelian/beli_cangkang_timbang_kedua";
        
        $this->load->model('Model_t_otorisasi');
        $data['data_otorisasi'] = $this->Model_t_otorisasi->show_data_masuk($otorisasi_id)->row_array();
        
        $this->load->model('Model_m_biaya');
        $get_harga = $this->Model_m_biaya->get_harga('PEMBELIAN CANGKANG', 'HARGA CANGKANG', 'Harga Item')->row_array();
        $data['harga_cangkang'] = ($get_harga)? $get_harga['jumlah']: 0;
        
        $this->load->model('Model_t_timbang');
        $data['timbang1'] = $this->Model_t_timbang->get_data_timbang($otorisasi_id)->row_array(); 
            
        $this->load->view('layout', $data);
    }
    
    function save_beli_cangkang_timbang_kedua(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $berat2 = str_replace(".", "", $this->input->post('berat_timbang2'));
        $berat_kotor  = str_replace(".", "", $this->input->post('berat_kotor'));
        $berat_bersih = str_replace(".", "", $this->input->post('berat_bersih'));
        $harga = str_replace(".", "", $this->input->post('harga'));
        $total_harga  = str_replace(".", "", $this->input->post('total_harga'));        
        
        $data = array(
                        'berat2'=> $berat2,
                        'berat_kotor'=> $berat_kotor,   
                        'berat_bersih'=> $berat_bersih, 
                        'harga'=> $harga, 
                        'total_harga'=> $total_harga,  
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
        
        //Save ke tabel transaksi bayar
        $input_tgl = date('Y-m-d');
        $this->load->model('Model_m_numberings');
        $code = $this->Model_m_numberings->getNumbering('NDCKG', $input_tgl); 
        
        $uraian = "Pembelian Cangkang ".$this->input->post('jenis_agen')." dari Agen <strong>";
        $uraian .= $this->input->post('nama_agen')."</strong> sebanyak ".number_format($berat_bersih,0,',','.');
        $uraian .= " Kg menggunakan ".$this->input->post('type_kendaraan')." dengan nomor polisi <strong>".$this->input->post('no_kendaraan');
        $uraian .= "</strong> pada tanggal <strong>".date('d/m/Y', strtotime($tanggal))."</strong>";
        
        if($code){
            $this->db->insert('t_transaksi_bayar', array(
                'tanggal'=> $input_tgl,
                'no_nota'=> $code,
                'm_kendaraan_id'=> $this->input->post('m_kendaraan_id'),
                'm_agen_id'=> $this->input->post('m_agen_id'),
                'supir'=> $this->input->post('supir'),
                'jenis_barang'=> 'CANGKANG',
                'berat_bersih'=> $berat_bersih,
                'harga'=> $harga,
                'total_harga'=> $total_harga,
                't_timbang_id'=>$this->input->post('timbang_id'),
                'uraian'=> $uraian,
                'created'=> $tanggal,
                'created_by'=> $user_id,
                'modified'=> $tanggal,
                'modified_by'=> $user_id,
            )); 
            $reference_id = $this->db->insert_id();
            
            //Save data ke tabel inventory
            //Lihat stok terakhir
            $this->load->model('Model_t_timbang');
            $get_stok = $this->Model_t_timbang->cek_stok('CANGKANG')->row_array(); 
            $stok_id  = $get_stok['id'];
            $netto    = str_replace(".", "", $this->input->post('berat_bersih'));
            $stok     = $get_stok['stok']+ $netto;

            #Update Stok Singkong ke tabel inventory
            $this->db->where('id', $stok_id);
            $this->db->update('t_inventory', array('stok'=>$stok, 'modified'=>$tanggal, 'modified_by'=>$user_id));

            #Save data ke tabel detail inventory
            $this->db->insert('t_inventory_detail', array(
                't_inventory_id'=>$stok_id,
                'tanggal'=>$input_tgl,
                'jumlah_masuk'=>$netto,
                'referensi_name'=>'t_transaksi_bayar',
                'referensi_id'=>$reference_id,
                'referensi_no'=>$code
            ));
            
            #==========================  Save ongkos ================================
            $this->load->model('Model_m_biaya');
            #$parameter = array('jenis_agen'=>$this->input->post('jenis_agen'), 
            #                'type_kendaraan'=>$this->input->post('type_kendaraan'));
            $biaya = $this->Model_m_biaya->get_ongkos('PEMBELIAN CANGKANG', 'Ongkos')->result();
            if($biaya){
                foreach ($biaya as $idx=>$value){
                    $uraian_biaya = "Bayar uang ".$value->nama_biaya." agen <strong>";
                    $uraian_biaya .= $this->input->post('nama_agen')."</strong> dengan nomor polisi <strong>".$this->input->post('no_kendaraan');
                    $uraian_biaya .= "</strong> sebanyak ".number_format($netto,0,',','.');
                    if($value->type_biaya=="Qty"){
                        $uraian_biaya .= " @Rp. ".number_format($value->jumlah,0,',','.')." = Rp. ";
                        $jumlah_biaya = $value->jumlah * $netto;
                        $uraian_biaya .= number_format($jumlah_biaya,0,',','.');
                    }else{
                        $jumlah_biaya = $value->jumlah;
                        $uraian_biaya .= " = Rp. ".number_format($jumlah_biaya,0,',','.');
                    }
                    $uraian_biaya .= " pada tanggal <strong>".date('d/m/Y', strtotime($tanggal))."</strong>";

                    $this->db->insert('t_transaksi_bayar', array(
                        'tanggal'=>$input_tgl,
                        'no_nota'=>$this->Model_m_numberings->getNumbering('NDOKS', $input_tgl),
                        'm_kendaraan_id'=>$this->input->post('m_kendaraan_id'),
                        'm_agen_id'=>$this->input->post('m_agen_id'),
                        'supir'=>$this->input->post('supir'),
                        'jenis_barang'=>'CANGKANG',
                        'uraian'=>$uraian_biaya,
                        'total_harga'=>$jumlah_biaya,
                        't_timbang_id'=>$this->input->post('timbang_id'),
                        't_transaksi_bayar_id'=>$reference_id,
                        'created'=>$tanggal,
                        'created_by'=>$user_id
                    ));
                }
            }
            
            if($this->db->trans_complete()){    
            #Cetak Nota Bayar
            redirect('index.php/Pembelian/create_nota_cangkang/'.$reference_id); 
            }else{
                echo "Terjadi kesalahan saat penyimpanan data timbang!<br>";
                echo "<pre>"; die(var_dump($this->input->post()));
            }
        }else{
            echo "Terjadi kesalahan saat menyimpan data!. Anda belum melakukan setup penomoran nota bayar.";
            echo "<pre>"; die(var_dump($this->input->post()));
        }                
    }
    
    function create_nota_cangkang(){
        $module_name  = $this->uri->segment(1);
        $group_id     = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Pembelian";
        $data['content']= "pembelian/create_nota_cangkang";
        
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_t_timbang');
            $data['mydata'] = $this->Model_t_timbang->create_nota($id)->row_array();            
            $this->load->view('layout', $data);         
        }else{
            redirect('index.php/Pembelian'); 
        }
    }
    
    function print_nota_cangkang(){
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_t_timbang');
            $data = $this->Model_t_timbang->create_nota($id)->row_array();
            //Generate nota bayar
            require('fpdf/fpdf.php');
            
            $pdf = new FPDF();
            $pdf->AliasNbPages();
            $pdf->AddPage();
            
            $pdf->SetFont('times','',8);
            $pdf->Cell(100,4,'PT. UNGGUL MEKAR SARI');
            $pdf->Cell(35);
            $pdf->SetFont('times','B',14);
            $pdf->Cell(100,8, $data['no_nota']);
            $pdf->SetFont('times','',8);
            $pdf->Ln(4);
            $pdf->Cell(100,4,'DESA BINA KARYA II');
            $pdf->Ln(4);
            $pdf->Cell(100,4,'KEC. RUMBIA');
            $pdf->Ln(4);
            $pdf->Cell(100,4,'LAMPUNG TENGAH');
            $pdf->Ln(4);
            $pdf->Cell(190,4,'=====================================================================================================================');
            $pdf->Ln(4);
            
            $pdf->Cell(70,4,'No. Mobil : '.$data['no_kendaraan']." -- ".$data['type_kendaraan']);
            $pdf->Cell(70,4,'Supplier : '.$data['nama_agen'].' (Agen '.$data['jenis_agen'].')');
            $pdf->Cell(50,4,'Muatan : '.$data['jenis_barang']);
            $pdf->Ln(4);
            $pdf->Cell(190,4,'=====================================================================================================================');
            $pdf->Ln(4);
            
            $pdf->Cell(20,4,'Timbang 1');
            $pdf->Cell(5,4,':');
            $pdf->Cell(20,4,number_format($data['berat1'],0,',','.'),0,0,'R');
            $pdf->Cell(5,4,'Kg');
            $pdf->Cell(20,4);
            $pdf->Cell(20,4, date('d/m/Y', strtotime($data['created'])));
            $pdf->Cell(20,4, date('h:m:s', strtotime($data['created'])));
            $pdf->Cell(10,4);
            $pdf->Cell(20,4, 'Harga/ Kg');
            $pdf->Cell(10,4, ': Rp');
            $pdf->Cell(30,4, number_format($data['harga'],0,',','.'),0,0,'R');

            $pdf->Ln(4);
            
            $pdf->Cell(20,4,'Timbang 2');
            $pdf->Cell(5,4,':');
            $pdf->Cell(20,4,number_format($data['berat2'],0,',','.'),0,0,'R');
            $pdf->Cell(5,4,'Kg');
            $pdf->Cell(20,4);
            $pdf->Cell(20,4, date('d/m/Y', strtotime($data['modified'])));
            $pdf->Cell(20,4, date('h:m:s', strtotime($data['modified'])));
            $pdf->Cell(10,4);
            $pdf->Cell(20,4, 'Total Harga');
            $pdf->Cell(10,4, ': Rp');
            $pdf->Cell(30,4, number_format($data['total_harga'],0,',','.'),0,0,'R');

            $pdf->Ln(4);
            
            $pdf->Cell(20,4,'');
            $pdf->Cell(5,4,'');
            $pdf->Cell(20,4,'-----------------------------');
            $pdf->Cell(5,4,'');
            $pdf->Ln(4);
            
            $pdf->Cell(20,4,'Netto');
            $pdf->Cell(5,4,':');
            $pdf->Cell(20,4,number_format($data['berat_kotor'],0,',','.'),0,0,'R');
            $pdf->Cell(5,4,'Kg');
            $pdf->Ln(4);
            
            $pdf->Cell(120);           
            $pdf->SetFont('times','',16);
            $pdf->Cell(60,8, 'Rp.  '.number_format($data['total_harga'],0,',','.'),0,0,'R');
            $pdf->SetFont('times','',8);
            $pdf->Ln(12);

            
            $pdf->Cell(190,4,'=====================================================================================================================');
            $pdf->Ln(4);
            
            $pdf->Cell(60,4,'Mengetahui',0,0,'C');
            $pdf->Cell(40,4);
            $pdf->Cell(100,4,'Juru Timbang',0,0,'C');
            $pdf->Ln(4);
            
            #$pdf->Output('nota_bayar_'.$data['no_nota'].'.pdf', 'D');
            $pdf->Output();         
        }else{
            redirect('index.php/Pembelian'); 
        }
    }

    #=========================== Beli Merah ===================================
    function beli_merah_timbang_kedua(){
        $module_name  = $this->uri->segment(1);
        $otorisasi_id = $this->uri->segment(3);        
        $group_id     = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Pembelian";
        $data['content']= "pembelian/beli_merah_timbang_kedua";
        
        $this->load->model('Model_t_otorisasi');
        $data['data_otorisasi'] = $this->Model_t_otorisasi->show_data_masuk($otorisasi_id)->row_array();        
        
        $this->load->model('Model_t_timbang');
        $data['timbang1'] = $this->Model_t_timbang->get_data_timbang($otorisasi_id)->row_array(); 
        
        $this->load->model('Model_m_biaya');
        $get_harga = $this->Model_m_biaya->get_harga('PEMBELIAN MERAH', 'HARGA MERAH', 'Harga Item')->row_array();
        $data['harga_merah'] = ($get_harga)? $get_harga['jumlah']: 0;
            
        $this->load->view('layout', $data);
    }
    
    function save_beli_merah_timbang_kedua(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');

        $data = array(
                        'berat2'=> $this->input->post('berat_timbang2'),
                        'berat_kotor'=> $this->input->post('berat_kotor'),  
                        'berat_bersih'=> $this->input->post('berat_bersih'), 
                        'harga'=> $this->input->post('harga'), 
                        'total_harga'=> $this->input->post('total_harga'), 
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
        
        //Save ke tabel transaksi bayar
        $input_tgl = date('Y-m-d');
        $this->load->model('Model_m_numberings');
        $code = $this->Model_m_numberings->getNumbering('NDMRH', $input_tgl); 
        
        $uraian = "Pembelian Merah (Solar) ".$this->input->post('jenis_agen')." dari Agen <strong>";
        $uraian .= $this->input->post('nama_agen')."</strong> sebanyak ".number_format($this->input->post('berat_bersih'),0,',','.');
        $uraian .= " Kg menggunakan ".$this->input->post('type_kendaraan')." dengan nomor polisi <strong>".$this->input->post('no_kendaraan');
        $uraian .= "</strong> pada tanggal <strong>".date('d/m/Y', strtotime($tanggal))."</strong>";
        
        if($code){
            $this->db->insert('t_transaksi_bayar', array(
                'tanggal'=> $input_tgl,
                'no_nota'=> $code,
                'm_kendaraan_id'=> $this->input->post('m_kendaraan_id'),
                'm_agen_id'=> $this->input->post('m_agen_id'),
                'supir'=> $this->input->post('supir'),
                'jenis_barang'=> 'MERAH',
                'berat_bersih'=> str_replace(".", "", $this->input->post('berat_bersih')),
                'harga'=> str_replace(".", "", $this->input->post('harga')),
                'total_harga'=> str_replace(".", "", $this->input->post('total_harga')),
                't_timbang_id'=>$this->input->post('timbang_id'),
                'uraian'=> $uraian,
                'created'=> $tanggal,
                'created_by'=> $user_id,
                'modified'=> $tanggal,
                'modified_by'=> $user_id,
            )); 
            $reference_id = $this->db->insert_id();
            
            //Save data ke tabel inventory
            //Lihat stok terakhir
            $this->load->model('Model_t_timbang');
            $get_stok = $this->Model_t_timbang->cek_stok('MERAH')->row_array(); 
            $stok_id  = $get_stok['id'];
            $netto    = str_replace(".", "", $this->input->post('berat_bersih'));
            $stok     = $get_stok['stok']+ $netto;

            #Update Stok Singkong ke tabel inventory
            $this->db->where('id', $stok_id);
            $this->db->update('t_inventory', array('stok'=>$stok, 'modified'=>$tanggal, 'modified_by'=>$user_id));

            #Save data ke tabel detail inventory
            $this->db->insert('t_inventory_detail', array(
                't_inventory_id'=>$stok_id,
                'tanggal'=>$input_tgl,
                'jumlah_masuk'=>$netto,
                'referensi_name'=>'t_transaksi_bayar',
                'referensi_id'=>$reference_id,
                'referensi_no'=>$code
            ));
            
            #============================ Save Ongkos =================================
            $this->load->model('Model_m_biaya');
            #$parameter = array('jenis_agen'=>$this->input->post('jenis_agen'), 
            #                'type_kendaraan'=>$this->input->post('type_kendaraan'));
            $biaya = $this->Model_m_biaya->get_ongkos('PEMBELIAN MERAH', 'Ongkos')->result();
            if($biaya){
                foreach ($biaya as $idx=>$value){
                    $uraian_biaya = "Bayar uang ".$value->nama_biaya." agen <strong>";
                    $uraian_biaya .= $this->input->post('nama_agen')."</strong> dengan nomor polisi <strong>".$this->input->post('no_kendaraan');
                    $uraian_biaya .= "</strong> sebanyak ".number_format($netto,0,',','.');
                    if($value->type_biaya=="Qty"){
                        $uraian_biaya .= " @Rp. ".number_format($value->jumlah,0,',','.')." = Rp. ";
                        $jumlah_biaya = $value->jumlah * $netto;
                        $uraian_biaya .= number_format($jumlah_biaya,0,',','.');
                    }else{
                        $jumlah_biaya = $value->jumlah;
                        $uraian_biaya .= " = Rp. ".number_format($jumlah_biaya,0,',','.');
                    }
                    $uraian_biaya .= " pada tanggal <strong>".date('d/m/Y', strtotime($tanggal))."</strong>";

                    $this->db->insert('t_transaksi_bayar', array(
                        'tanggal'=>$input_tgl,
                        'no_nota'=>$this->Model_m_numberings->getNumbering('NDOKS', $input_tgl),
                        'm_kendaraan_id'=>$this->input->post('m_kendaraan_id'),
                        'm_agen_id'=>$this->input->post('m_agen_id'),
                        'supir'=>$this->input->post('supir'),
                        'jenis_barang'=>'MERAH',
                        'uraian'=>$uraian_biaya,
                        'total_harga'=>$jumlah_biaya,
                        't_transaksi_bayar_id'=>$reference_id,
                        'created'=>$tanggal,
                        'created_by'=>$user_id
                    ));
                }
            }

            if($this->db->trans_complete()){    
                redirect('index.php/Pembelian/create_nota_merah/'.$reference_id); 
            }else{
                echo "Terjadi kesalahan saat penyimpanan data timbang!<br>";
                echo "<pre>"; die(var_dump($this->input->post()));
            }

        }else{
            echo "Terjadi kesalahan saat menyimpan data!. Anda belum melakukan setup penomoran nota bayar.";
            echo "<pre>"; die(var_dump($this->input->post()));
        }        
    }
    
    function create_nota_merah(){
        $module_name  = $this->uri->segment(1);
        $group_id     = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Pembelian";
        $data['content']= "pembelian/create_nota_merah";
        
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_t_timbang');
            $data['mydata'] = $this->Model_t_timbang->create_nota($id)->row_array();            
            $this->load->view('layout', $data);         
        }else{
            redirect('index.php/Pembelian'); 
        }
    }
    
    function print_nota_merah(){
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_t_timbang');
            $data = $this->Model_t_timbang->create_nota($id)->row_array();
            //Generate nota bayar
            require('fpdf/fpdf.php');
            
            $pdf = new FPDF();
            $pdf->AliasNbPages();
            $pdf->AddPage();
            
            $pdf->SetFont('times','',8);
            $pdf->Cell(100,4,'PT. UNGGUL MEKAR SARI');
            $pdf->Cell(35);
            $pdf->SetFont('times','B',14);
            $pdf->Cell(100,8, $data['no_nota']);
            $pdf->SetFont('times','',8);
            $pdf->Ln(4);
            $pdf->Cell(100,4,'DESA BINA KARYA II');
            $pdf->Ln(4);
            $pdf->Cell(100,4,'KEC. RUMBIA');
            $pdf->Ln(4);
            $pdf->Cell(100,4,'LAMPUNG TENGAH');
            $pdf->Ln(4);
            $pdf->Cell(190,4,'=====================================================================================================================');
            $pdf->Ln(4);
            
            $pdf->Cell(70,4,'No. Mobil : '.$data['no_kendaraan']." -- ".$data['type_kendaraan']);
            $pdf->Cell(70,4,'Supplier : '.$data['nama_agen'].' (Agen '.$data['jenis_agen'].')');
            $pdf->Cell(50,4,'Muatan : '.$data['jenis_barang']);
            $pdf->Ln(4);
            $pdf->Cell(190,4,'=====================================================================================================================');
            $pdf->Ln(4);
            
            $pdf->Cell(20,4,'Timbang 1');
            $pdf->Cell(5,4,':');
            $pdf->Cell(20,4,number_format($data['berat1'],0,',','.'),0,0,'R');
            $pdf->Cell(5,4,'Kg');
            $pdf->Cell(20,4);
            $pdf->Cell(20,4, date('d/m/Y', strtotime($data['created'])));
            $pdf->Cell(20,4, date('h:m:s', strtotime($data['created'])));  
            $pdf->Ln(4);
            
            $pdf->Cell(20,4,'Timbang 2');
            $pdf->Cell(5,4,':');
            $pdf->Cell(20,4,number_format($data['berat2'],0,',','.'),0,0,'R');
            $pdf->Cell(5,4,'Kg');
            $pdf->Cell(20,4);
            $pdf->Cell(20,4, date('d/m/Y', strtotime($data['modified'])));
            $pdf->Cell(20,4, date('h:m:s', strtotime($data['modified'])));
            $pdf->Ln(4);
            
            $pdf->Cell(20,4,'');
            $pdf->Cell(5,4,'');
            $pdf->Cell(20,4,'-----------------------------');
            $pdf->Cell(5,4,'');
            $pdf->Ln(4);
            
            $pdf->Cell(20,4,'Netto');
            $pdf->Cell(5,4,':');
            $pdf->Cell(20,4,number_format($data['berat_kotor'],0,',','.'),0,0,'R');
            $pdf->Cell(5,4,'Kg');
            $pdf->Ln(4);
            
            $pdf->Cell(190,4,'=====================================================================================================================');
            $pdf->Ln(4);
            
            $pdf->Cell(60,4,'Mengetahui',0,0,'C');
            $pdf->Cell(40,4);
            $pdf->Cell(100,4,'Juru Timbang',0,0,'C');
            $pdf->Ln(4);
            
            $pdf->Output('nota_bayar_'.$data['no_nota'].'.pdf', 'D');
            #$pdf->Output();         
        }else{
            redirect('index.php/Pembelian'); 
        }
    }

    function sagu_timbang_kedua(){
        $module_name  = $this->uri->segment(1);
        $otorisasi_id = $this->uri->segment(3);        
        $group_id     = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "TTimbang";
        $data['content']= "t_timbang/sagu_timbang_kedua";
        
        $this->load->model('Model_t_otorisasi');
        $data['data_otorisasi'] = $this->Model_t_otorisasi->otorisasi_sagu($otorisasi_id)->row_array();
        $delivery_id = $data['data_otorisasi']['t_delivery_order_id'];
        
        $data['mydetail'] = $this->Model_t_otorisasi->data_detail_delivery($delivery_id)->result();
        $berat = 0;
        foreach ($data['mydetail']as $idx=>$value){
            $berat += $value->sak * $value->jumlah_sak;
        }
        $data['berat'] = $berat;        
        $this->load->model('Model_t_timbang');
        $data['timbang1'] = $this->Model_t_timbang->get_data_timbang($otorisasi_id)->row_array(); 
            
        $this->load->view('layout', $data);
    }
    
    function save_sagu_timbang_kedua(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');

        $data = array(
                        'berat2'=> $this->input->post('berat_timbang2'),
                        'berat_kotor'=> $this->input->post('berat_kotor'),  
                        'type_potongan'=> $this->input->post('type_potongan'), 
                        'refraksi_faktor'=> $this->input->post('refraksi_faktor'), 
                        'refraksi_value'=> $this->input->post('refraksi_value'), 
                        'berat_bersih'=> $this->input->post('berat_bersih'), 
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
        
        //Update tabel delivery order
        $this->db->where('id', $this->input->post('t_delivery_order_id'));
        $this->db->update('t_delivery_order', array(
            'total_order_dikirim'=>str_replace(".", "", $this->input->post('harga_dikirim')),
            'flag_kirim'=>1,
            'modified'=>$tanggal, 
            'modified_by'=>$user_id
        ));
        
        //Update tabel delivery order detail
        $detail = $this->input->post('detail');
        $parameter_ongkos = array();
        $parameter_ongkos['25']= 0;
        $parameter_ongkos['50']= 0;
        
        foreach ($detail as $key=>$value){
            $this->db->where('id', $value['tod_id']);
                $this->db->update('t_delivery_order_detail', array(
                    'jumlah_dikirim'=>str_replace(".", "", $value['jumlah_dikirim']),
                    'total_harga_dikirim'=>str_replace(".", "", $value['total_harga2']),
                    'catatan'=>$value['catatan'],
                    'modified'=>$tanggal, 
                    'modified_by'=>$user_id
                ));
            if($value['sak']==25){
                $parameter_ongkos['25']+= $value['jumlah_dikirim'];
            }else{
                $parameter_ongkos['50'] += $value['jumlah_dikirim'];
            }
        }

        //Save ke tabel transaksi jual
        $input_tgl = date('Y-m-d');
        $this->load->model('Model_m_numberings');
        $code = $this->Model_m_numberings->getNumbering('INVSG', $input_tgl); 
        
        $uraian = "Penjualan Sagu ke Customer <strong>".$this->input->post('nama_customer')."</strong> ";
        $uraian .= "sebesar Rp. ".$this->input->post('harga_dikirim');
        $uraian .= " untuk total order ".$this->input->post('berat_dikirim');
        $uraian .= " Kg, dengan No.Delivery Order <strong>".$this->input->post('no_delivery_order')."</strong>";
        $uraian .= " ke <strong>".$this->input->post('nama_cv')."</strong>";
        $uraian .= " menggunakan ekspedisi ".$this->input->post('nama_ekspedisi')." dengan nomor polisi <strong>".$this->input->post('no_kendaraan');
        $uraian .= "</strong> pada tanggal <strong>".date('d/m/Y', strtotime($tanggal))."</strong>";
        
        if($code){
            $this->db->insert('t_transaksi_jual', array(
                'tanggal'=> $input_tgl,
                'no_nota'=> $code,
                'm_kendaraan_id'=> $this->input->post('m_kendaraan_id'),
                'm_customer_id'=> $this->input->post('m_customer_id'),
                'm_ekspedisi_id'=> $this->input->post('m_ekspedisi_id'),
                'supir'=> $this->input->post('supir'),
                'm_cv_id'=> $this->input->post('m_cv_id'),
                't_delivery_order_id'=> $this->input->post('t_delivery_order_id'),
                'jenis_barang'=> 'SAGU',
                'jumlah'=> str_replace(".", "", $this->input->post('harga_dikirim')),
                't_timbang_id'=>$this->input->post('timbang_id'),
                'uraian'=> $uraian,
                'created'=> $tanggal,
                'created_by'=> $user_id,
                'modified'=> $tanggal,
                'modified_by'=> $user_id,
            )); 
            $reference_id = $this->db->insert_id();
            
            $this->load->model('Model_t_timbang');
            
            
            
            foreach ($detail as $key=>$value){
                $get_stok = $this->Model_t_timbang->cek_stok('SAGU '.$value['merek'], $this->input->post('m_cv_id'), $value['sak'])->row_array(); 
                $stok_id  = $get_stok['id'];
                $netto    = $value['jumlah_dikirim'] * $value['sak'];
                $stok     = $get_stok['stok']- $netto;

                $this->db->where('id', $stok_id);
                $this->db->update('t_inventory', array('stok'=>$stok, 
                                'modified'=>$tanggal, 'modified_by'=>$user_id));

                #Save data ke tabel detail inventory
                $this->db->insert('t_inventory_detail', array(
                    't_inventory_id'=>$stok_id,
                    'tanggal'=>$input_tgl,
                    'jumlah_keluar'=>$netto,
                    'referensi_name'=>'t_transaksi_jual',
                    'referensi_id'=>$reference_id,
                    'referensi_no'=>$this->input->post('no_delivery_order'),
                ));                  
            }                       
            
            #==================================  Save ongkos  =============================
            $this->load->model('Model_m_biaya');
            foreach ($parameter_ongkos as $key=>$val){
                if($val>0){
                    $biaya = $this->Model_m_biaya->get_ongkos('PENJUALAN SAGU', 'Ongkos', array('sak'=>$key))->result();
                    if($biaya){
                        foreach ($biaya as $idx=>$value){
                            $uraian_biaya = "Bayar uang ".$value->nama_biaya." untuk customer <strong>".$this->input->post('nama_customer')."</strong> ";
                            $uraian_biaya .= " dengan No.Delivery Order <strong>".$this->input->post('no_delivery_order')."</strong>";
                            $uraian_biaya .= " ke <strong>".$this->input->post('nama_cv')."</strong>";
                            $uraian_biaya .= " menggunakan ekspedisi ".$this->input->post('nama_ekspedisi');
                            $uraian_biaya .= " dengan nomor polisi <strong>".$this->input->post('no_kendaraan');
                            $uraian_biaya .= "</strong> pada tanggal <strong>".date('d/m/Y', strtotime($tanggal))."</strong>";
                            $uraian_biaya .= " sebanyak ".number_format($val,0,',','.');

                            if($value->type_biaya=="Qty"){
                                $uraian_biaya .= " @Rp. ".number_format($value->jumlah,0,',','.')." = Rp. ";
                                $jumlah_biaya = $value->jumlah * $val;
                                $uraian_biaya .= number_format($jumlah_biaya,0,',','.');
                            }else{
                                $jumlah_biaya = $value->jumlah;
                                $uraian_biaya .= " = Rp. ".number_format($jumlah_biaya,0,',','.');
                            }

                            $this->db->insert('t_biaya', array(
                                'tanggal'=>$input_tgl,
                                'uraian'=>$uraian_biaya,
                                'jumlah'=>$jumlah_biaya,
                                'no_referensi'=>$code,
                                'created'=>$tanggal,
                                'created_by'=>$user_id
                            ));
                        }
                    }
                }
            }
            
            if($this->db->trans_complete()){    
                redirect('index.php/TTimbang/index/SAGU/Jual'); 
            }else{
                echo "Terjadi kesalahan saat penyimpanan data timbang!<br>";
                echo "<pre>"; die(var_dump($this->input->post()));
            }
        }else{
            echo "Terjadi kesalahan saat menyimpan data!. Anda belum melakukan setup penomoran nota jual.";
            echo "<pre>"; die(var_dump($this->input->post()));
        }

    }
}