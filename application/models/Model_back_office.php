<?php
class Model_back_office extends CI_Model{
    function list_data_customer(){
        $data = $this->db->query("Select cst.*, grp.nama_customer As group_name, "
                . "prov.province_name, cty.city_name "
                . "From m_customers cst "
                . "Left Join m_customers grp On (cst.m_customer_id = grp.id) "
                . "Left Join m_provinces prov On (cst.m_province_id = prov.id) "
                . "Left Join m_cities cty On (cst.m_city_id = cty.id) "
                . "Order By cst.nama_customer");
        return $data;
    }
    
    function list_provinsi(){
        $data = $this->db->query("Select * From m_provinces Order By province_name");
        return $data;
    }
    
    function list_kota($id){
        $data = $this->db->query("Select * From m_cities Where m_province_id=".$id." Order By city_name");
        return $data;
    }
    
    function list_all_kota(){
        $data = $this->db->query("Select * From m_cities Order By city_name");
        return $data;
    }

    function cek_data_customer($code){
        $data = $this->db->query("Select * From m_customers Where nama_customer='".$code."'");        
        return $data;
    }
    
    function show_data_customer($id){
        $data = $this->db->query("Select * From m_customers Where id=".$id);        
        return $data;
    }
    
    function list_customer(){
        $data = $this->db->query("Select * From m_customers Order By nama_customer");
        return $data;
    }
    
