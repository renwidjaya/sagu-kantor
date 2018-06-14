<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan extends CI_Controller{
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
        
        $data['judul']  = "Penjualan";
        $data['content']= "penjualan/index";
        $this->load->model('Model_t_timbang');
        $data['list_data'] = $this->Model_t_timbang->list_otorisasi_sagu($muatan, $transaksi)->result();
        
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
            
            redirect('index.php/Penjualan/index/SAGU/Jual');             
        }else{
            echo "Terjadi kesalahan saat penyimpanan data timbang!<br>";
            echo "<pre>"; die(var_dump($data));
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
        
        $data['judul']  = "Penjualan";
        $data['content']= "penjualan/sagu_timbang_kedua";
        
        $this->load->model('Model_t_otorisasi');
        $data['data_otorisasi'] = $this->Model_t_otorisasi->otorisasi_sagu($otorisasi_id)->row_array();   
        $data['muatan'] = $this->Model_t_otorisasi->show_produk($otorisasi_id)->result();

        $this->load->model('Model_t_timbang');
        $data['timbang1'] = $this->Model_t_timbang->get_data_timbang($otorisasi_id)->row_array(); 
            
        $this->load->view('layout', $data);
    }
    
    function save_sagu_timbang_kedua(){
        $user_id   = $this->session->userdata('user_id');
        $tanggal   = date('Y-m-d h:m:s');  
        $input_tgl = date('Y-m-d'); 

        $berat1 = str_replace(".", "", $this->input->post('berat_timbang1'));
        $berat2 = str_replace(".", "", $this->input->post('berat_timbang2'));
        $berat_kotor = str_replace(".", "", $this->input->post('berat_kotor'));
        $old_berat1  = str_replace(".", "", $this->input->post('old_berat1'));
        $status = $this->input->post('status');
        
        #echo "<pre>"; die(var_dump($this->input->post()));
        
        $this->db->trans_start();
        
        $this->db->where('id', $this->input->post('timbang_id'));
        if($status==2){
            $this->db->update('t_timbang', array(
                'berat2'=> $berat2,
                'berat_kotor'=> $berat_kotor,  
                'berat_bersih'=> $berat_kotor, 
                'modified'=> $tanggal,
                'modified_by'=> $user_id,
            ));
        }else{
            $this->db->update('t_timbang', array(
                'berat1'=>$berat1,
                'berat2'=> $berat2,
                'berat_kotor'=> $berat_kotor,  
                'berat_bersih'=> $berat_kotor, 
                'modified'=> $tanggal,
                'modified_by'=> $user_id,
            ));
        }
        
        $produk = $this->input->post('detail');
        foreach ($produk as $index=>$value){
            if(isset($value['check']) && $value['check']==1){
                $this->db->where('id', $value['id']);
                $this->db->update('t_otorisasi_muatan', array(
                    'berat1'=> $berat1,
                    'berat2'=> $berat2,  
                    'flag_timbang'=> 1, 
                ));
            }
        }
        
        $this->load->model('Model_t_otorisasi');
        $cek_muatan = $this->Model_t_otorisasi->cek_muatan($this->input->post('otorisasi_id'))->result();
        if($cek_muatan){
            #Masih ada muatan            
            
            //Update data otorisasi, set status = Timbang 2
            $this->db->where('id', $this->input->post('otorisasi_id'));
            $this->db->update('t_otorisasi', array('status'=>3,
                'deskripsi'=>$this->input->post('nama_muatan'),
                'modified'=>$tanggal, 
                'modified_by'=>$user_id));
        }else{
            #Selesai timbang, sudah tidak ada muatan
            
            //Create DO Pabrik
            $this->load->model('Model_m_numberings');
            $code = $this->Model_m_numberings->getNumbering('DO.PBRK', $input_tgl); 
            
            $this->db->insert('t_delivery_order', array(
                'tanggal'=>$input_tgl,
                'no_delivery_order'=>$code,
                'm_agen_id'=>$this->input->post('m_agen_id'),
                'created'=>$tanggal,
                'created_by'=>$user_id,
                'modified'=>$tanggal,
                'modified_by'=>$user_id
            ));            
            $do_id = $this->db->insert_id();
            
            //Insert ke Tabel Delivery Order Detail
            $this->load->model('Model_m_biaya');
            $produks = $this->Model_t_otorisasi->show_produk($this->input->post('otorisasi_id'))->result();
            
            $parameter_ongkos = array();
            $parameter_ongkos['25']= 0;
            $parameter_ongkos['50']= 0;
            
            $sum_berat = 0;
            $sum_harga = 0;
            
            $this->load->model('Model_t_timbang');
        
            foreach ($produks as $key=>$val){
                $get_harga = $this->Model_m_biaya->get_harga('Penjualan', 'HARGA SAGU '.$val->type_produk, 'Harga Item', 'sak='.$val->sak)->row_array();
                $total_harga = $get_harga['jumlah']* $val->jumlah;
                
                $sum_harga += $total_harga;
                $sum_berat += $val->jumlah * $val->sak;
                
                $this->db->insert('t_delivery_order_detail', array(
                    't_delivery_order_id'=>$do_id,
                    'merek'=>$val->type_produk,
                    'sak'=>$val->sak,
                    'jumlah_sak'=>$val->jumlah,
                    'harga'=>$get_harga['jumlah'],
                    'total_harga'=>$total_harga,
                    'created'=>$tanggal,
                    'created_by'=>$user_id,
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id
                ));
                
                if($val->sak==25){
                    $parameter_ongkos['25']+= $val->jumlah;
                }else{
                    $parameter_ongkos['50'] += $val->jumlah;
                }
                
                //Update tabel inventory
                $get_stok = $this->Model_t_timbang->cek_stok('SAGU '.$val->type_produk, $val->sak)->row_array(); 
                $stok_id  = $get_stok['id'];
                $netto    = $val->jumlah * $val->sak;
                $stok     = $get_stok['stok']- $netto;

                $this->db->where('id', $stok_id);
                $this->db->update('t_inventory', array('stok'=>$stok, 
                                'modified'=>$tanggal, 'modified_by'=>$user_id));

                #Save data ke tabel detail inventory
                $this->db->insert('t_inventory_detail', array(
                    't_inventory_id'=>$stok_id,
                    'tanggal'=>$input_tgl,
                    'jumlah_keluar'=>$netto,
                    'referensi_name'=>'t_delivery_order',
                    'referensi_id'=>$do_id,
                    'referensi_no'=>$code,
                ));  
            }
            
            //Update data otorisasi, set status = Timbang 2
            $this->db->where('id', $this->input->post('otorisasi_id'));
            $this->db->update('t_otorisasi', array(
                'status'=>3,
                'deskripsi'=>$this->input->post('nama_muatan'),
                'finish_timbang'=>1,
                't_delivery_order_id'=>$do_id,
                'modified'=>$tanggal, 
                'modified_by'=>$user_id));
            
            //Save ke tabel transaksi jual                    
            $uraian = "Penjualan Sagu ke Agen <strong>".$this->input->post('nama_agen')."</strong> ";
            $uraian .= "sebesar Rp. ".number_format($sum_harga,0,',','.');
            $uraian .= " untuk total order ".number_format($sum_berat,0,',','.');
            $uraian .= " Kg, dengan No.Delivery Order <strong>".$code."</strong>";
            $uraian .= " menggunakan kendaraan ".$this->input->post('type_kendaraan')." dengan nomor polisi <strong>".$this->input->post('no_kendaraan');
            $uraian .= "</strong> pada tanggal <strong>".date('d/m/Y')."</strong>";
        
            $this->db->insert('t_transaksi_bayar', array(
                'tanggal'=> $input_tgl,
                'no_nota'=> $this->Model_m_numberings->getNumbering('INVSG', $input_tgl),
                'dk'=>'K',
                'm_kendaraan_id'=> $this->input->post('m_kendaraan_id'),
                'm_agen_id'=> $this->input->post('m_agen_id'),
                'supir'=> $this->input->post('supir'),
                'jenis_barang'=> 'SAGU',
                'total_harga'=> $sum_harga,
                't_timbang_id'=>$this->input->post('timbang_id'),
                'uraian'=> $uraian,
                'created'=> $tanggal,
                'created_by'=> $user_id,
                'modified'=> $tanggal,
                'modified_by'=> $user_id,
            )); 
            $tb_id = $this->db->insert_id();
            
            #==================================  Save ongkos  =============================
            
            foreach ($parameter_ongkos as $key=>$val){
                if($val>0){
                    $biaya = $this->Model_m_biaya->get_ongkos('PENJUALAN SAGU', 'Ongkos', array('sak'=>$key))->result();
                    if($biaya){
                        foreach ($biaya as $idx=>$value){
                            $uraian_biaya = "Bayar uang ".$value->nama_biaya." untuk agen <strong>".$this->input->post('nama_agen')."</strong> ";
                            $uraian_biaya .= " dengan No.Delivery Order <strong>".$code."</strong>";
                            $uraian_biaya .= " menggunakan kendaraan ".$this->input->post('type_kendaraan');
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

                            $this->db->insert('t_transaksi_bayar', array(                                    
                                'tanggal'=>$input_tgl,
                                'no_nota'=>$this->Model_m_numberings->getNumbering('NDOKS', $input_tgl),
                                'dk'=>'D',
                                'm_kendaraan_id'=> $this->input->post('m_kendaraan_id'),
                                'm_agen_id'=> $this->input->post('m_agen_id'),
                                'supir'=> $this->input->post('supir'),
                                'jenis_barang'=> 'SAGU',
                                'uraian'=>$uraian_biaya,
                                'total_harga'=>$jumlah_biaya,
                                't_timbang_id'=>$this->input->post('timbang_id'),
                                't_transaksi_bayar_id'=>$tb_id,
                                'created'=>$tanggal,
                                'created_by'=>$user_id
                            ));
                        }
                    }
                }
            }        
        } 
            
        if($this->db->trans_complete()){    
            redirect('index.php/Penjualan/index/SAGU/Jual'); 
        }else{
            echo "Terjadi kesalahan saat penyimpanan data timbang!<br>";
            echo "<pre>"; die(var_dump($this->input->post()));
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
            
            $pdf->Cell(105,4,'PT. UNGGUL MEKAR SARI');
            $pdf->Cell(20,4,'Bill/Ship To');
            $pdf->Cell(65,4,': '.$header['nama_agen']);
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
            redirect('index.php/Penjualan/index/SAGU/Jual'); 
        }
    }
}