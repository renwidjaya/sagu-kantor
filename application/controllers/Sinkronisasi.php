<?php
#if (! defined('BASEPATH')) exit('No direct script access allowed');

class Sinkronisasi extends CI_Controller{
    function index(){
        $this->load->model('Model_sinkronisasi');
        $dataku = $this->input->post('mydata');
        $data  = json_decode($dataku);
        
        $tabel = $data->tabel;
        unset($data->tabel);
        unset($data->flag_sinkronisasi);
        $data->t_lokal_id = $data->id;
        unset($data->id);
        foreach ($data as $index=>$value){
            $mydata[$index] = $value;
        } 
        
        if($mydata['flag_action']=="I"){
            unset($mydata['flag_action']);
            $return_data = ($this->db->insert($tabel, $mydata))? "Sukses": "Gagal insert ke database";
        }else{            
            $cek_data = $this->Model_sinkronisasi->cek_if_exist($tabel, $mydata['t_lokal_id'])->result();
            if($cek_data){
                unset($mydata['flag_action']);
                $this->db->where('t_lokal_id', $mydata['t_lokal_id']);
                $return_data = ($this->db->update($tabel, $mydata))? "Sukses": "Gagal update ke database";
            }else{
                $return_data = ($this->db->insert($tabel, $mydata))? "Sukses": "Gagal insert ke database";
            }
            $return_data = "Update";
        }
        echo $return_data;
    }
    
    function pra_sinkronisasi(){
        $tabel= array('t_otorisasi', 't_giling', 't_oven', 't_sisa_produksi', 
                't_kapasitas_mesin', 'm_agen', 'm_kendaraan', 'm_type_kendaraan', 
                't_delivery_order', 't_delivery_order_detail', 't_jemur', 't_panen', 
                't_inventory', 't_inventory_detail', 't_kas', 't_kas_limbah', 't_kas_cv', 
                't_transaksi_bayar', 't_timbang', 'm_ekspedisi', 'm_customers', 
                'm_biaya', 'm_muatan', 'm_provinces', 'm_cities', 'm_employees',
                'm_area_jemur', 'm_muatan_type'
            );
        
        foreach ($tabel as $data){
            $this->db->query("Truncate Table ".$data);            
        }
        die("Sukses");
    }
}