    #Sales Order ============
    function list_data_so(){
        $data = $this->db->query("Select so.*, cust.nama_customer, 
                    cust.pic, cty.city_name,
                    (Select Sum(tdod.total_harga) From t_delivery_order_detail tdod 
                        Left Join t_delivery_order tdo On(tdod.t_delivery_order_id = tdo.id) 
                    Where tdo.t_sales_order_id = so.id
                    )As realisasi_do
                From t_sales_order so 
                    Left Join m_customers cust On (so.m_customer_id = cust.id) 
                    Left Join m_cities cty On (cust.m_city_id = cty.id) 
                Order By so.no_sales_order");        
        return $data;
    }
    
    function show_data_so($id){
        $data = $this->db->query("Select so.*, cust.nama_customer, 
                    cust.pic, cty.city_name
                From t_sales_order so 
                    Left Join m_customers cust On (so.m_customer_id = cust.id) 
                    Left Join m_cities cty On (cust.m_city_id = cty.id) 
                Where so.id=".$id);        
        return $data;
    }
    
    function show_detail_so($id){
        $data = $this->db->query("Select * From t_sales_order_detail "
                . "Where t_sales_order_id=".$id." Order By id");
        return $data;
    }
    
    function get_detail_so($id){
        $data = $this->db->query("Select * From t_sales_order_detail Where id=".$id);
        return $data;
    }
    
    function sum_nilai_order($id){
        $data = $this->db->query("Select Sum(harga)As nilai_order From t_sales_order_detail "
                . "Where t_sales_order_id=".$id);
        return $data;
    }
    
    #DeliveryOrder ============================================================
    function list_data_do(){
        $data = $this->db->query("Select tdo.*, cust.nama_customer, cust.alamat,
                cust.pic, eksp.nama_ekspedisi,(Select SUM(dtl.total_berat)AS total_berat 
                From t_delivery_order_detail dtl Where dtl.t_delivery_order_id = tdo.id) as total_berat 
                From t_delivery_order tdo 
                    Left Join m_customers cust On (tdo.m_customer_id = cust.id) 
                    Left Join m_ekspedisi eksp On (tdo.m_ekspedisi_id = eksp.id) 
                Order By tdo.no_delivery_order");        
        return $data;
    }
    
    function list_so($id){
        $data = $this->db->query("Select * From t_sales_order Where m_customer_id=".$id." Order By no_sales_order");
        return $data;
    }
    
    function show_data_do($id){
        $data = $this->db->query("Select tdo.*, eksp.nama_ekspedisi, 
                    cust.nama_customer, cust.alamat, cust.pic, cust.telepon 
                From t_delivery_order tdo 
                    Left Join m_ekspedisi eksp On (tdo.m_ekspedisi_id = eksp.id) 
                    Left Join m_customers cust On (tdo.m_customer_id = cust.id) 
                Where tdo.id=".$id);        
        return $data;      
    }
    
    function show_detail_do($id){
        $data = $this->db->query("Select * From t_delivery_order_detail "
                . "Where t_delivery_order_id=".$id." Order By id");
        return $data;
    }
    
    function sum_total_do($id){
        $data = $this->db->query("Select Sum(total_harga)As total_order From t_delivery_order_detail "
                . "Where t_delivery_order_id=".$id);
        return $data;
    }
    
    function get_detail_do($id){
        $data = $this->db->query("Select * From t_delivery_order_detail Where id=".$id);
        return $data;
    }
    
    function list_nomor_do(){
        $data = $this->db->query("Select id, no_delivery_order "
                . "From t_delivery_order Where flag_kirim=0 "
                . "Order By no_delivery_order");        
        return $data;
    }
    
    function list_do_pabrik(){
        $data = $this->db->query("Select tdo.*, cust.nama_customer, cust.alamat,
                cust.pic, eksp.nama_ekspedisi,
                (Select SUM(sak * jumlah_sak) From  t_delivery_order_detail dtl 
                Where tdo.id = dtl.t_delivery_order_id And tdo.flag_pecah=0) As total_berat 
                From t_delivery_order tdo 
                    Left Join m_ekspedisi eksp On (tdo.m_ekspedisi_id = eksp.id) 
                    Left Join m_customers cust On (tdo.m_customer_id = cust.id)  
                Where tdo.flag_pecah=0 And tdo.produk='SAGU' Order By tdo.no_delivery_order");        
        return $data;
    }
    
    function cek_stok($produk, $sak, $berat){
        $data = $this->db->query("Select inv.*, cv.kode_cv, cv.nama_cv, cv.sisa_limit "
                . "From t_inventory inv "
                . "Left Join m_cv cv On (inv.m_cv_id = cv.id) "
                . "Where inv.nama_produk='".$produk."' And inv.sak=".$sak
                . " And inv.stok>=".$berat." And inv.m_cv_id>0");
        return $data;
    }
    
    function cek_ulang_stok($produk, $sak, $berat){
        $data = $this->db->query("Select inv.*, cv.kode_cv, cv.nama_cv, cv.sisa_limit "
                . "From t_inventory inv "
                . "Left Join m_cv cv On (inv.m_cv_id = cv.id) "
                . "Where inv.nama_produk='".$produk."' And inv.sak=".$sak
                . " And inv.stok<".$berat." And inv.stok>0 And inv.m_cv_id>0");
        return $data;
    }
    
    function list_do_cv(){
        $data = $this->db->query("Select tdo.*, cv.nama_cv, cust.nama_customer, cust.alamat,"
                . "cust.pic, eksp.nama_ekspedisi, dop.no_delivery_order As no_do_pabrik, "
                . "SUM(dtl.total_berat)AS total_berat, SUM(dtl.total_harga)AS total_harga "
                . "From t_do_cv tdo "
                . "Left Join m_cv cv On (tdo.m_cv_id = cv.id) "
                . "Left Join m_customers cust On (tdo.m_customer_id = cust.id) "
                . "Left Join m_ekspedisi eksp On (tdo.m_ekspedisi_id = eksp.id) "
                . "Left Join t_delivery_order dop On (tdo.do_pabrik_id = dop.id) "
                . "Left Join t_do_cv_detail dtl On (tdo.id = dtl.t_do_cv_id) "
                . "Group By tdo.id "
                . "Order By tdo.no_delivery_order");        
        return $data;
    }
    
    function show_do_cv($id){
        $data = $this->db->query("Select tdo.*, cv.nama_cv, cust.nama_customer, cust.alamat,"
                . "cust.pic, cust.telepon, eksp.nama_ekspedisi "
                . "From t_do_cv tdo "
                . "Left Join m_cv cv On (tdo.m_cv_id = cv.id) "
                . "Left Join m_customers cust On (tdo.m_customer_id = cust.id) "
                . "Left Join m_ekspedisi eksp On (tdo.m_ekspedisi_id = eksp.id) "
                . "Where tdo.id=".$id);        
        return $data;
    }
    
    function show_detail_do_cv($id){
        $data = $this->db->query("Select * From t_do_cv_detail Where t_do_cv_id=".$id);
        return $data;
    }


    #====================== Ekspedisi ==========================================
    function list_data_ekspedisi(){
        $data = $this->db->query("Select eks.*, prov.province_name, cty.city_name "
                . "From m_ekspedisi eks "
                . "Left Join m_provinces prov On (eks.m_province_id = prov.id) "
                . "Left Join m_cities cty On (eks.m_city_id = cty.id) "
                . "Order By eks.nama_ekspedisi");
        return $data;
    }
    
    function cek_data_ekspedisi($code){
        $data = $this->db->query("Select * From m_ekspedisi Where nama_ekspedisi='".$code."'");        
        return $data;
    }
    
    function show_data_ekspedisi($id){
        $data = $this->db->query("Select * From m_ekspedisi Where id=".$id);        
        return $data;
    }
    
    function list_tarif($id){
        $data = $this->db->query("Select trf.*, pol.city_name As kota_asal, "
                . "pod.city_name As kota_tujuan From m_tarif_ekspedisi trf "
                . "Left Join m_cities pol ON (trf.asal_id = pol.id) "
                . "Left Join m_cities pod ON (trf.tujuan_id = pod.id) "
                . "Where trf.m_ekspedisi_id=".$id);        
        return $data;
    }
    
    function show_tarif($id){
        $data = $this->db->query("Select trf.*, pol.city_name As kota_asal, "
                . "pod.city_name As kota_tujuan From m_tarif_ekspedisi "
                . "Left Join m_cities pol ON (trf.asal_id = pol.id) "
                . "Left Join m_cities pod ON (trf.tujuan_id = pod.id) "
                . "Where trf.id=".$id);        
        return $data;
    }
    
    #============================= List CV ======================================
    function list_cv(){
        $data = $this->db->query("Select * From m_cv Order By nama_cv");
        return $data;
    }
    
    function cek_data_cv($code){
        $data = $this->db->query("Select * From m_cv Where nama_cv='".$code."'");        
        return $data;
    }
    
    function show_data_cv($id){
        $data = $this->db->query("Select * From m_cv Where id=".$id);        
        return $data;
    }
    
    
    
    function get_data_customer($id){
        $data = $this->db->query("Select cust.*, cty.city_name
                From m_customers cust Left Join m_cities cty On(cust.m_city_id = cty.id) 
                Where cust.id=".$id);
        return $data;
    }
    
    function get_tarif($ekspedisi_id, $tujuan){
        $data = $this->db->query("Select mte.tarif, eksp.nama_ekspedisi From m_tarif_ekspedisi mte "
                . "Left Join m_ekspedisi eksp On (mte.m_ekspedisi_id = eksp.id) "
                . "Where mte.m_ekspedisi_id=".$ekspedisi_id." And mte.tujuan_id=".$tujuan." Limit 1");
        return $data;
    }
    
    function getBeratEksp($id){
        $data = $this->db->query("Select Sum(total_berat)As total_berat 
                    From t_delivery_order_detail Where t_delivery_order_id=".$id);
        return $data;
    }
    
    function get_nilai_timbangan($do_id){
        $data = $this->db->query("Select tmbng.berat1, tmbng.berat2 From t_timbang tmbng 
                Left Join t_otorisasi tot On (tmbng.t_otorisasi_id = tot.id) 
                Where tot.t_delivery_order_id=".$do_id);
        return $data;
    }
}