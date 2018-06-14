<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SinkronisasiByEmail extends CI_Controller{
    function __construct(){
        parent::__construct();

        if($this->session->userdata('status') != "login"){
            redirect(base_url("index.php/Login"));
        }
    }
    
    function index(){
        if (!empty($_FILES['document_url']['tmp_name'])){
            $ekstensi = pathinfo($_FILES['document_url']['name'], PATHINFO_EXTENSION);            
            if($ekstensi=="csv"){ 
                $user_id  = $this->session->userdata('user_id');
                $tanggal  = date('Y-m-d h:m:s');
                
                $file_name = $_FILES['document_url']['name'];
                $this->load->model('Model_sinkronisasi');
                $cek_data = $this->Model_sinkronisasi->cek_tabel($file_name)->result();
                if($cek_data){
                    $data['type_message']= "error";
                    $data['message']= "File yang anda pilih sudah pernah diproses untuk sinkronisasi data";
                }else{

                    $handle = fopen($_FILES['document_url']['tmp_name'], "r");
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $tabel    = $data[0];
                        if($tabel=="t_otorisasi"){
                            $flag_action = $data[15];
                            $row = array(
                                    'm_agen_id'=>$data[2],
                                    'm_kendaraan_id'=>$data[3],
                                    'supir'=>$data[4],
                                    'm_muatan_id'=>$data[5],
                                    'deskripsi'=>$data[6],
                                    'jenis_transaksi'=>$data[7],
                                    'jenis_transaksi'=>$data[8],
                                    'time_in'=>$data[9],
                                    'time_out'=>$data[10],
                                    'status'=>$data[11],
                                    'finish_timbang'=>$data[12],
                                    't_delivery_order_id'=>$data[13],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('t_otorisasi', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('t_otorisasi', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('t_otorisasi', $row);
                                }else{
                                    $this->db->insert('t_otorisasi', $row);
                                }
                            }
                        }   
                        
                        if($tabel=="t_giling"){
                            $flag_action = $data[8];
                            $row = array(
                                    'tanggal'=>$data[2],
                                    'no_giling'=>$data[3],
                                    'berat_diproses'=>$data[4],
                                    'm_cv_id'=>$data[5],
                                    'flag_oven'=>$data[6],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('t_giling', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('t_giling', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('t_giling', $row);
                                }else{
                                    $this->db->insert('t_giling', $row);
                                }
                            }
                        }    
                        
                        if($tabel=="t_oven"){
                            $flag_action = $data[13];
                            $row = array(
                                    'tanggal'=>$data[2],
                                    't_giling_id'=>$data[3],
                                    'oven'=>$data[4],
                                    'sak'=>$data[5],
                                    'sagu_pulau'=>$data[6],
                                    'sagu_kwr'=>$data[7],
                                    'sagu_ph'=>$data[8],
                                    'sagu_polos'=>$data[9],
                                    'total'=>$data[10],
                                    'm_cv_id'=>$data[11],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('t_oven', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('t_oven', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('t_oven', $row);
                                }else{
                                    $this->db->insert('t_oven', $row);
                                }
                            }
                        }  
                        
                        if($tabel=="t_sisa_produksi"){
                            $flag_action = $data[9];
                            $row = array(
                                    'tanggal'=>$data[2],
                                    'oven'=>$data[3],
                                    'sak'=>$data[4],
                                    'sisa_sak'=>$data[5],
                                    'jumlah'=>$data[6],
                                    'selisih'=>$data[7],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('t_sisa_produksi', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('t_sisa_produksi', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('t_sisa_produksi', $row);
                                }else{
                                    $this->db->insert('t_sisa_produksi', $row);
                                }
                            }
                        }
                        
                        if($tabel=="t_kapasitas_mesin"){
                            $flag_action = $data[11];
                            $row = array(
                                    'type_mesin'=>$data[2],
                                    'tanggal_start'=>$data[3],
                                    'jam_start'=>$data[4],
                                    'delay'=>$data[5],
                                    'tanggal_stop'=>$data[6],
                                    'jam_stop'=>$data[7],
                                    'waktu'=>$data[8],
                                    'waktu2'=>$data[9],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('t_kapasitas_mesin', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('t_kapasitas_mesin', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('t_kapasitas_mesin', $row);
                                }else{
                                    $this->db->insert('t_kapasitas_mesin', $row);
                                }
                            }
                        }
                        
                        if($tabel=="m_agen"){
                            $flag_action = $data[10];
                            $row = array(
                                    'nama_agen'=>$data[2],
                                    'alamat'=>$data[3],
                                    'm_province_id'=>$data[4],
                                    'm_city_id'=>$data[5],
                                    'pic'=>$data[6],
                                    'telepon'=>$data[7],
                                    'jenis_agen'=>$data[8],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('m_agen', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('m_agen', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('m_agen', $row);
                                }else{
                                    $this->db->insert('m_agen', $row);
                                }
                            }
                        }
                        
                        if($tabel=="m_kendaraan"){
                            $flag_action = $data[6];
                            $row = array(
                                    'no_kendaraan'=>$data[2],
                                    'm_type_kendaraan'=>$data[3],
                                    'keterangan'=>$data[4],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('m_kendaraan', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('m_kendaraan', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('m_kendaraan', $row);
                                }else{
                                    $this->db->insert('m_kendaraan', $row);
                                }
                            }
                        }
                        
                        if($tabel=="m_type_kendaraan"){
                            $flag_action = $data[5];
                            $row = array(
                                    'type_kendaraan'=>$data[2],
                                    'keterangan'=>$data[3],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('m_type_kendaraan', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('m_type_kendaraan', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('m_type_kendaraan', $row);
                                }else{
                                    $this->db->insert('m_type_kendaraan', $row);
                                }
                            }
                        }
                        
                        if($tabel=="m_area_jemur"){
                            $flag_action = $data[4];
                            $row = array(
                                    'nama_area_jemur'=>$data[2],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('m_area_jemur', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('m_area_jemur', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('m_area_jemur', $row);
                                }else{
                                    $this->db->insert('m_area_jemur', $row);
                                }
                            }
                        }
                        
                        if($tabel=="m_muatan_type"){
                            $flag_action = $data[5];
                            $row = array(
                                    'm_muatan_id'=>$data[2],
                                    'muatan_type'=>$data[3],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('m_muatan_type', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('m_muatan_type', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('m_muatan_type', $row);
                                }else{
                                    $this->db->insert('m_muatan_type', $row);
                                }
                            }
                        }
                        
                        if($tabel=="t_delivery_order"){
                            $flag_action = $data[11];
                            $row = array(
                                    'tanggal'=>$data[2],
                                    'no_delivery_order'=>$data[3],
                                    'produk'=>$data[4],
                                    'm_ekspedisi_id'=>$data[5],
                                    'm_customer_id'=>$data[6],
                                    'catatan'=>$data[7],
                                    'flag_sumbangan'=>$data[8],
                                    'flag_cancel'=>$data[9],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('t_delivery_order', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('t_delivery_order', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('t_delivery_order', $row);
                                }else{
                                    $this->db->insert('t_delivery_order', $row);
                                }
                            }
                        }
                        
                        if($tabel=="t_delivery_order_detail"){                            
                            $row = array(
                                    't_delivery_order_id'=>$data[2],
                                    'merek'=>$data[3],
                                    'sak'=>$data[4],
                                    'jumlah_sak'=>$data[5],
                                    'harga'=>$data[6],
                                    'total_berat'=>$data[7],
                                    'total_harga'=>$data[8],
                                    'catatan'=>$data[9],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            $this->db->insert('t_delivery_order_detail', $row);
                        }
                        
                        if($tabel=="t_jemur"){
                            $flag_action = $data[10];
                            $row = array(
                                    'tanggal'=>$data[2],
                                    'no_jemur'=>$data[3],
                                    'item'=>$data[4],
                                    't_timbang_id'=>$data[5],
                                    'berat'=>$data[6],
                                    'm_area_jemur_id'=>$data[7],
                                    'flag_panen'=>$data[8],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('t_jemur', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('t_jemur', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('t_jemur', $row);
                                }else{
                                    $this->db->insert('t_jemur', $row);
                                }
                            }
                        }
                        
                        if($tabel=="t_panen"){
                            $flag_action = $data[10];
                            $row = array(
                                    'jenis_limbah'=>$data[2],
                                    'tanggal'=>$data[3],
                                    'm_employee_id'=>$data[4],
                                    't_jemur_id'=>$data[5],
                                    'jenis_karung'=>$data[6],
                                    'jumlah'=>$data[7],
                                    'berat'=>$data[8],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('t_panen', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('t_panen', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('t_panen', $row);
                                }else{
                                    $this->db->insert('t_panen', $row);
                                }
                            }
                        }                        
                        
                        if($tabel=="t_inventory"){
                            $flag_action = $data[7];
                            $row = array(
                                    'nama_produk'=>$data[2],
                                    'type_produk'=>$data[3],
                                    'sak'=>$data[4],
                                    'stok'=>$data[5],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('t_inventory', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('t_inventory', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('t_inventory', $row);
                                }else{
                                    $this->db->insert('t_inventory', $row);
                                }
                            }
                        }
                        
                        if($tabel=="t_inventory_detail"){
                            $row = array(
                                    't_inventory_id'=>$data[2],
                                    'tanggal'=>$data[3],
                                    'jumlah_masuk'=>$data[4],
                                    'jumlah_keluar'=>$data[5],
                                    'referensi_name'=>$data[6],
                                    'referensi_id'=>$data[7],
                                    'referensi_no'=>$data[8],
                                    'catatan'=>$data[9],
                                    't_lokal_id'=>$data[1]
                                );
                            $this->db->insert('t_inventory_detail', $row);
                        }
                        
                        if($tabel=="t_kas"){
                            $flag_action = $data[9];
                            $row = array(
                                    'tanggal'=>$data[2],
                                    'uraian'=>$data[3],
                                    'dk'=>$data[4],
                                    'debet'=>$data[5],
                                    'kredit'=>$data[6],
                                    'no_referensi'=>$data[7],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('t_kas', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('t_kas', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('t_kas', $row);
                                }else{
                                    $this->db->insert('t_kas', $row);
                                }
                            }
                        }
                        
                        if($tabel=="t_kas_limbah"){
                            $flag_action = $data[9];
                            $row = array(
                                    'tanggal'=>$data[2],
                                    'uraian'=>$data[3],
                                    'dk'=>$data[4],
                                    'debet'=>$data[5],
                                    'kredit'=>$data[6],
                                    'no_referensi'=>$data[7],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('t_kas_limbah', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('t_kas_limbah', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('t_kas_limbah', $row);
                                }else{
                                    $this->db->insert('t_kas_limbah', $row);
                                }
                            }
                        }
                        
                        if($tabel=="t_kas_cv"){
                            $flag_action = $data[9];
                            $row = array(
                                    'tanggal'=>$data[2],
                                    'uraian'=>$data[3],
                                    'dk'=>$data[4],
                                    'debet'=>$data[5],
                                    'kredit'=>$data[6],
                                    'no_referensi'=>$data[7],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('t_kas_cv', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('t_kas_cv', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('t_kas_cv', $row);
                                }else{
                                    $this->db->insert('t_kas_cv', $row);
                                }
                            }
                        }
                        
                        if($tabel=="t_transaksi_bayar"){
                            $flag_action = $data[21];
                            $row = array(
                                    'tanggal'=>$data[2],
                                    'no_nota'=>$data[3],
                                    'dk'=>$data[4],
                                    'tempat_transaksi'=>$data[5],
                                    'm_kendaraan_id'=>$data[6],
                                    'm_agen_id'=>$data[7],
                                    'supir'=>$data[8],
                                    'jenis_barang'=>$data[9],
                                    'berat_bersih'=>$data[10],
                                    'harga'=>$data[11],
                                    'total_harga'=>$data[12],
                                    'sisa'=>$data[13],
                                    'uraian'=>$data[14],
                                    't_timbang_id'=>$data[15],
                                    't_transaksi_bayar_id'=>$data[16],
                                    'flag_bayar'=>$data[17],
                                    'flag_cancel'=>$data[18],
                                    'alasan_cancel'=>$data[19],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('t_transaksi_bayar', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('t_transaksi_bayar', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('t_transaksi_bayar', $row);
                                }else{
                                    $this->db->insert('t_transaksi_bayar', $row);
                                }
                            }
                        }
                        
                        if($tabel=="t_timbang"){
                            $flag_action = $data[25];
                            $row = array(
                                    't_otorisasi_id'=>$data[2],
                                    'berat1'=>$data[3],
                                    'start_timbang_1'=>$data[4],
                                    'end_timbang_1'=>$data[5],
                                    'pot_timbang'=>$data[6],
                                    'berat2'=>$data[7],
                                    'start_timbang_2'=>$data[8],
                                    'end_timbang_2'=>$data[9],
                                    'berat_kotor'=>$data[10],
                                    'type_potongan'=>$data[11],
                                    'refraksi_faktor'=>$data[12],
                                    'refraksi_value'=>$data[13],
                                    'berat_bersih'=>$data[14],
                                    'harga'=>$data[15],
                                    'total_harga'=>$data[16],
                                    'qc01'=>$data[17],
                                    'qc02'=>$data[18],
                                    'qc03'=>$data[19],
                                    'qc04'=>$data[20],
                                    'qc05'=>$data[21],
                                    'keterangan'=>$data[22],
                                    't_giling_id'=>$data[23],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('t_timbang', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('t_timbang', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('t_timbang', $row);
                                }else{
                                    $this->db->insert('t_timbang', $row);
                                }
                            }
                        }
                        
                        if($tabel=="m_ekspedisi"){
                            $flag_action = $data[12];
                            $row = array(
                                    'nama_ekspedisi'=>$data[2],
                                    'telepon'=>$data[3],
                                    'hp'=>$data[4],
                                    'alamat'=>$data[5],
                                    'm_province_id'=>$data[6],
                                    'm_city_id'=>$data[7],
                                    'kode_pos'=>$data[8],
                                    'jenis_barang'=>$data[9],
                                    'keterangan'=>$data[10],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('m_ekspedisi', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('m_ekspedisi', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('m_ekspedisi', $row);
                                }else{
                                    $this->db->insert('m_ekspedisi', $row);
                                }
                            }
                        }
                        
                        if($tabel=="m_customers"){
                            $flag_action = $data[13];
                            $row = array(
                                    'nama_customer'=>$data[2],
                                    'm_customer_id'=>$data[3],
                                    'pic'=>$data[4],
                                    'telepon'=>$data[5],
                                    'hp'=>$data[6],
                                    'alamat'=>$data[7],
                                    'm_province_id'=>$data[8],
                                    'm_city_id'=>$data[9],
                                    'kode_pos'=>$data[10],
                                    'keterangan'=>$data[11],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('m_customers', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('m_customers', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('m_customers', $row);
                                }else{
                                    $this->db->insert('m_customers', $row);
                                }
                            }
                        }
                        
                        if($tabel=="m_biaya"){
                            $flag_action = $data[11];
                            $row = array(
                                    'jenis_transaksi'=>$data[2],
                                    'nama_biaya'=>$data[3],
                                    'kategori'=>$data[4],
                                    'parameter'=>$data[5],
                                    'keterangan'=>$data[6],
                                    'type_biaya'=>$data[7],
                                    'satuan'=>$data[8],
                                    'jumlah'=>$data[9],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('m_biaya', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('m_biaya', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('m_biaya', $row);
                                }else{
                                    $this->db->insert('m_biaya', $row);
                                }
                            }
                        }
                        
                        if($tabel=="m_muatan"){
                            $flag_action = $data[5];
                            $row = array(
                                    'nama_muatan'=>$data[2],
                                    'keterangan'=>$data[3],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('m_muatan', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('m_muatan', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('m_muatan', $row);
                                }else{
                                    $this->db->insert('m_muatan', $row);
                                }
                            }
                        }
                        
                        if($tabel=="m_provinces"){
                            $flag_action = $data[5];
                            $row = array(
                                    'province_code'=>$data[2],
                                    'province_name'=>$data[3],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('m_provinces', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('m_provinces', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('m_provinces', $row);
                                }else{
                                    $this->db->insert('m_provinces', $row);
                                }
                            }
                        }
                        
                        if($tabel=="m_cities"){
                            $flag_action = $data[6];
                            $row = array(
                                    'city_code'=>$data[2],
                                    'city_name'=>$data[3],
                                    'm_province_id'=>$data[4],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('m_cities', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('m_cities', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('m_cities', $row);
                                }else{
                                    $this->db->insert('m_cities', $row);
                                }
                            }
                        }
                        
                        if($tabel=="m_employees"){
                            $flag_action = $data[13];
                            $row = array(
                                    'nik'=>$data[2],
                                    'nama_employee'=>$data[3],
                                    'alamat'=>$data[4],
                                    'm_city_id'=>$data[5],
                                    'm_province_id'=>$data[6],
                                    'kode_pos'=>$data[7],
                                    'phone'=>$data[8],
                                    'mobile'=>$data[9],
                                    'email'=>$data[10],
                                    'tipe_pekerjaan'=>$data[11],
                                    't_lokal_id'=>$data[1],
                                    'created'=>$tanggal,
                                    'created_by'=>$user_id,
                                    'modified'=>$tanggal,
                                    'modified_by'=>$user_id
                                );
                            if($flag_action=="I"){
                                $this->db->insert('m_employees', $row);
                            }else{
                                $cek_data = $this->Model_sinkronisasi->cek_if_exist('m_employees', $data[1])->result();
                                if($cek_data){
                                    $this->db->where('t_lokal_id', $data[1]);
                                    $this->db->update('m_employees', $row);
                                }else{
                                    $this->db->insert('m_employees', $row);
                                }
                            }
                        }
                        
                        
                    }

                    fclose($handle); 
                    $this->db->insert('t_upload', array('nama_file'=>$file_name));
                    $data['type_message']= "success";
                    $data['message']= "Upload data berhasil";
                }
            }else{
                $data['type_message']= "error";
                $data['message']= "Your file type is not supported";
            }            
        }
        
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Sinkronisasi";
        $data['content']= "sinkronisasi/index";       
        
        $this->load->view('layout', $data);
    }
    
    function proses_sinkronisasi(){
        #Tabel Otorisasi
        $cek = $this->db->query("Select * From t_otorisasi Where flag_sinkronisasi=0 Order By id")->result();
        if($cek){
            $this->db->trans_start();
            foreach ($cek as $index=>$value){
                $this->db->where('t_otorisasi_id', $value->t_lokal_id);
                $this->db->update('t_timbang', array('t_otorisasi_id'=>$value->id));
                
            
                $this->db->where('id', $value->id);
                $this->db->update('t_otorisasi', array('flag_sinkronisasi'=>1)); 
            }
            $this->db->trans_complete();
        }
        
        #Tabel Timbang
        $cek = $this->db->query("Select * From t_timbang Where flag_sinkronisasi=0 Order By id")->result();
        if($cek){
            $this->db->trans_start();
            foreach ($cek as $index=>$value){
                $this->db->where('t_timbang_id', $value->t_lokal_id);
                $this->db->update('t_jemur', array('t_timbang_id'=>$value->id));
                
                $this->db->where('t_timbang_id', $value->t_lokal_id);
                $this->db->update('t_panen', array('t_timbang_id'=>$value->id));
                
                $this->db->where('t_timbang_id', $value->t_lokal_id);
                $this->db->update('t_transaksi_bayar', array('t_timbang_id'=>$value->id));
                
            
                $this->db->where('id', $value->id);
                $this->db->update('t_timbang', array('flag_sinkronisasi'=>1)); 
            }
            $this->db->trans_complete();
        }
        
        #Tabel giling
        $cek = $this->db->query("Select * From t_giling Where flag_sinkronisasi=0 Order By id")->result();
        if($cek){
            $this->db->trans_start();
            foreach ($cek as $index=>$value){
                $this->db->where('t_giling_id', $value->t_lokal_id);
                $this->db->update('t_oven', array('t_giling_id'=>$value->id));
                
                $this->db->where(array('referensi_name'=>'t_giling', 'referensi_id'=>$value->t_lokal_id));
                $this->db->update('t_inventory_detail', array('referensi_id'=>$value->id));                
            
                $this->db->where('id', $value->id);
                $this->db->update('t_giling', array('flag_sinkronisasi'=>1)); 
            }
            $this->db->trans_complete();
        }
        
        #Tabel Agen
        $cek = $this->db->query("Select * From m_agen Where flag_sinkronisasi=0 Order By id")->result();
        if($cek){
            $this->db->trans_start();
            foreach ($cek as $index=>$value){
                $this->db->where('m_agen_id', $value->t_lokal_id);
                $this->db->update('t_otorisasi', array('m_agen_id'=>$value->id));
                #$this->db->update('t_kasbon_agen', array('m_agen_id'=>$value->id));
                $this->db->where('m_agen_id', $value->t_lokal_id);
                $this->db->update('t_transaksi_bayar', array('m_agen_id'=>$value->id));
                #$this->db->update('t_delivery_order', array('m_agen_id'=>$value->id));
                
            
                $this->db->where('id', $value->id);
                $this->db->update('m_agen', array('flag_sinkronisasi'=>1)); 
            }
            $this->db->trans_complete();
        }
        
        #Tabel Kendaraan
        $cek = $this->db->query("Select * From m_kendaraan Where flag_sinkronisasi=0 Order By id")->result();
        if($cek){
            $this->db->trans_start();
            foreach ($cek as $index=>$value){
                $this->db->where('m_kendaraan_id', $value->t_lokal_id);
                $this->db->update('t_otorisasi', array('m_kendaraan_id'=>$value->id));
                #$this->db->update('t_kasbon_agen', array('m_kendaraan_id'=>$value->id));
                
                $this->db->where('m_kendaraan_id', $value->t_lokal_id);
                $this->db->update('t_transaksi_bayar', array('m_kendaraan_id'=>$value->id));
                #$this->db->update('t_delivery_order', array('m_kendaraan_id'=>$value->id));
                
            
                $this->db->where('id', $value->id);
                $this->db->update('m_kendaraan', array('flag_sinkronisasi'=>1)); 
            }
            $this->db->trans_complete();
        }
        
        #Tabel Type Kendaraan
        $cek = $this->db->query("Select * From m_type_kendaraan Where flag_sinkronisasi=0 Order By id")->result();
        if($cek){
            $this->db->trans_start();
            foreach ($cek as $index=>$value){
                $this->db->where('m_type_kendaraan_id', $value->t_lokal_id);
                $this->db->update('m_kendaraan', array('m_type_kendaraan_id'=>$value->id));                
            
                $this->db->where('id', $value->id);
                $this->db->update('m_type_kendaraan', array('flag_sinkronisasi'=>1)); 
            }
            $this->db->trans_complete();
        }
        
        #Tabel Employee
        $cek = $this->db->query("Select * From m_employees Where flag_sinkronisasi=0 Order By id")->result();
        if($cek){
            $this->db->trans_start();
            foreach ($cek as $index=>$value){
                $this->db->where('m_employee_id', $value->t_lokal_id);
                $this->db->update('t_panen', array('m_employee_id'=>$value->id));                
            
                $this->db->where('id', $value->id);
                $this->db->update('m_employees', array('flag_sinkronisasi'=>1)); 
            }
            $this->db->trans_complete();
        }
        
        #Tabel Area Jemur
        $cek = $this->db->query("Select * From m_area_jemur Where flag_sinkronisasi=0 Order By id")->result();
        if($cek){
            $this->db->trans_start();
            foreach ($cek as $index=>$value){
                $this->db->where('m_area_jemur_id', $value->t_lokal_id);
                $this->db->update('t_jemur', array('m_area_jemur_id'=>$value->id));                
            
                $this->db->where('id', $value->id);
                $this->db->update('m_area_jemur', array('flag_sinkronisasi'=>1)); 
            }
            $this->db->trans_complete();
        }
        
        #Tabel Delivery Order
        $cek = $this->db->query("Select * From t_delivery_order Where flag_sinkronisasi=0 Order By id")->result();
        if($cek){
            $this->db->trans_start();
            foreach ($cek as $index=>$value){
                $this->db->where('t_delivery_order_id', $value->t_lokal_id);
                $this->db->update('t_delivery_order_detail', array('t_delivery_order_id'=>$value->id)); 
                
                 $this->db->where('t_delivery_order_id', $value->t_lokal_id);
                $this->db->update('t_otorisasi', array('t_delivery_order_id'=>$value->id)); 
            
                $this->db->where('id', $value->id);
                $this->db->update('t_delivery_order', array('flag_sinkronisasi'=>1)); 
            }
            $this->db->trans_complete();
        }
        
        #Tabel Jemur
        $cek = $this->db->query("Select * From t_jemur Where flag_sinkronisasi=0 Order By id")->result();
        if($cek){
            $this->db->trans_start();
            foreach ($cek as $index=>$value){
                $this->db->where('t_jemur_id', $value->t_lokal_id);
                $this->db->update('t_panen', array('t_jemur_id'=>$value->id)); 
            
                $this->db->where('id', $value->id);
                $this->db->update('t_jemur', array('flag_sinkronisasi'=>1)); 
            }
            $this->db->trans_complete();
        }
        
        #Tabel Inventory
        $cek = $this->db->query("Select * From t_inventory Where flag_sinkronisasi=0 Order By id")->result();
        if($cek){
            $this->db->trans_start();
            foreach ($cek as $index=>$value){
                $this->db->where('t_inventory_id', $value->t_lokal_id);
                $this->db->update('t_inventory_detail', array('t_inventory_id'=>$value->id)); 
            
                $this->db->where('id', $value->id);
                $this->db->update('t_inventory', array('flag_sinkronisasi'=>1)); 
            }
            $this->db->trans_complete();
        }
        
        #Tabel Transaksi Bayar
        $cek = $this->db->query("Select * From t_transaksi_bayar Where flag_sinkronisasi=0 Order By id")->result();
        if($cek){
            $this->db->trans_start();
            foreach ($cek as $index=>$value){
                $this->db->where('t_transaksi_bayar_id', $value->t_lokal_id);
                $this->db->update('t_transaksi_bayar', array('t_transaksi_bayar_id'=>$value->id)); 
            
                $this->db->where('id', $value->id);
                $this->db->update('t_transaksi_bayar', array('flag_sinkronisasi'=>1)); 
            }
            $this->db->trans_complete();
        }
        
        #Tabel Ekspedisi
        $cek = $this->db->query("Select * From m_ekspedisi Where flag_sinkronisasi=0 Order By id")->result();
        if($cek){
            $this->db->trans_start();
            foreach ($cek as $index=>$value){
                $this->db->where(array('m_agen_id'=>$value->t_lokal_id, 'jenis_transaksi'=>'Jual'));
                $this->db->update('t_otorisasi', array('m_agen_id'=>$value->id)); 
                
                $this->db->where('m_ekspedisi_id', $value->t_lokal_id);
                $this->db->update('t_delivery_order', array('m_ekspedisi_id'=>$value->id));
            
                $this->db->where('id', $value->id);
                $this->db->update('m_ekspedisi', array('flag_sinkronisasi'=>1)); 
            }
            $this->db->trans_complete();
        }
        
        #Tabel Customers
        $cek = $this->db->query("Select * From m_customers Where flag_sinkronisasi=0 Order By id")->result();
        if($cek){
            $this->db->trans_start();
            foreach ($cek as $index=>$value){
                $this->db->where('m_customer_id', $value->t_lokal_id);
                $this->db->update('t_delivery_order', array('m_customer_id'=>$value->id));
            
                $this->db->where('id', $value->id);
                $this->db->update('m_customers', array('flag_sinkronisasi'=>1)); 
            }
            $this->db->trans_complete();
        }
        
        #Tabel Provinsi
        $cek = $this->db->query("Select * From m_provinces Where flag_sinkronisasi=0 Order By id")->result();
        if($cek){
            $this->db->trans_start();
            foreach ($cek as $index=>$value){
                $this->db->where('m_province_id', $value->t_lokal_id);
                $this->db->update('m_agen', array('m_province_id'=>$value->id));
                
                $this->db->where('m_province_id', $value->t_lokal_id);
                $this->db->update('m_customers', array('m_province_id'=>$value->id));
                
                $this->db->where('m_province_id', $value->t_lokal_id);
                $this->db->update('m_ekspedisi', array('m_province_id'=>$value->id));
                
                $this->db->where('m_province_id', $value->t_lokal_id);
                $this->db->update('m_cities', array('m_province_id'=>$value->id));
            
                $this->db->where('id', $value->id);
                $this->db->update('m_provinces', array('flag_sinkronisasi'=>1)); 
            }
            $this->db->trans_complete();
        }
        
        #Tabel Kota
        $cek = $this->db->query("Select * From m_cities Where flag_sinkronisasi=0 Order By id")->result();
        if($cek){
            $this->db->trans_start();
            foreach ($cek as $index=>$value){
                $this->db->where('m_city_id', $value->t_lokal_id);
                $this->db->update('m_agen', array('m_city_id'=>$value->id));
                
                $this->db->where('m_city_id', $value->t_lokal_id);
                $this->db->update('m_customers', array('m_city_id'=>$value->id));
                
                $this->db->where('m_city_id', $value->t_lokal_id);
                $this->db->update('m_ekspedisi', array('m_city_id'=>$value->id));
            
                $this->db->where('id', $value->id);
                $this->db->update('m_cities', array('flag_sinkronisasi'=>1)); 
            }
            $this->db->trans_complete();
        }
        
        $return_data = array();
        $return_data['type_message']= "success";
        
        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

}