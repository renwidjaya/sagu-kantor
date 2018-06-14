<?php
class Model_laporan extends CI_Model{
    function list_arus_kas(){
        $data = $this->db->query("Select * From t_kas Order By tanggal");
        return $data;
    }
    
    function list_beli_harian($jenis_barang, $tanggal=null){
        $sql = "Select tb.no_nota, tb.tanggal, tb.tempat_transaksi, "
                . "tot.time_in, tot.time_out, agn.nama_agen, agn.jenis_agen, kdr.no_kendaraan, "
                . "tb.berat_bersih, tb.harga, tbng.type_potongan, "
                . "tbng.refraksi_faktor, tbng.refraksi_value, tbng.qc03 "
                . "From t_transaksi_bayar tb "
                . "Left Join t_timbang tbng On (tb.t_timbang_id = tbng.id) "
                . "Left Join t_otorisasi tot On (tot.id = tbng.t_otorisasi_id) "
                . "Left Join m_agen agn On (tb.m_agen_id = agn.id) "
                . "Left Join m_kendaraan kdr On (tb.m_kendaraan_id = kdr.id) "
                . "Where tot.status=9 And tb.jenis_barang='".$jenis_barang."' And tb.berat_bersih>0";
        if(!empty($tanggal)){
            $sql .= " And tb.tanggal='".$tanggal."'";
        }
        $sql .= " Order By tb.no_nota";
        
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function sum_beli_harian($jenis_barang, $tanggal=null){
        $sql = "Select SUM(tb.berat_bersih)AS tot_berat_bersih, SUM(tbng.pot_timbang)AS tot_potongan,SUM(tbng.refraksi_value)AS tot_potongan "
                . "From t_transaksi_bayar tb "
                . "Left Join t_timbang tbng On (tb.t_timbang_id = tbng.id) "
                . "Left Join t_otorisasi tot On (tot.id = tbng.t_otorisasi_id) "
                . "Left Join m_agen agn On (tb.m_agen_id = agn.id) "
                . "Left Join m_kendaraan kdr On (tb.m_kendaraan_id = kdr.id) "
                . "Where tot.status=9 And tb.jenis_barang='".$jenis_barang."' And tb.berat_bersih>0";
        if(!empty($tanggal)){
            $sql .= " And tb.tanggal='".$tanggal."'";
        }
        
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function list_beli_bulanan($tgl_awal=null, $tgl_akhir=null){
        $sql = "Select tb.tanggal, SUM(tb.berat_bersih)As berat_bersih, SUM(tbng.refraksi_value)As potongan "
                . "From t_transaksi_bayar tb "
                . "Left Join t_timbang tbng On (tb.t_timbang_id = tbng.id) "
                . "Left Join t_otorisasi tot On (tot.id = tbng.t_otorisasi_id) "
                . "Left Join m_agen agn On (tb.m_agen_id = agn.id) "
                . "Left Join m_kendaraan kdr On (tb.m_kendaraan_id = kdr.id) "
                . "Where tot.status=9";
        if(!empty($tgl_awal) && !empty($tgl_akhir)){
            $sql .= " And tb.tanggal>='".$tgl_awal."' And tb.tanggal<='".$tgl_akhir."'";
        }
        $sql .= " Group By tb.tanggal Order By tb.tanggal";
        
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function sum_beli_bulanan($tgl_awal=null, $tgl_akhir=null){
        $sql = "Select SUM(tb.berat_bersih)As tot_berat_bersih, SUM(tbng.refraksi_value)As tot_potongan "
                . "From t_transaksi_bayar tb "
                . "Left Join t_timbang tbng On (tb.t_timbang_id = tbng.id) "
                . "Left Join t_otorisasi tot On (tot.id = tbng.t_otorisasi_id) "
                . "Left Join m_agen agn On (tb.m_agen_id = agn.id) "
                . "Left Join m_kendaraan kdr On (tb.m_kendaraan_id = kdr.id) "
                . "Where tot.status=9";
        if(!empty($tgl_awal) && !empty($tgl_akhir)){
            $sql .= " And tb.tanggal>='".$tgl_awal."' And tb.tanggal<='".$tgl_akhir."'";
        }
        
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function list_transaksi_kantor($tanggal=null){
        $sql = "Select tanggal,no_nota, tempat_transaksi, uraian, total_harga "
                . "From t_transaksi_bayar "
                . "Where tempat_transaksi='Kantor'";
        if(!empty($tanggal)){
            $sql .= " And tanggal='".$tanggal."'";
        }
        $sql .= " Order By no_nota";
        
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function sum_transaksi_kantor($tanggal=null){
        $sql = "Select SUM(total_harga)AS tot_jumlah "
                . "From t_transaksi_bayar "
                . "Where tempat_transaksi='Kantor'";
        if(!empty($tanggal)){
            $sql .= " And tanggal='".$tanggal."'";
        }
        
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function list_transaksi_dibatalkan($tanggal=null){
        $sql = "Select tanggal,no_nota, tempat_transaksi, uraian, alasan_cancel, total_harga "
                . "From t_transaksi_bayar "
                . "Where flag_cancel=1";
        if(!empty($tanggal)){
            $sql .= " And tb.tanggal='".$tanggal."'";
        }
        $sql .= " Order By no_nota";
        
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function sum_transaksi_dibatalkan($tanggal=null){
        $sql = "Select SUM(total_harga)AS tot_jumlah "
                . "From t_transaksi_bayar "
                . "Where flag_cancel=1";
        if(!empty($tanggal)){
            $sql .= " And tb.tanggal='".$tanggal."'";
        }
        
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function list_giling_harian($tanggal=null){
        $sql = "Select gil.*, cv.nama_cv From t_giling gil Left Join m_cv cv On (gil.m_cv_id = cv.id)";
        if(!empty($tanggal)){
            $sql .= " Where gil.tanggal='".$tanggal."'";
        }
        $sql .= " Order By gil.tanggal";
        
        $data = $this->db->query($sql);
        return $data;
    }
    
    function sum_giling_harian($tanggal=null){
        $sql = "Select SUM(sagu_pulau)AS sagu_pulau, SUM(sagu_kwr)AS sagu_kwr, "
                . "SUM(sagu_ph)AS sagu_ph, SUM(sagu_polos)AS sagu_polos, SUM(total)AS total "
                . "From t_oven ";
        if(!empty($tanggal)){
            $sql .= " Where tanggal='".$tanggal."'";
        }
        
        $data = $this->db->query($sql);
        return $data;
    }
    
    function list_rendemen(){
        $data = $this->db->query("Select tgil.tanggal, SUM(tgil.berat_diproses)As total_giling,"
                . "SUM(ovn1.total)As total_sagu_ovn1, SUM(sisa.selisih)As total_sisa, "
                . "SUM(ovn2.total)As total_sagu_ovn2, SUM(sisa.selisih)As total_sisa "
                . "From t_giling tgil "
                . "Left Join t_oven ovn1 On(tgil.tanggal = ovn1.tanggal And ovn1.oven=1) "
                . "Left Join t_oven ovn2 On(tgil.tanggal = ovn2.tanggal And ovn2.oven=2) "
                . "Left Join t_sisa_produksi sisa On(tgil.tanggal = sisa.tanggal) "
                . "Group By tgil.tanggal");
        return $data;
    }
    
    function list_inventory($cv=null){
        $sql = "Select inv.*, cv.nama_cv From t_inventory inv "
                . "Left Join m_cv cv On (inv.m_cv_id = cv.id)";
        if(!empty($cv)){
            $sql .= " Where inv.m_cv_id=".$cv;
        }
        $sql .= " Order By cv.nama_cv, inv.nama_produk, inv.sak";
        
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function view_inventory($id){
        $data = $this->db->query("Select inv.*, cv.nama_cv From t_inventory inv "
                . "Left Join m_cv cv On (inv.m_cv_id = cv.id) "
                . "Where inv.id=".$id);
        return $data;
    } 
    
    function view_detail_inventory($id){
        $data = $this->db->query("Select * From t_inventory_detail "
                . "Where t_inventory_id=".$id." Order By tanggal");
        return $data;
    } 
    
    function list_produk(){
        $data = $this->db->query("Select distinct nama_produk From t_inventory "
                . "Order By nama_produk");
        return $data;
    }
    
    function list_jual_harian($tanggal=null){
        $sql = "Select tdod.id, tdod.merek, tdod.sak, tdod.jumlah_sak, (tdod.sak* tdod.jumlah_sak)As total_berat, "
                . "tdo.no_delivery_order, tdo.tanggal, cust.nama_customer, eksp.nama_ekspedisi, kdr.no_kendaraan, tot.time_in, tot.time_out "
                . "From t_delivery_order_detail tdod "
                . "Left Join t_delivery_order tdo On(tdod.t_delivery_order_id = tdo.id) "
                . "Left Join t_otorisasi tot On(tdo.id = tot.t_delivery_order_id) "
                . "Left Join m_customers cust On(tdo.m_customer_id = cust.id) "
                . "Left Join m_ekspedisi eksp On(tdo.m_ekspedisi_id = eksp.id) "
                . "Left Join m_kendaraan kdr On(tot.m_kendaraan_id = kdr.id)";
        if(!empty($tanggal)){
            $sql .= " Where tdo.tanggal='".$tanggal."'";
        }
        $sql .= " Order By tdo.no_delivery_order, tdod.id";
        
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function sum_jual_harian($tanggal=null){
        $sql = "Select Sum(tdod.sak* tdod.jumlah_sak)As total_berat "
                . "From t_delivery_order_detail tdod "
                . "Left Join t_delivery_order tdo On(tdod.t_delivery_order_id = tdo.id) ";
        if(!empty($tanggal)){
            $sql .= " Where tdo.tanggal='".$tanggal."'";
        }
        
        $data = $this->db->query($sql);
        return $data;
    }
    
    function list_otorisasi($tgl_awal=null, $tgl_akhir=null){
        $sql = "Select otr.*, 
                Case
                    When otr.jenis_transaksi='Jual' THEN eksp.nama_ekspedisi
                    Else agn.nama_agen
                End AS nama_agen,
                Case
                    When otr.jenis_transaksi='Jual' THEN NULL
                    Else agn.jenis_agen
                End AS jenis_agen, 
                kdr.no_kendaraan, tkdr.type_kendaraan, mtn.nama_muatan, 
                tmbng.start_timbang_1, tmbng.end_timbang_1, tmbng.start_timbang_2, tmbng.end_timbang_2
                From t_otorisasi otr 
                    Left Join m_agen agn On (otr.m_agen_id = agn.id)  
                    Left Join m_ekspedisi eksp On (otr.m_agen_id = eksp.id)
                    Left Join m_kendaraan kdr On (otr.m_kendaraan_id = kdr.id) 
                    Left Join m_type_kendaraan tkdr On (kdr.m_type_kendaraan_id = tkdr.id) 
                    Left Join m_muatan mtn On (otr.m_muatan_id = mtn.id) 
                    Left Join t_timbang tmbng On (otr.id = tmbng.t_otorisasi_id)";
        if(!empty($tgl_awal) && !empty($tgl_akhir)){
            $sql .= " Where otr.time_in>='".$tgl_awal."' And otr.time_in<='".$tgl_akhir."'";
        }
        $sql .= " Order By otr.time_in";
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function list_hasil_oven($tgl_awal=null, $tgl_akhir=null){
        $sql = "Select ovn.*, gil.no_giling, cv.nama_cv 
                From t_oven ovn 
                    Left Join t_giling gil On (ovn.t_giling_id = gil.id) 
                    Left Join m_cv cv On (ovn.m_cv_id = cv.id)";
        if(!empty($tgl_awal) && !empty($tgl_akhir)){
            $sql .= " Where ovn.tanggal>='".$tgl_awal."' And ovn.tanggal<='".$tgl_akhir."'";
        }
        $sql .= " Order By gil.no_giling, ovn.oven, ovn.sak";
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function list_sisa_produksi($tgl_awal=null, $tgl_akhir=null){
        $sql = "Select * From t_sisa_produksi";
        if(!empty($tgl_awal) && !empty($tgl_akhir)){
            $sql .= " Where tanggal>='".$tgl_awal."' And tanggal<='".$tgl_akhir."'";
        }
        $sql .= " Order By tanggal, oven, sak";
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function list_kapasitas_mesin($tgl_awal=null, $tgl_akhir=null){
        $sql = "Select * From t_kapasitas_mesin Where type_mesin=9";
        if(!empty($tgl_awal) && !empty($tgl_akhir)){
            $sql .= " And tanggal_start>='".$tgl_awal."' And tanggal_start<='".$tgl_akhir."'";
        }
        $sql .= " Order By tanggal_start";
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function list_kapasitas_oven($tgl_awal=null, $tgl_akhir=null){
        $sql = "Select * From t_kapasitas_mesin Where type_mesin in(1,2)";
        if(!empty($tgl_awal) && !empty($tgl_akhir)){
            $sql .= " And tanggal_start>='".$tgl_awal."' And tanggal_start<='".$tgl_akhir."'";
        }
        $sql .= " Order By tanggal_start";
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function list_limbah($tgl_awal=null, $tgl_akhir=null){
        $sql = "SELECT distinct DATE(tmbg.created)as tanggal,
                (Select sum(jmr.berat) From t_jemur jmr Where jmr.tanggal= DATE(tmbg.created))As jml_jemur,
                (Select sum(pnn.berat) From t_panen pnn Where pnn.tanggal= DATE(tmbg.created))As jml_panen,
                (Select sum(tdodj.total_berat) From t_delivery_order_detail tdodj 
                        Left Join t_delivery_order doj On (tdodj.t_delivery_order_id = doj.id) 
                Where doj.tanggal= DATE(tmbg.created) And doj.produk='ONGGOK' And doj.flag_sumbangan=0)As jml_jual,
                (Select sum(tdods.total_berat) From t_delivery_order_detail tdods 
                        Left Join t_delivery_order dos On (tdods.t_delivery_order_id = dos.id) 
                Where dos.tanggal= DATE(tmbg.created) And dos.produk='ONGGOK' And dos.flag_sumbangan=1)As jml_sumbang
                From t_timbang tmbg";
        if(!empty($tgl_awal) && !empty($tgl_akhir)){
            $sql .= " Where tmbg.created>='".$tgl_awal."' And tmbg.created<='".$tgl_akhir."'";
        }
        $sql .= " Order By tmbg.created";
        $data = $this->db->query($sql);
        return $data;
    }
    
    function list_arus_kas_limbah(){
        $data = $this->db->query("Select * From t_kas_limbah Order By tanggal");
        return $data;
    }
    
    function list_arus_kas_cv(){
        $data = $this->db->query("Select * From t_kas_cv Order By tanggal");
        return $data;
    }
    
    function list_arus_kas_kantor(){
        $data = $this->db->query("Select * From t_kas_kantor Order By tanggal");
        return $data;
    }
    
    function list_tagihan_ekspedisi($tgl_awal=null, $tgl_akhir=null){
        $sql = "Select te.*,
                    cv.nama_cv, 
                    tdo.no_delivery_order,
                    eksp.nama_ekspedisi,
                    cust.nama_customer,
                    tb.flag_bayar
                From t_tagihan_ekspedisi te
                    Left Join m_cv cv On (te.m_cv_id = cv.id) 
                    Left Join t_delivery_order tdo On (te.t_delivery_order_id = tdo.id) 
                    Left Join m_customers cust On (te.m_customer_id = cust.id) 
                    Left Join m_ekspedisi eksp On (te.m_ekspedisi_id = eksp.id) 
                    Left Join t_transaksi_bayar tb On (te.t_transaksi_bayar_id = tb.id)  
                Where te.jumlah>0";
        if(!empty($tgl_awal) && !empty($tgl_akhir)){
            $sql .= " And te.tanggal>='".$tgl_awal."' And te.tanggal<='".$tgl_akhir."'";
        }
        
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function sum_tagihan_ekspedisi($tgl_awal=null, $tgl_akhir=null){
        $sql = "Select SUM(jumlah)As total_tagihan 
                From t_tagihan_ekspedisi Where jumlah>0";
        if(!empty($tgl_awal) && !empty($tgl_akhir)){
            $sql .= " And tanggal>='".$tgl_awal."' And tanggal<='".$tgl_akhir."'";
        }
        
        $data = $this->db->query($sql);
        return $data;
    } 
    
    function cek_detail($produk){
        $data = $this->db->query("Select distinct type_produk 
                From t_inventory Where nama_produk='".$produk."' and type_produk!='' Order By type_produk");
        return $data;
    }
    
    function cek_harga($produk, $param=null){
        $sql = "Select max(jumlah) As jumlah From m_biaya Where nama_biaya ='HARGA ".$produk."' 
                And kategori='HARGA ITEM'";
        if(!empty($param)){
            $sql .= " And parameter='sak=".$param."'";
        }
        $data = $this->db->query($sql);
        return $data;
    }
    
    function cek_stok($produk, $type_produk=null, $sak=null, $cv=null){
        $sql  = "Select stok From t_inventory Where nama_produk='".$produk."'";
        if(!empty($type_produk)){
            $sql .= " And type_produk='".$type_produk."'";
        }
        if(!empty($sak)){
            $sql .= " And sak=".$sak;
        }
        if(!empty($cv)){
            $sql .= " And m_cv_id=".$cv;
        }
        $data = $this->db->query($sql);
        return $data;
    }
    
    function get_nama_cv($id){
        $data = $this->db->query("Select nama_cv From m_cv Where id=".$id);
        return $data;
    }
    
    function get_tanggal($produk, $cv=null){
        $sql = "Select distinct tanggal From t_inventory_detail invd 
                Left Join t_inventory inv On(invd.t_inventory_id = inv.id) 
                Where inv.nama_produk='".$produk."'";
        if(!empty($cv)){
            $sql .= " And inv.m_cv_id=".$cv;
        }
        $sql .= " Order By invd.tanggal";
        $data = $this->db->query($sql);
        return $data;
    }
    
    function cek_inventory_detail($produk, $type_produk, $tanggal, $sak=null, $cv=null){
        $sql = "Select Sum(invd.jumlah_masuk)As jumlah_masuk, Sum(invd.jumlah_keluar)As jumlah_keluar 
                From t_inventory_detail invd 
                Left Join t_inventory inv On(invd.t_inventory_id = inv.id) 
                Where inv.nama_produk='".$produk."' And inv.type_produk='".$type_produk."' 
                    And invd.tanggal='".$tanggal."'";
        if(!empty($sak)){
            $sql .= " And inv.sak=".$sak;
        }
        if(!empty($cv)){
            $sql .= " And inv.m_cv_id=".$cv;
        }
        $data = $this->db->query($sql);
        return $data;
    }
    
    function cek_sak($produk){
        $data = $this->db->query("Select distinct sak 
                From t_inventory Where nama_produk='".$produk."' And sak>0 Order By sak");
        return $data;
    }
}