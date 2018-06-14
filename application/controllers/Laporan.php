<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller{
    function __construct(){
        parent::__construct();

        if($this->session->userdata('status') != "login"){
            redirect(base_url("index.php/Login"));
        }
    }
    
    function arus_kas(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/arus_kas";
        $data['content']= "laporan/arus_kas";
        $this->load->model('Model_laporan');
        $data['list_data'] = $this->Model_laporan->list_arus_kas()->result();
        
        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo = $get_saldo['saldo_awal'];
        $data['saldo'] = $saldo;

        #echo "<pre>"; die(var_dump($data['list_data']));
        foreach ($data['list_data'] as $index=>$value){
            $saldo =  $saldo + ($value->kredit - $value->debet);
            $data['list_data'][$index]->saldo = $saldo;
        }

        $this->load->view('layout', $data);
    }
    
    function pembelian_harian(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']= $group_id;        
        $data['judul']   = "Laporan/pembelian_harian";
        $data['content'] = "laporan/pembelian_harian";
        
        $this->load->model('Model_laporan');
        
        if (!empty($this->input->post('tanggal'))){            
            $data['parameter'] = date('Y-m-d', strtotime($this->input->post('tanggal')));
            $data['parameter_show'] = date('d-m-Y', strtotime($this->input->post('tanggal')));                       
        }else{
            $data['parameter'] = "";
            $data['parameter_show'] = date('d-m-Y');
        }
        
        $data['list_singkong'] = $this->Model_laporan->list_beli_harian('SINGKONG', $data['parameter'])->result();
        #echo "<pre>"; die(var_dump($data['list_singkong']));
        $data['total_singkong'] = $this->Model_laporan->sum_beli_harian('SINGKONG', $data['parameter'])->row_array();
        
        $data['list_merah'] = $this->Model_laporan->list_beli_harian('MERAH', $data['parameter'])->result();
        $data['total_merah'] = $this->Model_laporan->sum_beli_harian('MERAH', $data['parameter'])->row_array();
        
        $data['list_cangkang'] = $this->Model_laporan->list_beli_harian('CANGKANG', $data['parameter'])->result();
        $data['total_cangkang'] = $this->Model_laporan->sum_beli_harian('CANGKANG', $data['parameter'])->row_array();
        
        $this->load->view('layout', $data);
    }
    
    function pembelian_bulanan(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/pembelian_bulanan";
        $data['content']= "laporan/pembelian_bulanan";
        
        if (!empty($this->input->post('tgl_awal'))){            
            $data['tgl_awal'] = date('Y-m-d', strtotime($this->input->post('tgl_awal')));
            $data['tgl_awal_show'] = date('d-m-Y', strtotime($this->input->post('tgl_awal')));
            
            $data['tgl_akhir'] = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
            $data['tgl_akhir_show'] = date('d-m-Y', strtotime($this->input->post('tgl_akhir')));
        }else{
            $data['tgl_awal'] = "";
            $data['tgl_awal_show'] = date('d-m-Y');
            
            $data['tgl_akhir'] = "";
            $data['tgl_akhir_show'] = date('d-m-Y');;
        }
        $this->load->model('Model_laporan');
        $data['list_data'] = $this->Model_laporan->list_beli_bulanan($data['tgl_awal'], $data['tgl_akhir'])->result();
        $data['total'] = $this->Model_laporan->sum_beli_bulanan($data['tgl_awal'], $data['tgl_akhir'])->row_array();

        $this->load->view('layout', $data);
    }
    
    function transaksi_kantor(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/transaksi_kantor";
        $data['content']= "laporan/transaksi_kantor";
        
        if (!empty($this->input->post('tanggal'))){            
            $data['parameter'] = date('Y-m-d', strtotime($this->input->post('tanggal')));
            $data['parameter_show'] = date('d-m-Y', strtotime($this->input->post('tanggal')));
        }else{
            $data['parameter'] = "";
            $data['parameter_show'] = date('d-m-Y');
        }
        $this->load->model('Model_laporan');
        $data['list_data'] = $this->Model_laporan->list_transaksi_kantor($data['parameter'])->result();
        $data['total'] = $this->Model_laporan->sum_transaksi_kantor($data['parameter'])->row_array();

        $this->load->view('layout', $data);
    }
    
    function transaksi_dibatalkan(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/transaksi_dibatalkan";
        $data['content']= "laporan/transaksi_dibatalkan";
        
        if (!empty($this->input->post('tanggal'))){            
            $data['parameter'] = date('Y-m-d', strtotime($this->input->post('tanggal')));
            $data['parameter_show'] = date('d-m-Y', strtotime($this->input->post('tanggal')));
        }else{
            $data['parameter'] = "";
            $data['parameter_show'] = date('d-m-Y');
        }
        $this->load->model('Model_laporan');
        $data['list_data'] = $this->Model_laporan->list_transaksi_dibatalkan($data['parameter'])->result();
        $data['total'] = $this->Model_laporan->sum_transaksi_dibatalkan($data['parameter'])->row_array();

        $this->load->view('layout', $data);
    }
    
    function giling_harian(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/giling_harian";
        $data['content']= "laporan/giling_harian";
        
        if (!empty($this->input->post('tanggal'))){            
            $data['parameter'] = date('Y-m-d', strtotime($this->input->post('tanggal')));
            $data['parameter_show'] = date('d-m-Y', strtotime($this->input->post('tanggal')));
        }else{
            $data['parameter'] = "";
            $data['parameter_show'] = date('d-m-Y');
        }
        
        $this->load->model('Model_laporan');
        $data['list_data'] = $this->Model_laporan->list_giling_harian($data['parameter'])->result();
        
        $this->load->model('Model_back_office');
        $data['list_cv']   = $this->Model_back_office->list_cv()->result();
        $this->load->view('layout', $data);
    }
    
    function rendemen(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id'] = $group_id;
        
        $data['judul']  = "Laporan/rendemen";
        $data['content']= "laporan/rendemen";
        
        $this->load->model('Model_laporan');
        $data['list_data'] = $this->Model_laporan->list_rendemen()->result();

        $this->load->view('layout', $data);
    }
    
    function print_rendemen(){
        $tanggal = $this->uri->segment(3);
        $total_giling = $this->uri->segment(4);
        $total_sagu_ovn_1  = $this->uri->segment(5);
        $total_sagu_ovn_2  = $this->uri->segment(6);
        $total_sisa   = $this->uri->segment(7);
        $rendemen     = $this->uri->segment(8);
        $total_sagu   = $total_sagu_ovn_1 + $total_sagu_ovn_2;
        
        
        require('fpdf/fpdf.php');
            
        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();

        $pdf->SetFont('times','B',14);
        $pdf->Cell(190,8,'LAPORAN RENDEMEN TANGGAL '.date('d-m-Y', strtotime($tanggal)));
        $pdf->Ln(12);
        
        $pdf->SetFont('times','B',10);
        $pdf->Cell(35,6, 'Total Giling');
        $pdf->Cell(35,6, '= '.number_format($total_giling,0,',','.').' Kg');
        $pdf->Ln(6);
        $pdf->Cell(35,6, 'Total Produksi Sagu');
        $pdf->Cell(35,6, '= '.number_format($total_sagu,0,',','.').' Kg');
        $pdf->Ln(6);
        $pdf->Cell(35,6, 'Total Sisa');
        $pdf->Cell(35,6, '= '.number_format($total_sisa,0,',','.').' Kg');
        $pdf->Ln(12);
        
        $pdf->SetFont('times','B',14);
        $pdf->Cell(70,6, 'Rendemen = '.number_format($rendemen,0,',','.').' %');
        $pdf->Ln(12);
        
        $this->load->model('Model_t_kapasitas');
        $mesin = $this->Model_t_kapasitas->get_operasional_mesin($tanggal, 9)->row_array();
        
        if($mesin){        
            $pdf->Cell(70,6, 'MESIN #1');
            $pdf->Ln(6);
            $pdf->SetFont('times','B',10);
            $pdf->Cell(40,6, 'Start');
            $pdf->Cell(30,6, '= '.$mesin['jam_start']);
            $pdf->Ln(6);

            $pdf->Cell(40,6, 'Stop');
            $pdf->Cell(30,6, '= '.$mesin['jam_stop']);
            $pdf->Ln(6);

            $waktu_mesin = explode(":", $mesin['waktu']);     

            $pdf->Cell(40,6, 'Waktu');
            $pdf->Cell(30,6, '= '.$waktu_mesin[0]." jam ".$waktu_mesin[1]." menit = ".$mesin['waktu2']." (num)");
            $pdf->Ln(6);

            $pdf->Cell(40,6, 'Kerusakan');
            $pdf->Cell(30,6, '= 0 jam (num)');
            $pdf->Ln(6);

            $pdf->Cell(40,6, 'Total Waktu');
            $pdf->Cell(30,6, '= '.$mesin['waktu2']." (num)");
            $pdf->Ln(6);

            $tonase = $total_giling/$mesin['waktu2'];

            $pdf->SetFont('times','B',12);
            $pdf->Cell(40,6, 'Tonase Per Jam');
            $pdf->Cell(30,6, '= '.number_format($tonase,0,',','.').' Kg');
            $pdf->Ln(12);
        }
        
        $oven1 = $this->Model_t_kapasitas->get_operasional_mesin($tanggal, 1)->row_array();
        if($oven1){
            $pdf->Cell(70,6, 'OVEN #1');
            $pdf->Ln(6);
            $pdf->SetFont('times','B',10);
            $pdf->Cell(40,6, 'Start');
            $pdf->Cell(30,6, '= '.$oven1['jam_start']);
            $pdf->Ln(6);

            $pdf->Cell(40,6, 'Stop');
            $pdf->Cell(30,6, '= '.$oven1['jam_stop']);
            $pdf->Ln(6);
            
            $waktu_oven1 = explode(":", $oven1['waktu']);    
            $pdf->Cell(40,6, 'Waktu');
            $pdf->Cell(30,6, '= '.$waktu_oven1[0]." jam ".$waktu_oven1[1]." menit = ".$oven1['waktu2']." (num)");
            $pdf->Ln(6);

            $pdf->Cell(40,6, 'Kerusakan');
            $pdf->Cell(30,6, '= 0 jam (num)');
            $pdf->Ln(6);

            $pdf->Cell(40,6, 'Total Waktu');
            $pdf->Cell(30,6, '= '.$oven1['waktu2']." (num)");
            $pdf->Ln(6);
            
            $tonase = $total_sagu_ovn_1/$oven1['waktu2'];
            $pdf->SetFont('times','B',12);
            $pdf->Cell(40,6, 'Tonase Per Jam');
            $pdf->Cell(30,6, '= '.number_format($tonase,0,',','.').' Kg');
            $pdf->Ln(12);
        }
        
        $oven2 = $this->Model_t_kapasitas->get_operasional_mesin($tanggal, 2)->row_array();
        if($oven2){
            $pdf->Cell(70,6, 'OVEN #2');
            $pdf->Ln(6);
            $pdf->SetFont('times','B',10);
            $pdf->Cell(40,6, 'Start');
            $pdf->Cell(30,6, '= '.$oven2['jam_start']);
            $pdf->Ln(6);

            $pdf->Cell(40,6, 'Stop');
            $pdf->Cell(30,6, '= '.$oven2['jam_stop']);
            $pdf->Ln(6);
            
            $waktu_oven2 = explode(":", $oven2['waktu']);
            $pdf->Cell(40,6, 'Waktu');
            $pdf->Cell(30,6, '= '.$waktu_oven2[0]." jam ".$waktu_oven2[1]." menit = ".$oven2['waktu2']." (num)");
            $pdf->Ln(6);

            $pdf->Cell(40,6, 'Kerusakan');
            $pdf->Cell(30,6, '= 0 jam (num)');
            $pdf->Ln(6);

            $pdf->Cell(40,6, 'Total Waktu');
            $pdf->Cell(30,6, '= '.$oven2['waktu2']." (num)");
            $pdf->Ln(6);
            
            $tonase = $total_sagu_ovn_2/$oven2['waktu2'];
            $pdf->SetFont('times','B',12);
            $pdf->Cell(40,6, 'Tonase Per Jam');
            $pdf->Cell(30,6, '= '.number_format($tonase,0,',','.').' Kg');
            $pdf->Ln(12);
        }        
        $pdf->Output('Rendamen tanggal '.date('d-m-Y', strtotime($tanggal)), 'D');
    }

    function print_arus_kas(){
        $this->load->model('Model_laporan');
        require_once ("excel/PHPExcel.php");
        
        $judul   = "Lap. Arus Kas - Pabrik";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);
        
        $file->createSheet (NULL,0);
	$file->setActiveSheetIndex (0);
	$sheet = $file->getActiveSheet (0);
	$sheet->setTitle($judul);
        
        $sheet	->setCellValue ("A2", "No")
		->setCellValue ("B2", "Tanggal")
		->setCellValue ("C2", "Uraian")
		->setCellValue ("D2", "D/K")
		->setCellValue ("E2", "Debet")
                ->setCellValue ("F2", "Kredit")
                ->setCellValue ("G2", "Saldo")
                ->setCellValue ("H2", "No Referensi");
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(5);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(25);

        $sheet->getStyle('A2:H2')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));
        
        $list_data = $this->Model_laporan->list_arus_kas()->result();
        
        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo = $get_saldo['saldo_awal'];

        foreach ($list_data as $index=>$value){
            $saldo =  $saldo + ($value->kredit - $value->debet);
            $list_data[$index]->saldo = $saldo;
        }
        
        $no  = 2;
        $num = 0;
        foreach ($list_data as $index=>$value){
            $no++;
            $num++;
            $sheet  ->setCellValue ("A".$no, $num)
                    ->setCellValue ("B".$no, date('d/m/Y', strtotime($value->tanggal)))
                    ->setCellValue ("C".$no, $value->uraian)
                    ->setCellValue ("D".$no, $value->dk)
                    ->setCellValue ("E".$no, $value->debet)
                    ->setCellValue ("F".$no, $value->kredit)
                    ->setCellValue ("G".$no, $value->saldo)
                    ->setCellValue ("H".$no, $value->no_referensi);                               
        }
        $sheet->getStyle('C3:C'.$no)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A3:B'.$no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $sheet->getStyle('D3:H'.$no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $no++;
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue ("A1", 'SALDO AWAL (Rp)');
        $sheet->getStyle('A1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));

        $sheet->setCellValue ("H1", $get_saldo['saldo_awal']);
        $sheet->getStyle('H1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'faf8b4'))));

        header ('Content-Type: application/vnd.ms-excel');
	header ('Content-Disposition: attachment;filename="Lap-Arus-Kas-Pabrik.xls"'); 
	header ('Cache-Control: max-age=0');
	$writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
	$writer->save ('php://output');
    }
    
    function print_pembelian_harian(){
        $tanggal = $this->uri->segment(3);
        $this->load->model('Model_laporan');
        
        require_once ("excel/PHPExcel.php");
        $judul   = "Laporan Pembelian Harian";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);
        
        $sheet->mergeCells('A1:L1');
        $sheet->setCellValue ("A1", 'PEMBELIAN SINGKONG');
        $sheet->getStyle('A1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));

        $sheet  ->setCellValue("A2", "NO")
                ->setCellValue("B2", "NO. NOTA")
                ->setCellValue("C2", "DIBAYAR")
                ->setCellValue("D2", "TANGGAL")
                ->setCellValue("E2", "WAKTU TIMBANG")
                ->setCellValue("F2", "AGEN")
                ->setCellValue("G2", "TYPE AGEN")
                ->setCellValue("H2", "No. POLISI")
                ->setCellValue("I2", "TONASE (KG)")
                ->setCellValue("J2", "POT/ RAF (KG)")
                ->setCellValue("K2", "KADAR ACI (%)")
                ->setCellValue("L2", "HARGA (RP)");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A2:L2')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));

        $list_singkong = $this->Model_laporan->list_beli_harian('SINGKONG', $tanggal)->result();
        $total_singkong = $this->Model_laporan->sum_beli_harian('SINGKONG', $tanggal)->row_array();
        $no  = 2;
        $num = 0;
        foreach ($list_singkong as $index=>$value){
            $no++;
            $num++;
            $sheet  ->setCellValue ("A".$no, $num)
                    ->setCellValue ("B".$no, $value->no_nota)
                    ->setCellValue ("C".$no, $value->tempat_transaksi)
                    ->setCellValue ("D".$no, date('d-m-Y', strtotime($value->tanggal)))
                    ->setCellValue ("E".$no, date('h:m:s', strtotime($value->time_in)).' '.date('h:m:s', strtotime($value->time_out)))
                    ->setCellValue ("F".$no, $value->nama_agen)
                    ->setCellValue ("G".$no, $value->jenis_agen)
                    ->setCellValue ("H".$no, $value->no_kendaraan)
                    ->setCellValue ("I".$no, $value->berat_bersih)
                    ->setCellValue ("J".$no, $value->refraksi_value.' ('.$value->refraksi_faktor.' '.$value->type_potongan.')')
                    ->setCellValue ("K".$no, $value->qc03)
                    ->setCellValue ("L".$no, $value->harga);                               
        }
        $no++;
        $sheet->mergeCells('A'.$no.':H'.$no);
        $sheet->setCellValue ("A".$no, 'TOTAL (KG)');
        $sheet->getStyle('A'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));

        $sheet->setCellValue ("I".$no, $total_singkong['tot_berat_bersih']);
        $sheet->setCellValue ("J".$no, $total_singkong['tot_potongan']);
        $sheet->getStyle('I'.$no.':J'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'faf8b4'))));
        
        $no++;
        $no++;
        
        $sheet->mergeCells('A'.$no.':L'.$no);
        $sheet->setCellValue ("A".$no, 'PEMBELIAN MERAH');
        $sheet->getStyle('A'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));
        $no++;
        $sheet  ->setCellValue("A".$no, "NO")
                ->setCellValue("B".$no, "NO. NOTA")
                ->setCellValue("C".$no, "DIBAYAR")
                ->setCellValue("D".$no, "TANGGAL")
                ->setCellValue("E".$no, "WAKTU TIMBANG")
                ->setCellValue("F".$no, "AGEN")
                ->setCellValue("G".$no, "TYPE AGEN")
                ->setCellValue("H".$no, "No. POLISI")
                ->setCellValue("I".$no, "TONASE (KG)");
        
        $sheet->getStyle('A'.$no.':L'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));
        
        $list_merah  = $this->Model_laporan->list_beli_harian('MERAH', $tanggal)->result();
        $total_merah = $this->Model_laporan->sum_beli_harian('MERAH', $tanggal)->row_array();
        $num = 0;
        foreach ($list_merah as $index=>$value){
            $no++;
            $num++;
            $sheet  ->setCellValue ("A".$no, $num)
                    ->setCellValue ("B".$no, $value->no_nota)
                    ->setCellValue ("C".$no, $value->tempat_transaksi)
                    ->setCellValue ("D".$no, date('d-m-Y', strtotime($value->tanggal)))
                    ->setCellValue ("E".$no, date('h:m:s', strtotime($value->time_in)).' '.date('h:m:s', strtotime($value->time_out)))
                    ->setCellValue ("F".$no, $value->nama_agen)
                    ->setCellValue ("G".$no, $value->jenis_agen)
                    ->setCellValue ("H".$no, $value->no_kendaraan)
                    ->setCellValue ("I".$no, $value->berat_bersih);                               
        }
        $no++;
        $sheet->mergeCells('A'.$no.':H'.$no);
        $sheet->setCellValue ("A".$no, 'TOTAL (KG)');
        $sheet->getStyle('A'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));

        $sheet->setCellValue ("I".$no, $total_merah['tot_berat_bersih']);
        $sheet->getStyle('I'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'faf8b4'))));
        
        $no++;
        $no++;
        
        $sheet->mergeCells('A'.$no.':L'.$no);
        $sheet->setCellValue ("A".$no, 'PEMBELIAN CANGKANG');
        $sheet->getStyle('A'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));
        $no++;
        $sheet  ->setCellValue("A".$no, "NO")
                ->setCellValue("B".$no, "NO. NOTA")
                ->setCellValue("C".$no, "DIBAYAR")
                ->setCellValue("D".$no, "TANGGAL")
                ->setCellValue("E".$no, "WAKTU TIMBANG")
                ->setCellValue("F".$no, "AGEN")
                ->setCellValue("G".$no, "TYPE AGEN")
                ->setCellValue("H".$no, "No. POLISI")
                ->setCellValue("I".$no, "TONASE (KG)");
        
        $sheet->getStyle('A'.$no.':L'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));
        
        $list_cangkang  = $this->Model_laporan->list_beli_harian('CANGKANG', $tanggal)->result();
        $total_cangkang = $this->Model_laporan->sum_beli_harian('CANGKANG', $tanggal)->row_array();
        
        $num = 0;
        foreach ($list_cangkang as $index=>$value){
            $no++;
            $num++;
            $sheet  ->setCellValue ("A".$no, $num)
                    ->setCellValue ("B".$no, $value->no_nota)
                    ->setCellValue ("C".$no, $value->tempat_transaksi)
                    ->setCellValue ("D".$no, date('d-m-Y', strtotime($value->tanggal)))
                    ->setCellValue ("E".$no, date('h:m:s', strtotime($value->time_in)).' '.date('h:m:s', strtotime($value->time_out)))
                    ->setCellValue ("F".$no, $value->nama_agen)
                    ->setCellValue ("G".$no, $value->jenis_agen)
                    ->setCellValue ("H".$no, $value->no_kendaraan)
                    ->setCellValue ("I".$no, $value->berat_bersih);                               
        }
        $no++;
        $sheet->mergeCells('A'.$no.':H'.$no);
        $sheet->setCellValue ("A".$no, 'TOTAL (KG)');
        $sheet->getStyle('A'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));

        $sheet->setCellValue ("I".$no, $total_cangkang['tot_berat_bersih']);
        $sheet->getStyle('I'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'faf8b4'))));

        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="Laporan-Pembelian-Harian.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }
    
    function print_pembelian_bulanan(){
        $tgl_awal  = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);
        $this->load->model('Model_laporan');
        
        require_once ("excel/PHPExcel.php");
        $judul   = "Laporan Pembelian Bulanan";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);

        $sheet  ->setCellValue("A1", "NO")
                ->setCellValue("B1", "TANGGAL")
                ->setCellValue("C1", "TONASE (KG)")
                ->setCellValue("D1", "POTONGAN (KG)");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(18);

        $sheet->getStyle('A1:D1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));

        $list_data = $this->Model_laporan->list_beli_bulanan($tgl_awal, $tgl_akhir)->result();
        $total = $this->Model_laporan->sum_beli_bulanan($tgl_awal, $tgl_akhir)->row_array();        
        
        $no = 1;
        foreach ($list_data as $index=>$value){
            $no++;
            $sheet  ->setCellValue ("A".$no, $no-1)
                    ->setCellValue ("B".$no, date('d-m-Y', strtotime($value->tanggal)))
                    ->setCellValue ("C".$no, $value->berat_bersih)
                    ->setCellValue ("D".$no, $value->potongan);                             
        }
        $no++;
        $sheet->mergeCells('A'.$no.':B'.$no);
        $sheet->setCellValue ("A".$no, 'TOTAL (KG)');
        $sheet->getStyle('A'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));

        $sheet->setCellValue ("C".$no, $total['tot_berat_bersih']);
        $sheet->setCellValue ("D".$no, $total['tot_potongan']);
        $sheet->getStyle('C'.$no.':D'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'faf8b4'))));

        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="Laporan-Pembelian-Bulanan.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }
    
    function print_transaksi_kantor(){
        $tanggal = $this->uri->segment(3);
        $this->load->model('Model_laporan');
        
        require_once ("excel/PHPExcel.php");
        $judul   = "Transaksi Dibayar Kantor";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);

        $sheet  ->setCellValue("A1", "NO")
                ->setCellValue("B1", "NO. NOTA")
                ->setCellValue("C1", "DIBAYAR")
                ->setCellValue("D1", "TANGGAL")
                ->setCellValue("E1", "URAIAN")
                ->setCellValue("F1", "JUMLAH (Rp)");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getColumnDimension('F')->setWidth(15);

        $sheet->getStyle('A1:F1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));

        $list_data = $this->Model_laporan->list_transaksi_kantor($tanggal)->result();
        $total = $this->Model_laporan->sum_transaksi_kantor($tanggal)->row_array();
        
        $no = 1;
        foreach ($list_data as $index=>$value){
            $no++;
            $sheet  ->setCellValue ("A".$no, $no-1)
                    ->setCellValue ("B".$no, $value->no_nota)
                    ->setCellValue ("C".$no, $value->tempat_transaksi)
                    ->setCellValue ("D".$no, date('d-m-Y', strtotime($value->tanggal)))
                    ->setCellValue ("E".$no, $value->uraian)
                    ->setCellValue ("F".$no, $value->total_harga);                               
        }
        $sheet->getStyle('E2:E'.$no)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:D'.$no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $sheet->getStyle('F1:F'.$no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $no++;
        $sheet->mergeCells('A'.$no.':E'.$no);
        $sheet->setCellValue ("A".$no, 'TOTAL TRANSAKSI (Rp)');
        $sheet->getStyle('A'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));

        $sheet->setCellValue ("F".$no, $total['tot_jumlah']);
        $sheet->getStyle('F'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'faf8b4'))));

        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="Transaksi-Dibayar-Kantor.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }
    
    function print_transaksi_dibatalkan(){
        $tanggal = $this->uri->segment(3);
        $this->load->model('Model_laporan');
        
        require_once ("excel/PHPExcel.php");
        $judul   = "Transaksi Dibatalkan";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);

        $sheet  ->setCellValue("A1", "NO")
                ->setCellValue("B1", "NO. NOTA")
                ->setCellValue("C1", "DIBAYAR")
                ->setCellValue("D1", "TANGGAL")
                ->setCellValue("E1", "URAIAN")
                ->setCellValue("F1", "JUMLAH (Rp)");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getColumnDimension('F')->setWidth(15);

        $sheet->getStyle('A1:F1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));

        $list_data = $this->Model_laporan->list_transaksi_dibatalkan($tanggal)->result();
        $total = $this->Model_laporan->sum_transaksi_dibatalkan($tanggal)->row_array();
        
        $no = 1;
        foreach ($list_data as $index=>$value){
            $no++;
            $sheet  ->setCellValue ("A".$no, $no-1)
                    ->setCellValue ("B".$no, $value->no_nota)
                    ->setCellValue ("C".$no, $value->tempat_transaksi)
                    ->setCellValue ("D".$no, date('d-m-Y', strtotime($value->tanggal)))
                    ->setCellValue ("E".$no, $value->uraian)
                    ->setCellValue ("F".$no, $value->total_harga);                               
        }
        $sheet->getStyle('E2:E'.$no)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:D'.$no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $sheet->getStyle('F1:F'.$no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $no++;
        $sheet->mergeCells('A'.$no.':E'.$no);
        $sheet->setCellValue ("A".$no, 'TOTAL TRANSAKSI (Rp)');
        $sheet->getStyle('A'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));

        $sheet->setCellValue ("F".$no, $total['tot_jumlah']);
        $sheet->getStyle('F'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'faf8b4'))));

        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="Laporan-Transaksi-Dibatalkan.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }

    function penjualan_harian(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']= $group_id;        
        $data['judul']   = "Laporan/penjualan_harian";
        $data['content'] = "laporan/penjualan_harian";
        
        $this->load->model('Model_laporan');
        
        if (!empty($this->input->post('tanggal'))){            
            $data['parameter'] = date('Y-m-d', strtotime($this->input->post('tanggal')));
            $data['parameter_show'] = date('d-m-Y', strtotime($this->input->post('tanggal')));                       
        }else{
            $data['parameter'] = "";
            $data['parameter_show'] = date('d-m-Y');
        }
        
        $data['list_data'] = $this->Model_laporan->list_jual_harian($data['parameter'])->result();
        $data['total'] = $this->Model_laporan->sum_jual_harian($data['parameter'])->row_array();
        $this->load->view('layout', $data);
    }
    
    function print_penjualan_harian(){
        $tanggal = $this->uri->segment(3);
        $this->load->model('Model_laporan');
        
        require_once ("excel/PHPExcel.php");
        $judul   = "Laporan Penjualan Harian";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);

        $sheet  ->setCellValue("A1", "NO")
                ->setCellValue("B1", "NO. NOTA")
                ->setCellValue("C1", "JENIS SAGU")
                ->setCellValue("D1", "UNIT/SAK (Kg)")
                ->setCellValue("E1", "TANGGAL")
                ->setCellValue("F1", "WAKTU TIMBANG")
                ->setCellValue("G1", "AGEN")
                ->setCellValue("H1", "TYPE AGEN")
                ->setCellValue("I1", "No. POLISI")
                ->setCellValue("J1", "JUMLAH SAK")
                ->setCellValue("K1", "TONASE (KG)");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);

        $sheet->getStyle('A1:K1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));

        $list_data = $this->Model_laporan->list_jual_harian($tanggal)->result();
        $total = $this->Model_laporan->sum_jual_harian($tanggal)->row_array();
        $no = 1;
        foreach ($list_data as $index=>$value){
            $no++;
            $sheet  ->setCellValue ("A".$no, $no-1)
                    ->setCellValue ("B".$no, $value->no_delivery_order)
                    ->setCellValue ("C".$no, $value->merek)
                    ->setCellValue ("D".$no, $value->sak)
                    ->setCellValue ("E".$no, date('d-m-Y', strtotime($value->tanggal)))
                    ->setCellValue ("F".$no, date('h:m:s', strtotime($value->time_in)).' '.date('h:m:s', strtotime($value->time_out)))
                    ->setCellValue ("G".$no, $value->nama_agen)
                    ->setCellValue ("H".$no, $value->jenis_agen)
                    ->setCellValue ("I".$no, $value->no_kendaraan)
                    ->setCellValue ("J".$no, $value->jumlah_sak)
                    ->setCellValue ("K".$no, $value->total_berat);                               
        }
        $no++;
        $sheet->mergeCells('A'.$no.':J'.$no);
        $sheet->setCellValue ("A".$no, 'TOTAL (KG)');
        $sheet->getStyle('A'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));

        $sheet->setCellValue ("K".$no, $total['total_berat']);
        $sheet->getStyle('K'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'faf8b4'))));

        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="Laporan-Penjualan-Harian.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }
    
    function save_adjustment_kas(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $input_tgl= date('Y-m-d', strtotime($this->input->post('tanggal')));
        $jumlah   = str_replace(".", "", $this->input->post('jumlah'));
        $dk       = $this->input->post('dk');
        
        $this->db->trans_start();
        
        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo_id  = $get_saldo['id'];

        if($dk=='D'){
            $this->db->insert('t_kas', array(
                    'tanggal'=>$input_tgl,
                    'uraian'=>$this->input->post('uraian'),
                    'dk'=>$dk,
                    'debet'=>$jumlah,
                    'no_referensi'=>$this->input->post('no_referensi'),
                    'created'=>$tanggal,
                    'created_by'=>$user_id,
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id
            ));
            $saldo = $get_saldo['saldo_sekarang'] - $jumlah;
        }else{
            $this->db->insert('t_kas', array(
                    'tanggal'=>$input_tgl,
                    'uraian'=>$this->input->post('uraian'),
                    'dk'=>$dk,
                    'kredit'=>$jumlah,
                    'no_referensi'=>$this->input->post('no_referensi'),
                    'created'=>$tanggal,
                    'created_by'=>$user_id,
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id
            ));
            $saldo = $get_saldo['saldo_sekarang'] + $jumlah;
        }
        $this->db->where('id', $saldo_id);
        $this->db->update('t_saldo', array('saldo_sekarang'=>$saldo)); 
        
        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Data berhasil disimpan');
            redirect('index.php/Laporan/arus_kas');   
        }else{
            echo "Terjadi kesalahan saat menyimpan data...";
            echo "<pre>"; die(var_dump($this->input->post()));
        } 
    }
    
    function otorisasi(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/otorisasi";
        $data['content']= "laporan/otorisasi";
        
        if (!empty($this->input->post('tgl_awal'))){            
            $data['tgl_awal'] = date('Y-m-d', strtotime($this->input->post('tgl_awal')));
            $data['tgl_awal_show'] = date('d-m-Y', strtotime($this->input->post('tgl_awal')));
            
            $data['tgl_akhir'] = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
            $data['tgl_akhir_show'] = date('d-m-Y', strtotime($this->input->post('tgl_akhir')));
        }else{
            $data['tgl_awal'] = "";
            $data['tgl_awal_show'] = date('d-m-Y');
            
            $data['tgl_akhir'] = "";
            $data['tgl_akhir_show'] = date('d-m-Y');;
        }
        $this->load->model('Model_laporan');
        $data['list_data'] = $this->Model_laporan->list_otorisasi($data['tgl_awal'], $data['tgl_akhir'])->result();

        $this->load->view('layout', $data);
    }
    
    function print_otorisasi(){
        $tgl_awal  = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);
        $this->load->model('Model_laporan');
        
        require_once ("excel/PHPExcel.php");
        $judul   = "Laporan Otorisasi Kendaraan";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);

        $sheet  ->setCellValue("A1", "NO")
                ->setCellValue("B1", "TANGGAL")
                ->setCellValue("C1", "JAM MASUK")
                ->setCellValue("D1", "TRANSAKSI")
                ->setCellValue("E1", "AGEN")
                ->setCellValue("F1", "NO. KENDARAAN")
                ->setCellValue("G1", "SUPIR")
                ->setCellValue("H1", "MUATAN")
                ->setCellValue("I1", "STATUS")
                ->setCellValue("J1", "WAKTU TIMBANG 1")
                ->setCellValue("K1", "WAKTU TIMBANG 2");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(22);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(30);
        $sheet->getColumnDimension('K')->setWidth(30);

        $sheet->getStyle('A1:K1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));

        $list_data = $this->Model_laporan->list_otorisasi($tgl_awal, $tgl_akhir)->result();        
        $status = array(1=>'Masuk', 2=>'Timbang 1', 3=>'Timbang 2', 9=>'Keluar');
        $no = 1;
        foreach ($list_data as $index=>$value){
            if($value->nama_muatan=="LAIN-LAIN"){
                $muatan = $value->deskripsi;
            }else{
                if(!empty($value->nama_muatan)){
                    $muatan = $value->nama_muatan;
                }else{
                    $myMuatan = trim(str_replace(" ", "", $value->deskripsi), "\n");
                    if(empty($myMuatan)){
                        $muatan = "Kendaraan Kosong";
                    }else{
                        $muatan = $value->deskripsi;                                
                    }
                }
            }
            $mydurasi1 = "";
            if($value->start_timbang_1!="0000-00-00 00:00:00"){
                $start1  = new DateTime($value->start_timbang_1);
                $end1    = new DateTime($value->end_timbang_1);
                $durasi1 = $end1->diff($start1);
                $jam1    = $durasi1->format('%h');
                $menit1  = $durasi1->format('%i');
                $detik1  = $durasi1->format('%s');                
                if($jam1>0){
                    $mydurasi1 .= $jam1." jam ";
                }
                if($menit1>0){
                    $mydurasi1 .= $menit1." menit ";
                }
                if($detik1>0){
                    $mydurasi1 .= $detik1." detik ";
                }
                $mydurasi1 .= "(".date('h:m:s', strtotime($value->start_timbang_1))." s/d ";
                $mydurasi1 .= date('h:m:s', strtotime($value->end_timbang_1)).")";
            } 
            $mydurasi2 = "";
            if($value->start_timbang_2!="0000-00-00 00:00:00"){
                $start2  = new DateTime($value->start_timbang_2);
                $end2    = new DateTime($value->end_timbang_2);
                $durasi2 = $end2->diff($start2);
                $jam2    = $durasi2->format('%h');
                $menit2  = $durasi2->format('%i');
                $detik2  = $durasi2->format('%s');
                
                if($jam2){
                    $mydurasi2 .= $jam2." jam ";
                }
                if($menit2>0){
                    $mydurasi2 .= $menit2." menit ";
                }
                if($detik2>0){
                    $mydurasi2 .= $detik2." detik ";
                }
                $mydurasi2 .= "(".date('h:m:s', strtotime($value->start_timbang_2))." s/d ";
                $mydurasi2 .= date('h:m:s', strtotime($value->end_timbang_2)).")";
            } 
            $no++;
            $sheet  ->setCellValue ("A".$no, $no-1)
                    ->setCellValue ("B".$no, date('d-m-Y', strtotime($value->time_in)))
                    ->setCellValue ("C".$no, date('h:m', strtotime($value->time_in)))
                    ->setCellValue ("D".$no, $value->jenis_transaksi)
                    ->setCellValue ("E".$no, $value->nama_agen.((!empty($value->jenis_agen))? " (".$value->jenis_agen.")": ""))
                    ->setCellValue ("F".$no, $value->no_kendaraan." -- ".$value->type_kendaraan)
                    ->setCellValue ("G".$no, $value->supir)
                    ->setCellValue ("H".$no, $muatan)
                    ->setCellValue ("I".$no, $status[$value->status])
                    ->setCellValue ("J".$no, $mydurasi1)
                    ->setCellValue ("K".$no, $mydurasi2);                             
        }
        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="Laporan-Otorisasi-Kendaraan.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }
    
    function hasil_oven(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/hasil_oven";
        $data['content']= "laporan/hasil_oven";
        
        if (!empty($this->input->post('tgl_awal'))){            
            $data['tgl_awal'] = date('Y-m-d', strtotime($this->input->post('tgl_awal')));
            $data['tgl_awal_show'] = date('d-m-Y', strtotime($this->input->post('tgl_awal')));
            
            $data['tgl_akhir'] = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
            $data['tgl_akhir_show'] = date('d-m-Y', strtotime($this->input->post('tgl_akhir')));
        }else{
            $data['tgl_awal'] = "";
            $data['tgl_awal_show'] = date('d-m-Y');
            
            $data['tgl_akhir'] = "";
            $data['tgl_akhir_show'] = date('d-m-Y');;
        }
        $this->load->model('Model_laporan');
        $data['list_data'] = $this->Model_laporan->list_hasil_oven($data['tgl_awal'], $data['tgl_akhir'])->result();
        
        $this->load->model('Model_t_oven');
        $data['list_giling'] = $this->Model_t_oven->list_giling()->result();
        $data['list_cv'] = $this->Model_t_oven->list_cv()->result();

        $this->load->view('layout', $data); 
    }
    
    function print_hasil_oven(){
        $tgl_awal  = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);
        $this->load->model('Model_laporan');
        
        require_once ("excel/PHPExcel.php");
        $judul   = "Laporan Hasil Oven";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);

        $sheet  ->setCellValue("A1", "NO")
                ->setCellValue("B1", "TANGGAL")
                ->setCellValue("C1", "NO. GILING")
                ->setCellValue("D1", "OVEN")
                ->setCellValue("E1", "SAK")
                ->setCellValue("F1", "PULAU (KG)")
                ->setCellValue("G1", "KWR (KG)")
                ->setCellValue("H1", "PH (KG)")
                ->setCellValue("I1", "POLOS (KG)")
                ->setCellValue("J1", "TOTAL (KG)")
                ->setCellValue("K1", "ASSIGN KE CV");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(8);
        $sheet->getColumnDimension('E')->setWidth(5);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(22);

        $sheet->getStyle('A1:K1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));

        $list_data = $this->Model_laporan->list_hasil_oven($tgl_awal, $tgl_akhir)->result();        
        $no = 1;
        foreach ($list_data as $index=>$value){           
            $no++;
            $sheet  ->setCellValue ("A".$no, $no-1)
                    ->setCellValue ("B".$no, date('d-m-Y', strtotime($value->tanggal)))
                    ->setCellValue ("C".$no, $value->no_giling)
                    ->setCellValue ("D".$no, $value->oven)
                    ->setCellValue ("E".$no, $value->sak)
                    ->setCellValue ("F".$no, $value->sagu_pulau)
                    ->setCellValue ("G".$no, $value->sagu_kwr)
                    ->setCellValue ("H".$no, $value->sagu_ph)
                    ->setCellValue ("I".$no, $value->sagu_polos)
                    ->setCellValue ("J".$no, $value->total)
                    ->setCellValue ("K".$no, $value->nama_cv);                             
        }
        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="Laporan-Hasil-Oven.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }
    
    function sisa_produksi(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/sisa_produksi";
        $data['content']= "laporan/sisa_produksi";
        
        if (!empty($this->input->post('tgl_awal'))){            
            $data['tgl_awal'] = date('Y-m-d', strtotime($this->input->post('tgl_awal')));
            $data['tgl_awal_show'] = date('d-m-Y', strtotime($this->input->post('tgl_awal')));
            
            $data['tgl_akhir'] = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
            $data['tgl_akhir_show'] = date('d-m-Y', strtotime($this->input->post('tgl_akhir')));
        }else{
            $data['tgl_awal'] = "";
            $data['tgl_awal_show'] = date('d-m-Y');
            
            $data['tgl_akhir'] = "";
            $data['tgl_akhir_show'] = date('d-m-Y');;
        }
        $this->load->model('Model_laporan');
        $data['list_data'] = $this->Model_laporan->list_sisa_produksi($data['tgl_awal'], $data['tgl_akhir'])->result();

        $this->load->view('layout', $data); 
    }
    
    function print_sisa_produksi(){
        $tgl_awal  = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);
        $this->load->model('Model_laporan');
        
        require_once ("excel/PHPExcel.php");
        $judul   = "Laporan Sisa Produksi";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);

        $sheet  ->setCellValue("A1", "NO")
                ->setCellValue("B1", "TANGGAL")
                ->setCellValue("C1", "OVEN")
                ->setCellValue("D1", "SAK")
                ->setCellValue("E1", "SISA (QTY)")
                ->setCellValue("F1", "SISA (KG)");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(5);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);

        $sheet->getStyle('A1:F1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));

        $list_data = $this->Model_laporan->list_sisa_produksi($tgl_awal, $tgl_akhir)->result();        
        $no = 1;
        foreach ($list_data as $index=>$value){           
            $no++;
            $sheet  ->setCellValue ("A".$no, $no-1)
                    ->setCellValue ("B".$no, date('d-m-Y', strtotime($value->tanggal)))
                    ->setCellValue ("C".$no, $value->oven)
                    ->setCellValue ("D".$no, $value->sak)
                    ->setCellValue ("E".$no, $value->sisa_sak)
                    ->setCellValue ("F".$no, $value->jumlah);                             
        }
        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="Laporan-Sisa-Produksi.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }
    
    function kapasitas_mesin(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/kapasitas_mesin";
        $data['content']= "laporan/kapasitas_mesin";
        
        if (!empty($this->input->post('tgl_awal'))){            
            $data['tgl_awal'] = date('Y-m-d', strtotime($this->input->post('tgl_awal')));
            $data['tgl_awal_show'] = date('d-m-Y', strtotime($this->input->post('tgl_awal')));
            
            $data['tgl_akhir'] = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
            $data['tgl_akhir_show'] = date('d-m-Y', strtotime($this->input->post('tgl_akhir')));
        }else{
            $data['tgl_awal'] = "";
            $data['tgl_awal_show'] = date('d-m-Y');
            
            $data['tgl_akhir'] = "";
            $data['tgl_akhir_show'] = date('d-m-Y');;
        }
        $this->load->model('Model_laporan');
        $data['list_data'] = $this->Model_laporan->list_kapasitas_mesin($data['tgl_awal'], $data['tgl_akhir'])->result();

        $this->load->view('layout', $data); 
    }
    
    function print_kapasitas_mesin(){
        $tgl_awal  = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);
        $this->load->model('Model_laporan');
        
        require_once ("excel/PHPExcel.php");
        $judul   = "Laporan Kapasitas Mesin";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);

        $sheet  ->setCellValue("A1", "NO")
                ->setCellValue("B1", "TANGGAL START")
                ->setCellValue("C1", "JAM START")
                ->setCellValue("D1", "DELAY (MENIT)")
                ->setCellValue("E1", "TANGGAL STOP")
                ->setCellValue("F1", "JAM STOP")
                ->setCellValue("g1", "WAKTU OPERASIONAL");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(16);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(20);

        $sheet->getStyle('A1:G1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));

        $list_data = $this->Model_laporan->list_kapasitas_mesin($tgl_awal, $tgl_akhir)->result();        
        $no = 1;
        foreach ($list_data as $index=>$value){           
            $no++;
            $sheet  ->setCellValue ("A".$no, $no-1)
                    ->setCellValue ("B".$no, date('d-m-Y', strtotime($value->tanggal_start)))
                    ->setCellValue ("C".$no, $value->jam_start)
                    ->setCellValue ("D".$no, $value->delay)
                    ->setCellValue ("E".$no, date('d-m-Y', strtotime($value->tanggal_stop)))
                    ->setCellValue ("F".$no, $value->jam_stop)
                    ->setCellValue ("G".$no, $value->waktu." (".$value->waktu2.")");                             
        }
        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="Laporan-Kapasitas-Mesin.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }
    
    function kapasitas_oven(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/kapasitas_oven";
        $data['content']= "laporan/kapasitas_oven";
        
        if (!empty($this->input->post('tgl_awal'))){            
            $data['tgl_awal'] = date('Y-m-d', strtotime($this->input->post('tgl_awal')));
            $data['tgl_awal_show'] = date('d-m-Y', strtotime($this->input->post('tgl_awal')));
            
            $data['tgl_akhir'] = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
            $data['tgl_akhir_show'] = date('d-m-Y', strtotime($this->input->post('tgl_akhir')));
        }else{
            $data['tgl_awal'] = "";
            $data['tgl_awal_show'] = date('d-m-Y');
            
            $data['tgl_akhir'] = "";
            $data['tgl_akhir_show'] = date('d-m-Y');;
        }
        $this->load->model('Model_laporan');
        $data['list_data'] = $this->Model_laporan->list_kapasitas_oven($data['tgl_awal'], $data['tgl_akhir'])->result();

        $this->load->view('layout', $data); 
    }
    
    function print_kapasitas_oven(){
        $tgl_awal  = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);
        $this->load->model('Model_laporan');
        
        require_once ("excel/PHPExcel.php");
        $judul   = "Laporan Kapasitas Oven";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);

        $sheet  ->setCellValue("A1", "NO")
                ->setCellValue("B1", "TANGGAL START")
                ->setCellValue("C1", "JAM START")
                ->setCellValue("D1", "DELAY (MENIT)")
                ->setCellValue("E1", "TANGGAL STOP")
                ->setCellValue("F1", "JAM STOP")
                ->setCellValue("g1", "WAKTU OPERASIONAL");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(16);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(20);

        $sheet->getStyle('A1:G1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));

        $list_data = $this->Model_laporan->list_kapasitas_oven($tgl_awal, $tgl_akhir)->result();        
        $no = 1;
        foreach ($list_data as $index=>$value){           
            $no++;
            $sheet  ->setCellValue ("A".$no, $no-1)
                    ->setCellValue ("B".$no, date('d-m-Y', strtotime($value->tanggal_start)))
                    ->setCellValue ("C".$no, $value->jam_start)
                    ->setCellValue ("D".$no, $value->delay)
                    ->setCellValue ("E".$no, date('d-m-Y', strtotime($value->tanggal_stop)))
                    ->setCellValue ("F".$no, $value->jam_stop)
                    ->setCellValue ("G".$no, $value->waktu." (".$value->waktu2.")");                             
        }
        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="Laporan-Kapasitas-Oven.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }
    
    function print_giling_harian(){
        $tanggal = $this->uri->segment(3);
        $this->load->model('Model_laporan');
        
        require_once ("excel/PHPExcel.php");
        $judul   = "Laporan Giling Harian";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);

        $sheet  ->setCellValue("A1", "NO")
                ->setCellValue("B1", "NO. GILING")
                ->setCellValue("C1", "TANGGAL")
                ->setCellValue("D1", "BERAT DIPROSES (Kg)")
                ->setCellValue("E1", "ASSIGN KE CV");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);

        $sheet->getStyle('A1:E1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));

        $list_data = $this->Model_laporan->list_giling_harian($tanggal)->result();
        $no = 1;
        foreach ($list_data as $index=>$value){
            $no++;
            $sheet  ->setCellValue ("A".$no, $no-1)
                    ->setCellValue ("B".$no, $value->no_giling)
                    ->setCellValue ("C".$no, date('d-m-Y', strtotime($value->tanggal)))
                    ->setCellValue ("D".$no, $value->berat_diproses)
                    ->setCellValue ("E".$no, $value->nama_cv);                               
        }

        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="Laporan-Giling-Harian.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }
    
    function limbah_harian(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/limbah_harian";
        $data['content']= "laporan/limbah_harian";
        
        if (!empty($this->input->post('tgl_awal'))){            
            $data['tgl_awal'] = date('Y-m-d', strtotime($this->input->post('tgl_awal')));
            $data['tgl_awal_show'] = date('d-m-Y', strtotime($this->input->post('tgl_awal')));
            
            $data['tgl_akhir'] = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
            $data['tgl_akhir_show'] = date('d-m-Y', strtotime($this->input->post('tgl_akhir')));
        }else{
            $data['tgl_awal'] = "";
            $data['tgl_awal_show'] = date('d-m-Y');
            
            $data['tgl_akhir'] = "";
            $data['tgl_akhir_show'] = date('d-m-Y');;
        }
        $this->load->model('Model_laporan');
        $data['list_data'] = $this->Model_laporan->list_limbah($data['tgl_awal'], $data['tgl_akhir'])->result();

        $this->load->view('layout', $data);
    }
    
    function print_limbah_harian(){
        $tgl_awal  = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);
        $this->load->model('Model_laporan');
        
        require_once ("excel/PHPExcel.php");
        $judul   = "Laporan Limbah Harian";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);

        $sheet  ->setCellValue("A1", "NO")
                ->setCellValue("B1", "TANGGAL")
                ->setCellValue("C1", "JUMLAH JEMUR (KG)")
                ->setCellValue("D1", "JUMLAH PANEN (KG)")
                ->setCellValue("E1", "JUMLAH JUAL (KG)")
                ->setCellValue("F1", "JUMLAH SUMBANGAN (KG)");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);

        $sheet->getStyle('A1:F1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));

        $list_data = $this->Model_laporan->list_limbah($tgl_awal, $tgl_akhir)->result();        
        $no = 1;
        foreach ($list_data as $index=>$value){            
            $no++;
            $sheet  ->setCellValue ("A".$no, $no-1)
                    ->setCellValue ("B".$no, date('d-m-Y', strtotime($value->tanggal)))
                    ->setCellValue ("C".$no, $value->jml_jemur)
                    ->setCellValue ("D".$no, $value->jml_panen)
                    ->setCellValue ("E".$no, $value->jml_jual)
                    ->setCellValue ("F".$no, $value->jml_sumbang);                             
        }
        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="Laporan-Limbah-Harian.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }
    
    function arus_kas_limbah(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/arus_kas_limbah";
        $data['content']= "laporan/arus_kas_limbah";
        $this->load->model('Model_laporan');
        $data['list_data'] = $this->Model_laporan->list_arus_kas_limbah()->result();
        
        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo = $get_saldo['saldo_awal_limbah'];
        $data['saldo'] = $saldo;

        foreach ($data['list_data'] as $index=>$value){
            $saldo =  $saldo + ($value->kredit - $value->debet);
            $data['list_data'][$index]->saldo = $saldo;
        }

        $this->load->view('layout', $data);
    }
    
    function arus_kas_cv(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/arus_kas_cv";
        $data['content']= "laporan/arus_kas_cv";
        $this->load->model('Model_laporan');
        $data['list_data'] = $this->Model_laporan->list_arus_kas_cv()->result();
        
        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo = $get_saldo['saldo_awal_cv'];
        $data['saldo'] = $saldo;

        foreach ($data['list_data'] as $index=>$value){
            $saldo =  $saldo + ($value->kredit - $value->debet);
            $data['list_data'][$index]->saldo = $saldo;
        }

        $this->load->view('layout', $data);
    }
    
    function arus_kas_kantor(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/arus_kas_kantor";
        $data['content']= "laporan/arus_kas_kantor";
        $this->load->model('Model_laporan');
        $data['list_data'] = $this->Model_laporan->list_arus_kas_kantor()->result();
        
        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo = $get_saldo['saldo_awal_kantor'];
        $data['saldo'] = $saldo;

        foreach ($data['list_data'] as $index=>$value){
            $saldo =  $saldo + ($value->kredit - $value->debet);
            $data['list_data'][$index]->saldo = $saldo;
        }

        $this->load->view('layout', $data);
    }
    
    function save_adjustment_kas_limbah(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $input_tgl= date('Y-m-d', strtotime($this->input->post('tanggal')));
        $jumlah   = str_replace(".", "", $this->input->post('jumlah'));
        $dk       = $this->input->post('dk');
        
        $this->db->trans_start();
        
        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo_id  = $get_saldo['id'];

        if($dk=='D'){
            $this->db->insert('t_kas_limbah', array(
                    'tanggal'=>$input_tgl,
                    'uraian'=>$this->input->post('uraian'),
                    'dk'=>$dk,
                    'debet'=>$jumlah,
                    'no_referensi'=>$this->input->post('no_referensi'),
                    'created'=>$tanggal,
                    'created_by'=>$user_id,
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id
            ));
            $saldo = $get_saldo['saldo_akhir_limbah'] - $jumlah;
        }else{
            $this->db->insert('t_kas_limbah', array(
                    'tanggal'=>$input_tgl,
                    'uraian'=>$this->input->post('uraian'),
                    'dk'=>$dk,
                    'kredit'=>$jumlah,
                    'no_referensi'=>$this->input->post('no_referensi'),
                    'created'=>$tanggal,
                    'created_by'=>$user_id,
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id
            ));
            $saldo = $get_saldo['saldo_akhir_limbah'] + $jumlah;
        }
        $this->db->where('id', $saldo_id);
        $this->db->update('t_saldo', array('saldo_akhir_limbah'=>$saldo)); 
        
        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Data berhasil disimpan');
            redirect('index.php/Laporan/arus_kas_limbah');   
        }else{
            echo "Terjadi kesalahan saat menyimpan data...";
            echo "<pre>"; die(var_dump($this->input->post()));
        } 
    }
    
    function save_adjustment_kas_cv(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $input_tgl= date('Y-m-d', strtotime($this->input->post('tanggal')));
        $jumlah   = str_replace(".", "", $this->input->post('jumlah'));
        $dk       = $this->input->post('dk');
        
        $this->db->trans_start();
        
        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo_id  = $get_saldo['id'];

        if($dk=='D'){
            $this->db->insert('t_kas_cv', array(
                    'tanggal'=>$input_tgl,
                    'uraian'=>$this->input->post('uraian'),
                    'dk'=>$dk,
                    'debet'=>$jumlah,
                    'no_referensi'=>$this->input->post('no_referensi'),
                    'created'=>$tanggal,
                    'created_by'=>$user_id,
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id
            ));
            $saldo = $get_saldo['saldo_akhir_cv'] - $jumlah;
        }else{
            $this->db->insert('t_kas_cv', array(
                    'tanggal'=>$input_tgl,
                    'uraian'=>$this->input->post('uraian'),
                    'dk'=>$dk,
                    'kredit'=>$jumlah,
                    'no_referensi'=>$this->input->post('no_referensi'),
                    'created'=>$tanggal,
                    'created_by'=>$user_id,
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id
            ));
            $saldo = $get_saldo['saldo_akhir_cv'] + $jumlah;
        }
        $this->db->where('id', $saldo_id);
        $this->db->update('t_saldo', array('saldo_akhir_cv'=>$saldo)); 
        
        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Data berhasil disimpan');
            redirect('index.php/Laporan/arus_kas_cv');   
        }else{
            echo "Terjadi kesalahan saat menyimpan data...";
            echo "<pre>"; die(var_dump($this->input->post()));
        } 
    }
    
    function save_adjustment_kas_kantor(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $input_tgl= date('Y-m-d', strtotime($this->input->post('tanggal')));
        $jumlah   = str_replace(".", "", $this->input->post('jumlah'));
        $dk       = $this->input->post('dk');
        
        $this->db->trans_start();
        
        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo_id  = $get_saldo['id'];

        if($dk=='D'){
            $this->db->insert('t_kas_kantor', array(
                    'tanggal'=>$input_tgl,
                    'uraian'=>$this->input->post('uraian'),
                    'dk'=>$dk,
                    'debet'=>$jumlah,
                    'no_referensi'=>$this->input->post('no_referensi'),
                    'created'=>$tanggal,
                    'created_by'=>$user_id,
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id
            ));
            $saldo = $get_saldo['saldo_akhir_kantor'] - $jumlah;
        }else{
            $this->db->insert('t_kas_limbah', array(
                    'tanggal'=>$input_tgl,
                    'uraian'=>$this->input->post('uraian'),
                    'dk'=>$dk,
                    'kredit'=>$jumlah,
                    'no_referensi'=>$this->input->post('no_referensi'),
                    'created'=>$tanggal,
                    'created_by'=>$user_id,
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id
            ));
            $saldo = $get_saldo['saldo_akhir_kantor'] + $jumlah;
        }
        $this->db->where('id', $saldo_id);
        $this->db->update('t_saldo', array('saldo_akhir_kantor'=>$saldo)); 
        
        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Data berhasil disimpan');
            redirect('index.php/Laporan/arus_kas_kantor');   
        }else{
            echo "Terjadi kesalahan saat menyimpan data...";
            echo "<pre>"; die(var_dump($this->input->post()));
        } 
    }
    
    function print_arus_kas_limbah(){
        $this->load->model('Model_laporan');
        require_once ("excel/PHPExcel.php");
        
        $judul   = "Lap. Arus Kas - Limbah";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);
        
        $file->createSheet (NULL,0);
	$file->setActiveSheetIndex (0);
	$sheet = $file->getActiveSheet (0);
	$sheet->setTitle($judul);
        
        $sheet	->setCellValue ("A2", "No")
		->setCellValue ("B2", "Tanggal")
		->setCellValue ("C2", "Uraian")
		->setCellValue ("D2", "D/K")
		->setCellValue ("E2", "Debet")
                ->setCellValue ("F2", "Kredit")
                ->setCellValue ("G2", "Saldo")
                ->setCellValue ("H2", "No Referensi");
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(5);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(25);

        $sheet->getStyle('A2:H2')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));
        
        $list_data = $this->Model_laporan->list_arus_kas_limbah()->result();
        
        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo = $get_saldo['saldo_awal_limbah'];

        foreach ($list_data as $index=>$value){
            $saldo =  $saldo + ($value->kredit - $value->debet);
            $list_data[$index]->saldo = $saldo;
        }
        
        $no  = 2;
        $num = 0;
        foreach ($list_data as $index=>$value){
            $no++;
            $num++;
            $sheet  ->setCellValue ("A".$no, $num)
                    ->setCellValue ("B".$no, date('d/m/Y', strtotime($value->tanggal)))
                    ->setCellValue ("C".$no, $value->uraian)
                    ->setCellValue ("D".$no, $value->dk)
                    ->setCellValue ("E".$no, $value->debet)
                    ->setCellValue ("F".$no, $value->kredit)
                    ->setCellValue ("G".$no, $value->saldo)
                    ->setCellValue ("H".$no, $value->no_referensi);                               
        }
        $sheet->getStyle('C3:C'.$no)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A3:B'.$no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $sheet->getStyle('D3:H'.$no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $no++;
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue ("A1", 'SALDO AWAL (Rp)');
        $sheet->getStyle('A1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));

        $sheet->setCellValue ("H1", $get_saldo['saldo_awal_limbah']);
        $sheet->getStyle('H1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'faf8b4'))));

        header ('Content-Type: application/vnd.ms-excel');
	header ('Content-Disposition: attachment;filename="Lap-Arus-Kas-Limbah.xls"'); 
	header ('Cache-Control: max-age=0');
	$writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
	$writer->save ('php://output');
    }
    
    function print_arus_kas_cv(){
        $this->load->model('Model_laporan');
        require_once ("excel/PHPExcel.php");
        
        $judul   = "Lap. Arus Kas - Pembelian";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);
        
        $file->createSheet (NULL,0);
	$file->setActiveSheetIndex (0);
	$sheet = $file->getActiveSheet (0);
	$sheet->setTitle($judul);
        
        $sheet	->setCellValue ("A2", "No")
		->setCellValue ("B2", "Tanggal")
		->setCellValue ("C2", "Uraian")
		->setCellValue ("D2", "D/K")
		->setCellValue ("E2", "Debet")
                ->setCellValue ("F2", "Kredit")
                ->setCellValue ("G2", "Saldo")
                ->setCellValue ("H2", "No Referensi");
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(5);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(25);

        $sheet->getStyle('A2:H2')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));
        
        $list_data = $this->Model_laporan->list_arus_kas_cv()->result();
        
        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo = $get_saldo['saldo_awal_cv'];

        foreach ($list_data as $index=>$value){
            $saldo =  $saldo + ($value->kredit - $value->debet);
            $list_data[$index]->saldo = $saldo;
        }
        
        $no  = 2;
        $num = 0;
        foreach ($list_data as $index=>$value){
            $no++;
            $num++;
            $sheet  ->setCellValue ("A".$no, $num)
                    ->setCellValue ("B".$no, date('d/m/Y', strtotime($value->tanggal)))
                    ->setCellValue ("C".$no, $value->uraian)
                    ->setCellValue ("D".$no, $value->dk)
                    ->setCellValue ("E".$no, $value->debet)
                    ->setCellValue ("F".$no, $value->kredit)
                    ->setCellValue ("G".$no, $value->saldo)
                    ->setCellValue ("H".$no, $value->no_referensi);                               
        }
        $sheet->getStyle('C3:C'.$no)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A3:B'.$no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $sheet->getStyle('D3:H'.$no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $no++;
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue ("A1", 'SALDO AWAL (Rp)');
        $sheet->getStyle('A1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));

        $sheet->setCellValue ("H1", $get_saldo['saldo_awal_cv']);
        $sheet->getStyle('H1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'faf8b4'))));

        header ('Content-Type: application/vnd.ms-excel');
	header ('Content-Disposition: attachment;filename="Lap-Arus-Kas-CV.xls"'); 
	header ('Cache-Control: max-age=0');
	$writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
	$writer->save ('php://output');
    }
    
    function print_arus_kas_kantor(){
        $this->load->model('Model_laporan');
        require_once ("excel/PHPExcel.php");
        
        $judul   = "Lap. Arus Kas - Kantor";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);
        
        $file->createSheet (NULL,0);
	$file->setActiveSheetIndex (0);
	$sheet = $file->getActiveSheet (0);
	$sheet->setTitle($judul);
        
        $sheet	->setCellValue ("A2", "No")
		->setCellValue ("B2", "Tanggal")
		->setCellValue ("C2", "Uraian")
		->setCellValue ("D2", "D/K")
		->setCellValue ("E2", "Debet")
                ->setCellValue ("F2", "Kredit")
                ->setCellValue ("G2", "Saldo")
                ->setCellValue ("H2", "No Referensi");
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(5);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(25);

        $sheet->getStyle('A2:H2')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));
        
        $list_data = $this->Model_laporan->list_arus_kas_kantor()->result();
        
        $this->load->model('Model_kas');
        $get_saldo = $this->Model_kas->get_saldo()->row_array();
        $saldo = $get_saldo['saldo_awal_kantor'];

        foreach ($list_data as $index=>$value){
            $saldo =  $saldo + ($value->kredit - $value->debet);
            $list_data[$index]->saldo = $saldo;
        }
        
        $no  = 2;
        $num = 0;
        foreach ($list_data as $index=>$value){
            $no++;
            $num++;
            $sheet  ->setCellValue ("A".$no, $num)
                    ->setCellValue ("B".$no, date('d/m/Y', strtotime($value->tanggal)))
                    ->setCellValue ("C".$no, $value->uraian)
                    ->setCellValue ("D".$no, $value->dk)
                    ->setCellValue ("E".$no, $value->debet)
                    ->setCellValue ("F".$no, $value->kredit)
                    ->setCellValue ("G".$no, $value->saldo)
                    ->setCellValue ("H".$no, $value->no_referensi);                               
        }
        $sheet->getStyle('C3:C'.$no)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A3:B'.$no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $sheet->getStyle('D3:H'.$no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $no++;
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue ("A1", 'SALDO AWAL (Rp)');
        $sheet->getStyle('A1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));

        $sheet->setCellValue ("H1", $get_saldo['saldo_awal_kantor']);
        $sheet->getStyle('H1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'faf8b4'))));

        header ('Content-Type: application/vnd.ms-excel');
	header ('Content-Disposition: attachment;filename="Lap-Arus-Kas-Kantor.xls"'); 
	header ('Cache-Control: max-age=0');
	$writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
	$writer->save ('php://output');
    }
    
    function tagihan_ekspedisi(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/tagihan_ekspedisi";
        $data['content']= "laporan/tagihan_ekspedisi";
        
        if (!empty($this->input->post('tgl_awal'))){            
            $data['tgl_awal'] = date('Y-m-d', strtotime($this->input->post('tgl_awal')));
            $data['tgl_awal_show'] = date('d-m-Y', strtotime($this->input->post('tgl_awal')));
            
            $data['tgl_akhir'] = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
            $data['tgl_akhir_show'] = date('d-m-Y', strtotime($this->input->post('tgl_akhir')));
        }else{
            $data['tgl_awal'] = "";
            $data['tgl_awal_show'] = date('d-m-Y');
            
            $data['tgl_akhir'] = "";
            $data['tgl_akhir_show'] = date('d-m-Y');;
        }
        $this->load->model('Model_laporan');
        $data['list_data'] = $this->Model_laporan->list_tagihan_ekspedisi($data['tgl_awal'], $data['tgl_akhir'])->result();
        $data['total'] = $this->Model_laporan->sum_tagihan_ekspedisi($data['tgl_awal'], $data['tgl_akhir'])->row_array();

        $this->load->view('layout', $data);
    }
    
    function print_tagihan_ekspedisi(){
        $tgl_awal  = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);
        $this->load->model('Model_laporan');
        
        require_once ("excel/PHPExcel.php");
        $judul   = "Lap. Tagihan Ekspedisi CV";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);

        $sheet  ->setCellValue("A1", "NO")
                ->setCellValue("B1", "TANGGAL")
                ->setCellValue("C1", "NAMA CV")
                ->setCellValue("D1", "EKSPEDISI")
                ->setCellValue("E1", "NO. DELIVERY ORDER")
                ->setCellValue("F1", "CUSTOMER")
                ->setCellValue("G1", "BERAT (KG)")
                ->setCellValue("H1", "JUMLAH TAGIHAN (RP)")
                ->setCellValue("I1", "STATUS");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(22);
        $sheet->getColumnDimension('I')->setWidth(18);

        $sheet->getStyle('A1:I1')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));

        $list_data = $this->Model_laporan->list_tagihan_ekspedisi($tgl_awal, $tgl_akhir)->result();
        $total = $this->Model_laporan->sum_tagihan_ekspedisi($tgl_awal, $tgl_akhir)->row_array();        
        
        $no = 1;
        foreach ($list_data as $index=>$value){
            $no++;
            $sheet  ->setCellValue ("A".$no, $no-1)
                    ->setCellValue ("B".$no, date('d-m-Y', strtotime($value->tanggal)))
                    ->setCellValue ("C".$no, $value->nama_cv)
                    ->setCellValue ("D".$no, $value->nama_ekspedisi)
                    ->setCellValue ("E".$no, $value->no_delivery_order)
                    ->setCellValue ("F".$no, $value->nama_customer)
                    ->setCellValue ("G".$no, $value->berat)
                    ->setCellValue ("H".$no, $value->jumlah)
                    ->setCellValue ("I".$no, (($value->flag_bayar==1)? 'Sudah dibayar': 'Belum dibayar'));                             
        }
        $no++;
        $sheet->mergeCells('A'.$no.':G'.$no);
        $sheet->setCellValue ("A".$no, 'TOTAL (Rp)');
        $sheet->getStyle('A'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));

        $sheet->setCellValue ("H".$no, $total['total_tagihan']);
        $sheet->getStyle('H'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'faf8b4'))));

        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="Lap-Tagihan-Ekspedisi.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }
    
    function inventory(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/inventory";
        $data['content']= "laporan/inventory";
        
        $this->load->model('Model_laporan');  
        if (!empty($this->input->post('m_cv_id'))){            
            $data['parameter'] = $this->input->post('m_cv_id');
            $list_produk = $this->Model_laporan->list_produk($this->input->post('m_cv_id'))->result();
        }else{
            $data['parameter'] = "";
            $list_produk = $this->Model_laporan->list_produk()->result();
        }
              
        $data['list_produk'] = $this->Model_laporan->list_produk()->result();        
        $this->load->model('Model_t_oven');
        $data['list_cv'] = $this->Model_t_oven->list_cv()->result();
        
        $myProduk1 = array();
        $myProduk2 = array();
        $myProduk3 = array();
        #=======================================================================

        foreach ($list_produk as $index=>$row){            
            #Cek apakah produk punya detail
            $cekDetail = $this->Model_laporan->cek_detail($row->nama_produk)->result();
            if($cekDetail){
                foreach ($cekDetail as $key=>$detail){
                    #cek apakah produk punya sak
                    $cekSak = $this->Model_laporan->cek_sak($row->nama_produk)->result();
                    if($cekSak){
                        $myProduk1[$index]['nama_produk'] = $row->nama_produk;
                    }else{
                        $myProduk2[$index]['nama_produk'] = $row->nama_produk;
                        $myProduk2[$index][$key]['type_produk'] = $detail->type_produk;
                    }
                }                              
            }else{
                $myProduk3[$index]['nama_produk'] = $row->nama_produk;
            }
        }
        $myTable = ""; 
        $no = 1;
        if(sizeof($myProduk1)>0){
            foreach ($myProduk1 as $index){

                $myTable .= '<div class="portlet box yellow-casablanca">';
                $myTable .= '<div class="portlet-title">';
                $myTable .= '<div class="caption">';
                $myTable .= '<i class="fa fa-file-o"></i>'.$index['nama_produk'];
                $myTable .= '</div>';
                $myTable .= '</div>';
                $myTable .= '<div class="portlet-body">';
                $myTable .= '<div class="table-scrollable">';
                
                $myTable .= '<table class="table table-striped table-bordered table-hover">';
                $myTable .= '<tr>';
                $myTable .= '<td style="text-align:center" rowspan="2"><strong>No</strong></td>';
                $myTable .= '<td style="text-align:center" rowspan="2"><strong>Nama CV</strong></td>';
                
                $cekDetail = $this->Model_laporan->cek_detail($index['nama_produk'])->result();
                $jmlClm    = sizeof($cekDetail);
                $cekSak    = $this->Model_laporan->cek_sak($index['nama_produk'])->result();
                $colspan   = sizeof($cekSak);
                foreach ($cekDetail as $row){
                    $myTable .= '<td style="text-align:center" colspan="'.($colspan*2).'"><strong>'.$row->type_produk.'</strong></td>';
                }
                $myTable .= '<td style="text-align:center" rowspan="2"><strong>Total Estimate Amount (Rp)</strong></td>';
                $myTable .= '<td style="text-align:center" rowspan="2"><strong>Action</strong></td>';
                $myTable .= '</tr>';
                $myTable .= '<tr>';
                for($i=0; $i<$jmlClm; $i++){
                    for($j=0; $j<$colspan; $j++){
                        $myTable .= '<td style="text-align:center">'.$cekSak[$j]->sak.' Kg</td>';
                        $myTable .= '<td style="text-align:center">Estimate Amount (Rp)</td>';
                    }
                    
                }                
                $myTable .= '</tr>';
                
                if (!empty($this->input->post('m_cv_id'))){ 
                    $namaCV = $this->Model_laporan->get_nama_cv($this->input->post('m_cv_id'))->row_array();

                    $myTable .= '<tr>';
                    $myTable .= '<td style="text-align:center">'.$no.'</td>';
                    $myTable .= '<td>'.$namaCV['nama_cv'].'</td>';
                    $total = 0;
                    for($i=0; $i<$jmlClm; $i++){
                        for($j=0; $j<$colspan; $j++){
                            $cekStok = $this->Model_laporan->cek_stok($index['nama_produk'], $cekDetail[$i]->type_produk, $cekSak[$j]->sak, $this->input->post('m_cv_id'))->row_array();
                            $cekHarga = $this->Model_laporan->cek_harga($index['nama_produk'].' '.$cekDetail[$i]->type_produk, $cekSak[$j]->sak)->row_array();
                            $myTable .= '<td style="text-align:right">';
                            $stok = (($cekStok)? $cekStok['stok']: 0);
                            $myTable .= number_format($stok,0,',','.');
                            $myTable .= '</td>';
                            $myTable .= '<td style="text-align:right">';
                            $harga  = (($cekHarga['jumlah']>0)? $cekHarga['jumlah']: 0);
                            $amount = $stok * $harga;
                            $total  += $amount;
                            $myTable .= number_format($amount,0,',','.');
                            $myTable .= '</td>';
                        }
                    }  
                    $myTable .= '<td style="text-align:right">'.number_format($total,0,',','.').'</td>';
                    $myTable .= '<td style="text-align:center">'; 
                    $myTable .= '<a href="'.base_url('index.php/Laporan/detail_inventory/produk1/'.$index['nama_produk'].'/'.$this->input->post('m_cv_id')).'"'; 
                    $myTable .= 'class="btn btn-circle btn-xs green" style="margin-bottom:4px">';
                    $myTable .= '<i class="fa fa-sliders"></i> Rincian </a>';
                    $myTable .= '</td>';
                    $myTable .= '</tr>';
                }else{
                    foreach ($data['list_cv'] as $val){
                        $myTable .= '<tr>';
                        $myTable .= '<td style="text-align:center">'.$no.'</td>';
                        $myTable .= '<td>'.$val->nama_cv.'</td>';
                        $total = 0;
                        for($i=0; $i<$jmlClm; $i++){
                            for($j=0; $j<$colspan; $j++){
                                $cekStok = $this->Model_laporan->cek_stok($index['nama_produk'], $cekDetail[$i]->type_produk, $cekSak[$j]->sak, $val->id)->row_array();
                                $cekHarga = $this->Model_laporan->cek_harga($index['nama_produk'].' '.$cekDetail[$i]->type_produk, $cekSak[$j]->sak)->row_array();
                                $myTable .= '<td style="text-align:right">';
                                $stok = (($cekStok)? $cekStok['stok']: 0);
                                $myTable .= number_format($stok,0,',','.');
                                $myTable .= '</td>';
                                $myTable .= '<td style="text-align:right">';
                                $harga  = (($cekHarga['jumlah']>0)? $cekHarga['jumlah']: 0);
                                $amount = $stok * $harga;
                                $total  += $amount;
                                $myTable .= number_format($amount,0,',','.');
                                $myTable .= '</td>';
                            }
                        }  
                        $myTable .= '<td style="text-align:right">'.number_format($total,0,',','.').'</td>';
                        $myTable .= '<td style="text-align:center">'; 
                        $myTable .= '<a href="'.base_url('index.php/Laporan/detail_inventory/produk1/'.$index['nama_produk'].'/'.$val->id).'"'; 
                        $myTable .= 'class="btn btn-circle btn-xs green" style="margin-bottom:4px">';
                        $myTable .= '<i class="fa fa-sliders"></i> Rincian </a>';
                        $myTable .= '</td>';
                        $myTable .= '</tr>';
                        $no++;
                    }
                }
                $myTable .= '</table>';
                $myTable .= '</div>';
                $myTable .= '</div>';
                $myTable .= '</div>';
            }
        }
        
        if(sizeof($myProduk2)>0){
            foreach ($myProduk2 as $index){
                $myTable .= '<div class="table-scrollable">';
                $myTable .= '<table class="table table-striped table-bordered table-hover">';
                $myTable .= '<tr>';
                $myTable .= '<td style="text-align:center; width:40px" rowspan="2"><strong>No</strong></td>';
                $myTable .= '<td style="text-align:center; width:200px" rowspan="2"><strong>Produk/Item</strong></td>';
                $myTable .= '<td style="text-align:center; width:200px" rowspan="2"><strong>Nama CV</strong></td>';
                
                $cekDetail = $this->Model_laporan->cek_detail($index['nama_produk'])->result();
                $jmlClm    = sizeof($cekDetail);
                $myTable .= '<td style="text-align:center" colspan="'.$jmlClm.'"><strong>Type Produk/ Kualitas</strong></td>';
                
                $myTable .= '<td style="text-align:center" rowspan="2"><strong>Total Estimate Amount (Rp)</strong></td>';
                $myTable .= '<td style="text-align:center" rowspan="2"><strong>Action</strong></td>';
                $myTable .= '</tr>';
                $myTable .= '<tr>';
                foreach ($cekDetail as $row){
                    $myTable .= '<td style="text-align:center"><strong>'.$row->type_produk.'</strong></td>';
                }
                $myTable .= '</tr>';
                
                $cekHarga = $this->Model_laporan->cek_harga($index['nama_produk'], '')->row_array();
                $harga  = (($cekHarga['jumlah']>0)? $cekHarga['jumlah']: 0);
                if (empty($this->input->post('m_cv_id'))){ 
                    $myTable .= '<tr>';
                    $myTable .= '<td style="text-align:center">'.$no.'</td>';
                    $myTable .= '<td>'.$index['nama_produk'].'</td>';
                    $myTable .= '<td>Pabrik</td>';
                    $total = 0;
                    for($i=0; $i<$jmlClm; $i++){
                        $cekStok = $this->Model_laporan->cek_stok($index['nama_produk'], $cekDetail[$i]->type_produk)->row_array();

                        $myTable .= '<td style="text-align:right">';
                        $stok = (($cekStok)? $cekStok['stok']: 0);
                        $myTable .= number_format($stok,0,',','.');
                        $myTable .= '</td>';
                        $total += $stok;
                    }  
                    $amount = $harga * $total;
                    $myTable .= '<td style="text-align:right">'.number_format($amount,0,',','.').'</td>';
                    $myTable .= '<td style="text-align:center">'; 
                    $myTable .= '<a href="'.base_url('index.php/Laporan/detail_inventory/produk2/'.$index['nama_produk']).'"'; 
                    $myTable .= 'class="btn btn-circle btn-xs green" style="margin-bottom:4px">';
                    $myTable .= '<i class="fa fa-sliders"></i> Rincian </a>';
                    $myTable .= '</td>';
                    $myTable .= '</tr>';
                    $no++;

                }
                $myTable .= '</table>';
                $myTable .= '</div>';
                
            }
        }
        
        if(sizeof($myProduk3)>0){
            $myTable .= '<div class="portlet box green-seagreen">';
            $myTable .= '<div class="portlet-title">';
            $myTable .= '<div class="caption">';
            $myTable .= '<i class="fa fa-file-o"></i>Inventory lainnya';
            $myTable .= '</div>';
            $myTable .= '</div>';
            $myTable .= '<div class="portlet-body">';
            $myTable .= '<div class="table-scrollable">';
                
            $myTable .= '<table class="table table-striped table-bordered table-hover">';
            $myTable .= '<tr>';
            $myTable .= '<td style="text-align:center; width:40px"><strong>No</strong></td>';
            $myTable .= '<td style="text-align:center;"><strong>Produk/Item</strong></td>';
            $myTable .= '<td style="text-align:center;"><strong>Nama CV</strong></td>';
            $myTable .= '<td style="text-align:center;"><strong>Stok</strong></td>';                
            $myTable .= '<td style="text-align:center"><strong>Total Estimate Amount (Rp)</strong></td>';
            $myTable .= '<td style="text-align:center"><strong>Action</strong></td>';
            $myTable .= '</tr>';
            foreach ($myProduk3 as $index){                                
                $cekHarga = $this->Model_laporan->cek_harga($index['nama_produk'], '')->row_array();
                $harga  = (($cekHarga['jumlah']>0)? $cekHarga['jumlah']: 0);
                if (empty($this->input->post('m_cv_id'))){ 
                    $myTable .= '<tr>';
                    $myTable .= '<td style="text-align:center">'.$no.'</td>';
                    $myTable .= '<td>'.$index['nama_produk'].'</td>';
                    $myTable .= '<td>Pabrik</td>';

                    $cekStok = $this->Model_laporan->cek_stok($index['nama_produk'])->row_array();

                    $myTable .= '<td style="text-align:right">';
                    $stok = (($cekStok)? $cekStok['stok']: 0);
                    $myTable .= number_format($stok,0,',','.');
                    $myTable .= '</td>'; 
                    $amount = $harga * $stok;
                    $myTable .= '<td style="text-align:right">'.number_format($amount,0,',','.').'</td>';
                    $myTable .= '<td style="text-align:center">'; 
                    $myTable .= '<a href="'.base_url('index.php/Laporan/detail_inventory/produk3/'.$index['nama_produk']).'"'; 
                    $myTable .= 'class="btn btn-circle btn-xs green" style="margin-bottom:4px">';
                    $myTable .= '<i class="fa fa-sliders"></i> Rincian </a>';
                    $myTable .= '</td>';
                    $myTable .= '</tr>';
                    $no++;
                }                            
            }
            $myTable .= '</table>';
            $myTable .= '</div>';
            $myTable .= '</div>';
            $myTable .= '</div>';
        }
        $data['myTable'] = $myTable;
        $this->load->view('layout', $data);
    }
    
    function detail_inventory(){
        $module_name = $this->uri->segment(1);
        $type_produk = $this->uri->segment(3);
        $produk  = urldecode($this->uri->segment(4));
        $m_cv_id = $this->uri->segment(5);
        

        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['judul']  = "Laporan/inventory";       
        $this->load->model('Model_laporan');        
        
        if($type_produk=="produk3"){
            $data['header'] = $this->Model_laporan->view_inventory($produk)->row_array();
            $data['detail'] = $this->Model_laporan->view_detail_inventory($produk)->result();
            $data['content']= "laporan/detail_inventory";
            $this->load->view('layout', $data);
        }else if($type_produk=="produk2"){
            $data['content']= "laporan/detail_inventory2";
            $data['type_produk']= $type_produk;
            $data['produk'] = $produk;
            $data['nama_cv']= 'Pabrik';
            $data['m_cv_id']= $m_cv_id;
            
            $myTable = "";
            
            $myTable .= '<tr>';
            $myTable .= '<td style="text-align:center; width:40px" rowspan="3"><strong>No</strong></td>';
            $myTable .= '<td style="text-align:center; width:150px" rowspan="3"><strong>Tanggal</strong></td>';
            $cekDetail = $this->Model_laporan->cek_detail($produk)->result();
            $jmlClm    = sizeof($cekDetail);
            $myTable .= '<td style="text-align:center" colspan="'.($jmlClm* 2).'"><strong>Type Produk/ Kualitas</strong></td>';
            $myTable .= '</tr>';
            $myTable .= '<tr>';
            foreach ($cekDetail as $row){
                $myTable .= '<td style="text-align:center" colspan="2"><strong>'.$row->type_produk.'</strong></td>';
            }
            $myTable .= '</tr>';
            $myTable .= '<tr>';
            foreach ($cekDetail as $row){
                $myTable .= '<td style="text-align:center"><strong>Masuk (Kg)</strong></td>';
                $myTable .= '<td style="text-align:center"><strong>Keluar (Kg)</strong></td>';
            }
            $myTable .= '</tr>';
            
            #Get list tanggal di inventory detail
            $listTanggal = $this->Model_laporan->get_tanggal($produk)->result();
            $no = 1;
            foreach ($listTanggal as $value){
                $myTable .= '<tr>';
                $myTable .= '<td style="text-align:center">'.$no.'</td>';
                $myTable .= '<td style="text-align:center">'.$value->tanggal.'</td>';
                foreach ($cekDetail as $row){
                    #Cek Stok per tanggal
                    $stok = $this->Model_laporan->cek_inventory_detail($produk, $row->type_produk, $value->tanggal)->row_array();
                    if($stok){
                        $masuk  = $stok['jumlah_masuk'];
                        $keluar = $stok['jumlah_keluar'];
                    }else{
                        $masuk  = 0;
                        $keluar = 0;
                    }
                    $myTable .= '<td style="text-align:right">'.number_format($masuk,0,',','.').'</td>';
                    $myTable .= '<td style="text-align:right">'.number_format($keluar,0,',','.').'</td>';
                }
                $myTable .= '</tr>';
                $no++;
            }
            $data['myTable'] = $myTable;            
            $this->load->view('layout', $data);            
        }else if($type_produk=="produk1"){
            $data['content']= "laporan/detail_inventory2";
            $data['type_produk']= $type_produk;
            $data['produk'] = $produk;
            $data['m_cv_id']= $m_cv_id;
            $nama_cv = $this->Model_laporan->get_nama_cv($m_cv_id)->row_array();
            $data['nama_cv']= $nama_cv['nama_cv'];
            
            $myTable = "";
            
            $myTable .= '<tr>';
            $myTable .= '<td style="text-align:center; width:40px" rowspan="3"><strong>No</strong></td>';
            $myTable .= '<td style="text-align:center; width:150px" rowspan="3"><strong>Tanggal</strong></td>';
            $cekDetail = $this->Model_laporan->cek_detail($produk)->result();
            $jmlClm    = sizeof($cekDetail);            
            $cekSak    = $this->Model_laporan->cek_sak($produk)->result();
            $colspan   = sizeof($cekSak);
            foreach ($cekDetail as $row){
                $myTable .= '<td style="text-align:center" colspan="'.($colspan*2).'"><strong>'.$row->type_produk.'</strong></td>';
            }
            $myTable .= '</tr>';
            $myTable .= '<tr>';
            for($i=0; $i<$jmlClm; $i++){
                for($j=0; $j<$colspan; $j++){
                    $myTable .= '<td style="text-align:center" colspan="2">'.$cekSak[$j]->sak.' Kg</td>';
                }

            }                
            $myTable .= '</tr>';

            $myTable .= '<tr>';
            for($i=0; $i<$jmlClm; $i++){
                for($j=0; $j<$colspan; $j++){
                    $myTable .= '<td style="text-align:center"><strong>Masuk</strong></td>';
                $myTable .= '<td style="text-align:center"><strong>Keluar</strong></td>';
                }

            }  
            $myTable .= '</tr>';
            
            #Get list tanggal di inventory detail
            $listTanggal = $this->Model_laporan->get_tanggal($produk, $m_cv_id)->result();
            $no = 1;
            foreach ($listTanggal as $value){
                $myTable .= '<tr>';
                $myTable .= '<td style="text-align:center">'.$no.'</td>';
                $myTable .= '<td style="text-align:center">'.$value->tanggal.'</td>';
                
                for($i=0; $i<$jmlClm; $i++){
                    for($j=0; $j<$colspan; $j++){
                        #Cek Stok per tanggal
                        $stok = $this->Model_laporan->cek_inventory_detail($produk, $cekDetail[$i]->type_produk, $value->tanggal, $cekSak[$j]->sak, $m_cv_id)->row_array();
                        if($stok){
                            $masuk  = $stok['jumlah_masuk'];
                            $keluar = $stok['jumlah_keluar'];
                        }else{
                            $masuk  = 0;
                            $keluar = 0;
                        }
                        $myTable .= '<td style="text-align:right">'.number_format($masuk,0,',','.').'</td>';
                        $myTable .= '<td style="text-align:right">'.number_format($keluar,0,',','.').'</td>';
                    }

                }  
                $myTable .= '</tr>';
                $no++;
            }
            
            
            
            $data['myTable'] = $myTable;            
            $this->load->view('layout', $data);
        }
    }
    
    function save_adjustment_stok(){
        $user_id = $this->session->userdata('user_id');
        $tanggal = date('Y-m-d h:m:s');

        $jumlah    = str_replace(".", "", $this->input->post('jumlah'));
        $input_tgl = date('Y-m-d', strtotime($this->input->post('tanggal')));
        
        $this->db->trans_start();
        
        $this->load->model('Model_t_oven');
        $get_stok = $this->Model_t_oven->cek_stok(
                        $this->input->post('nama_produk'), 
                        $this->input->post('adjustment_cv'), 
                        $this->input->post('sak')
                    )->row_array(); 
        
        $stok_id  = $get_stok['id'];
        if($this->input->post('type_adjustment')=="plus"){
            $stok = $get_stok['stok']+ $jumlah;
            
            #Save data ke tabel detail inventory
            $this->db->insert('t_inventory_detail', array(
                't_inventory_id'=>$stok_id,
                'tanggal'=>$input_tgl,
                'jumlah_masuk'=>$jumlah,
                'referensi_name'=>'adjustment',
                'catatan'=>$this->input->post('catatan'),
            ));
        }else{
            $stok = $get_stok['stok']- $jumlah;
            
            #Save data ke tabel detail inventory
            $this->db->insert('t_inventory_detail', array(
                't_inventory_id'=>$stok_id,
                'tanggal'=>$input_tgl,
                'jumlah_keluar'=>$jumlah,
                'referensi_name'=>'adjustment',
                'catatan'=>$this->input->post('catatan'),
            ));
        }

        $this->db->where('id', $stok_id);
        $this->db->update('t_inventory', array('stok'=>$stok, 
                        'modified'=>$tanggal, 'modified_by'=>$user_id));

        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Data berhasil disimpan');
            redirect('index.php/Laporan/inventory'); 
        }else{
            echo "Terjadi kesalahan saat penyimpanan data!<br>";
            echo "<pre>"; die(var_dump($this->input->post()));
        }
    }
    
    function print_inventory(){
        $parameter = $this->uri->segment(3);
        $this->load->model('Model_laporan');
        $this->load->model('Model_t_oven');
        $list_produk = $this->Model_laporan->list_produk($parameter)->result();
        $list_cv = $this->Model_t_oven->list_cv()->result();
        
        $myProduk1 = array();
        $myProduk2 = array();
        $myProduk3 = array();
        
        foreach ($list_produk as $index=>$row){            
            #Cek apakah produk punya detail
            $cekDetail = $this->Model_laporan->cek_detail($row->nama_produk)->result();
            if($cekDetail){
                foreach ($cekDetail as $key=>$detail){
                    #cek apakah produk punya sak
                    $cekSak = $this->Model_laporan->cek_sak($row->nama_produk)->result();
                    if($cekSak){
                        $myProduk1[$index]['nama_produk'] = $row->nama_produk;
                    }else{
                        $myProduk2[$index]['nama_produk'] = $row->nama_produk;
                        $myProduk2[$index][$key]['type_produk'] = $detail->type_produk;
                    }
                }                              
            }else{
                $myProduk3[$index]['nama_produk'] = $row->nama_produk;
            }
        }
        
        require_once ("excel/PHPExcel.php");
        $judul   = "Laporan Inventory";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);
        $clmName = array(1=>'A', 2=>'B', 3=>'C', 4=>'D', 5=>'E', 6=>'F', 7=>'G', 8=>'H', 9=>'I', 10=>'J',
                        11=>'K', 12=>'L', 13=>'M', 14=>'N', 15=>'O', 16=>'P', 17=>'Q', 18=>'R', 19=>'S', 20=>'T',
                        21=>'U', 22=>'V', 23=>'W', 24=>'X', 25=>'Y', 26=>'Z');
        
        if(sizeof($myProduk1)>0){
            foreach ($myProduk1 as $index){
                $sheet->mergeCells('A1:A2');
                $sheet->mergeCells('B1:B2');
                
                $sheet  ->setCellValue("A1", "NO")
                        ->setCellValue("B1", "NAMA CV");
                
                $cekDetail = $this->Model_laporan->cek_detail($index['nama_produk'])->result();
                $jmlClm    = sizeof($cekDetail);
                $cekSak    = $this->Model_laporan->cek_sak($index['nama_produk'])->result();
                $colspan   = sizeof($cekSak);
                $clmStart  = 3;
                
                foreach ($cekDetail as $row){
                    $clmEnd    = $clmStart+($colspan*2);

                    $sheet->mergeCells($clmName[$clmStart].'1:'.$clmName[$clmEnd-1].'1');
                    $sheet->setCellValue($clmName[$clmStart]."1", $row->type_produk);
                    $clmStart  = $clmEnd;
                }
                $sheet->mergeCells($clmName[$clmStart].'1:'.$clmName[$clmStart].'2');
                $sheet->setCellValue($clmName[$clmStart]."1", "Total Estimate Amount (Rp)");

                #pindah row mas
                $clmStart  = 3;
                for($i=0; $i<$jmlClm; $i++){
                    for($j=0; $j<$colspan; $j++){
                        $sheet->setCellValue($clmName[$clmStart]."2", $cekSak[$j]->sak." Kg");
                        $clmStart++;
                        $sheet->setCellValue($clmName[$clmStart]."2", "Estimate Amount (Rp)");
                        $clmStart++;
                    }                    
                }                
                #pindah row
                $no = 1;
                if (!empty($parameter)){ 
                    $namaCV = $this->Model_laporan->get_nama_cv($parameter)->row_array();
                    $sheet->setCellValue("A3", $no)
                          ->setCellValue("B3", $namaCV['nama_cv']);

                    $total = 0;
                    $clmStart  = 3;
                    for($i=0; $i<$jmlClm; $i++){
                        for($j=0; $j<$colspan; $j++){
                            $cekStok = $this->Model_laporan->cek_stok($index['nama_produk'], $cekDetail[$i]->type_produk, $cekSak[$j]->sak, $parameter)->row_array();
                            $cekHarga = $this->Model_laporan->cek_harga($index['nama_produk'].' '.$cekDetail[$i]->type_produk, $cekSak[$j]->sak)->row_array();                            

                            $stok = (($cekStok)? $cekStok['stok']: 0);
                            $sheet->setCellValue($clmName[$clmStart]."3", $stok);
                            $clmStart++;
                            $harga  = (($cekHarga['jumlah']>0)? $cekHarga['jumlah']: 0);
                            $amount = $stok * $harga;
                            $total  += $amount;
                            $sheet->setCellValue($clmName[$clmStart]."3", $amount);
                            $clmStart++;
                        }
                    }  
                    $sheet->setCellValue($clmName[$clmStart]."3", $total);
                }else{        
                    $rowStart = 3;
                    foreach ($list_cv as $val){
                        $sheet->setCellValue("A".$rowStart, $no)
                              ->setCellValue("B".$rowStart, $val->nama_cv);
   
                        $total = 0;
                        $clmStart = 3;
                        for($i=0; $i<$jmlClm; $i++){
                            for($j=0; $j<$colspan; $j++){
                                $cekStok = $this->Model_laporan->cek_stok($index['nama_produk'], $cekDetail[$i]->type_produk, $cekSak[$j]->sak, $val->id)->row_array();
                                $cekHarga = $this->Model_laporan->cek_harga($index['nama_produk'].' '.$cekDetail[$i]->type_produk, $cekSak[$j]->sak)->row_array();

                                $stok = (($cekStok)? $cekStok['stok']: 0);
                                $sheet->setCellValue($clmName[$clmStart].$rowStart, $stok);
                                $clmStart++;
                                $harga  = (($cekHarga['jumlah']>0)? $cekHarga['jumlah']: 0);
                                $amount = $stok * $harga;
                                $total  += $amount;
                                $sheet->setCellValue($clmName[$clmStart].$rowStart, $amount);
                                $clmStart++;
                            }
                        }  
                        $sheet->setCellValue($clmName[$clmStart].$rowStart, $total);
                        $no++;
                        $rowStart++;
                    }
                }
            }
        }
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(10);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(10);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(10);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(10);
        $sheet->getColumnDimension('P')->setWidth(20);
        $sheet->getColumnDimension('Q')->setWidth(10);
        $sheet->getColumnDimension('R')->setWidth(20);
        $sheet->getColumnDimension('S')->setWidth(25);
        
        $sheet->getStyle('A1:S2')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));        
        
        $rowStart++;
        
        if(sizeof($myProduk2)>0){
            foreach ($myProduk2 as $index){
                $rowAwal = $rowStart;
                $sheet->mergeCells('A'.$rowStart.':A'.($rowStart+1));
                $sheet->mergeCells('B'.$rowStart.':B'.($rowStart+1));
                $sheet->mergeCells('C'.$rowStart.':C'.($rowStart+1));
                
                $sheet->setCellValue("A".$rowStart, "No")
                      ->setCellValue("B".$rowStart, "Produk/Item")
                      ->setCellValue("C".$rowStart, "Nama CV");
                
                $cekDetail = $this->Model_laporan->cek_detail($index['nama_produk'])->result();
                $jmlClm    = sizeof($cekDetail);
                $clmStart  = 4+$jmlClm;
                $sheet->mergeCells('D'.$rowStart.':'.$clmName[$clmStart-1].$rowStart);                
                $sheet->setCellValue("D".$rowStart, "Type Produk/ Kualitas");
                $sheet->getStyle("D".$rowStart)->getAlignment()->setWrapText(true);
                $sheet->setCellValue($clmName[$clmStart].$rowStart, "Total Estimate Amount (Rp)");
                $sheet->getStyle($clmName[$clmStart].$rowStart)->getAlignment()->setWrapText(true);
                #Pindah row
                $clmStart = 4;
                $rowStart++;
                foreach ($cekDetail as $row){
                    $sheet->setCellValue($clmName[$clmStart].$rowStart, $row->type_produk);
                    $clmStart++;
                }
                $sheet->getStyle('A'.$rowAwal.':'.$clmName[$clmStart].$rowStart)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
                    'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER))); 
                
                $rowStart++;
                $cekHarga = $this->Model_laporan->cek_harga($index['nama_produk'], '')->row_array();
                $harga  = (($cekHarga['jumlah']>0)? $cekHarga['jumlah']: 0);
                if (empty($this->input->post('m_cv_id'))){ 
                    $sheet->setCellValue('A'.$rowStart, $no);
                    $sheet->setCellValue('B'.$rowStart, $index['nama_produk']);
                    $sheet->setCellValue('C'.$rowStart, 'Pabrik');

                    $total = 0;
                    $clmStart = 4;
                    for($i=0; $i<$jmlClm; $i++){
                        $cekStok = $this->Model_laporan->cek_stok($index['nama_produk'], $cekDetail[$i]->type_produk)->row_array();
                        $stok = (($cekStok)? $cekStok['stok']: 0);
                        $sheet->setCellValue($clmName[$clmStart].$rowStart, $stok);
                        $clmStart++;
                        $total += $stok;
                    }  
                    $amount = $harga * $total;
                    $sheet->setCellValue($clmName[$clmStart].$rowStart, $amount);
                    $no++;
                }                  
                $rowStart++;
                $rowStart++;
            }
        }
        $rowStart++;
        
        if(sizeof($myProduk3)>0){
            $sheet->setCellValue('A'.$rowStart, "No")
                ->setCellValue('B'.$rowStart, "Produk/Item")
                ->setCellValue('C'.$rowStart, "Nama CV")
                ->setCellValue('D'.$rowStart, "Stok")
                ->setCellValue('E'.$rowStart, "Total Estimate Amount (Rp)");
            
            $sheet->getStyle('E'.$rowStart)->getAlignment()->setWrapText(true);
            
            $sheet->getStyle('A'.$rowStart.':E'.$rowStart)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
                'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER))); 
            
            $rowStart++;
            foreach ($myProduk3 as $index){                                
                $cekHarga = $this->Model_laporan->cek_harga($index['nama_produk'], '')->row_array();
                $harga  = (($cekHarga['jumlah']>0)? $cekHarga['jumlah']: 0);
                if (empty($this->input->post('m_cv_id'))){ 
                    $cekStok = $this->Model_laporan->cek_stok($index['nama_produk'])->row_array();
                    $stok = (($cekStok)? $cekStok['stok']: 0);
                    $amount = $harga * $stok;
                    
                    $sheet->setCellValue('A'.$rowStart, $no)
                        ->setCellValue('B'.$rowStart, $index['nama_produk'])
                        ->setCellValue('C'.$rowStart, "Pabrik")
                        ->setCellValue('D'.$rowStart, $stok)
                        ->setCellValue('E'.$rowStart, $amount);

                    $no++;
                } 
                $rowStart++;
            }
        }        
        
        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="Laporan-Inventory.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }
    
    function print_detail_inventory(){
        $id = $this->uri->segment(3);
        $this->load->model('Model_laporan');
        
        require_once ("excel/PHPExcel.php");
        $judul   = "List Detail Inventory";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);
        
        $sheet->mergeCells('A1:B1');
        $sheet->mergeCells('A2:B2');

        $sheet  ->setCellValue("A4", "NO")
                ->setCellValue("B4", "TANGGAL")
                ->setCellValue("C4", "JUMLAH MASUK (Kg)")
                ->setCellValue("D4", "JUMLAH KELUAR (Kg)")
                ->setCellValue("E4", "REFERENSI KE")
                ->setCellValue("F4", "REFERENSI INDEX")
                ->setCellValue("G4", "REFERENSI NO")
                ->setCellValue("H4", "CATATAN");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(25);

        $sheet->getStyle('A4:H4')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));

        $header = $this->Model_laporan->view_inventory($id)->row_array();
        $detail = $this->Model_laporan->view_detail_inventory($id)->result();
        
        $sheet  ->setCellValue ("A1", 'Nama CV');
        $sheet  ->setCellValue ("C1", ($header['m_cv_id']==0)? 'Pabrik': $header['nama_cv']);
        $sheet  ->setCellValue ("A2", 'Barang/ Produk');
        $sheet  ->setCellValue ("C2", $header['nama_produk']);
        
        $sheet  ->setCellValue ("F2", 'Stok Sekarang (Kg)');
        $sheet  ->setCellValue ("G2", $header['stok']);
        
        $no  = 4;
        $num = 0;
        foreach ($detail as $index=>$value){
            $no++;
            $num++;
            $sheet  ->setCellValue ("A".$no, $num)
                    ->setCellValue ("B".$no, date('d-m-Y', strtotime($value->tanggal)))
                    ->setCellValue ("C".$no, $value->jumlah_masuk)
                    ->setCellValue ("D".$no, $value->jumlah_keluar)
                    ->setCellValue ("E".$no, $value->referensi_name)
                    ->setCellValue ("F".$no, $value->referensi_id)
                    ->setCellValue ("G".$no, $value->referensi_no)
                    ->setCellValue ("H".$no, $value->catatan);                               
        }

        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="Laporan-Transaksi-Dibatalkan.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }
    
    function print_detail_inventory2(){
        $type_produk = $this->uri->segment(3);
        $produk  = urldecode($this->uri->segment(4));
        $m_cv_id = $this->uri->segment(5);
        
        $this->load->model('Model_laporan');
        
        require_once ("excel/PHPExcel.php");
        $judul   = "List Detail Inventory";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);
        $clmName = array(1=>'A', 2=>'B', 3=>'C', 4=>'D', 5=>'E', 6=>'F', 7=>'G', 8=>'H', 9=>'I', 10=>'J',
                        11=>'K', 12=>'L', 13=>'M', 14=>'N', 15=>'O', 16=>'P', 17=>'Q', 18=>'R', 19=>'S', 20=>'T',
                        21=>'U', 22=>'V', 23=>'W', 24=>'X', 25=>'Y', 26=>'Z');
        
        if($type_produk=="produk2"){
            $sheet->mergeCells('A1:B1');
            $sheet->mergeCells('A2:B2');
            $sheet->mergeCells('C1:E1');
            $sheet->mergeCells('C2:E2');
            
            $sheet  ->setCellValue ("A1", "Nama CV")
                    ->setCellValue ("C1", 'Pabrik')
                    ->setCellValue ("A2", "Barang/ Produk")
                    ->setCellValue ("C2", $produk);
            
            $sheet->mergeCells('A3:A5');
            $sheet->mergeCells('B3:B5');
            $sheet  ->setCellValue ("A3", "No")
                    ->setCellValue ("B3", 'Tanggal');
            
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(15);
            
            $cekDetail = $this->Model_laporan->cek_detail($produk)->result();
            $jmlClm    = sizeof($cekDetail);
            
            $sheet->mergeCells('C3:'.$clmName[2+($jmlClm* 2)].'3');
            $sheet->setCellValue ("C3", "Type Produk/ Kualitas");
            $clmStart = 3;
            foreach ($cekDetail as $row){
                $sheet->mergeCells($clmName[$clmStart].'4:'.$clmName[$clmStart+1].'4');
                $sheet->setCellValue ($clmName[$clmStart]."4", $row->type_produk);
                $clmStart++;
                $clmStart++;
            }
            $clmStart = 3;
            foreach ($cekDetail as $row){
                $sheet->setCellValue ($clmName[$clmStart]."5", "Masuk (Kg)");
                $clmStart++;
                $sheet->setCellValue ($clmName[$clmStart]."5", "Keluar (Kg)");
            }
            $sheet->getStyle('A3:'.$clmName[$clmStart].'5')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
                'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER))); 
            
            #Get list tanggal di inventory detail
            $listTanggal = $this->Model_laporan->get_tanggal($produk)->result();
            $no = 1;
            $rowStart=6;
            foreach ($listTanggal as $value){
                $sheet  ->setCellValue ("A".$rowStart, $no)
                        ->setCellValue ("B".$rowStart, $value->tanggal);
                
                $clmStart=3;
                foreach ($cekDetail as $row){
                    #Cek Stok per tanggal
                    $stok = $this->Model_laporan->cek_inventory_detail($produk, $row->type_produk, $value->tanggal)->row_array();
                    if($stok){
                        $masuk  = $stok['jumlah_masuk'];
                        $keluar = $stok['jumlah_keluar'];
                    }else{
                        $masuk  = 0;
                        $keluar = 0;
                    }
                    $sheet->setCellValue ($clmName[$clmStart].$rowStart, $masuk);
                    $clmStart++;
                    $sheet->setCellValue ($clmName[$clmStart].$rowStart, $keluar);
                    $clmStart++;
                }
                $rowStart++;
                $no++;
            }
        }else if($type_produk=="produk1"){
            $sheet->mergeCells('A1:B1');
            $sheet->mergeCells('A2:B2');
            $sheet->mergeCells('C1:F1');
            $sheet->mergeCells('C2:F2');
            
            $sheet  ->setCellValue ("A1", "Nama CV")
                    ->setCellValue ("C1", 'Pabrik')
                    ->setCellValue ("A2", "Barang/ Produk")
                    ->setCellValue ("C2", $produk);
            
            $sheet->mergeCells('A3:A5');
            $sheet->mergeCells('B3:B5');
            $sheet  ->setCellValue ("A3", "No")
                    ->setCellValue ("B3", 'Tanggal');
            
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(10);
            $sheet->getColumnDimension('D')->setWidth(10);
            $sheet->getColumnDimension('E')->setWidth(10);
            $sheet->getColumnDimension('F')->setWidth(10);
            $sheet->getColumnDimension('G')->setWidth(10);
            $sheet->getColumnDimension('H')->setWidth(10);
            $sheet->getColumnDimension('I')->setWidth(10);
            $sheet->getColumnDimension('J')->setWidth(10);
            $sheet->getColumnDimension('K')->setWidth(10);
            $sheet->getColumnDimension('L')->setWidth(10);
            $sheet->getColumnDimension('M')->setWidth(10);
            $sheet->getColumnDimension('N')->setWidth(10);
            $sheet->getColumnDimension('O')->setWidth(10);
            $sheet->getColumnDimension('P')->setWidth(10);
            $sheet->getColumnDimension('Q')->setWidth(10);
            $sheet->getColumnDimension('R')->setWidth(10);
            
            $sheet->getStyle('A3:R5')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
                'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER)));
            
            $cekDetail = $this->Model_laporan->cek_detail($produk)->result();
            $jmlClm    = sizeof($cekDetail);            
            $cekSak    = $this->Model_laporan->cek_sak($produk)->result();
            $colspan   = sizeof($cekSak);
            $clmStart  = 3;
            foreach ($cekDetail as $row){
                $clmEnd = $clmStart+ ($colspan* 2);
                $sheet->mergeCells($clmName[$clmStart].'3:'.$clmName[$clmEnd-1].'3');
                $sheet  ->setCellValue ($clmName[$clmStart]."3", $row->type_produk);
                $clmStart = $clmEnd;
            }
            $clmStart  = 3;
            for($i=0; $i<$jmlClm; $i++){
                for($j=0; $j<$colspan; $j++){
                    $clmEnd = $clmStart+ 2;
                    $sheet->mergeCells($clmName[$clmStart].'4:'.$clmName[$clmEnd-1].'4');
                    $sheet  ->setCellValue ($clmName[$clmStart]."4", $cekSak[$j]->sak.' Kg');
                    $clmStart = $clmEnd;
                }
            }  
            $clmStart  = 3;
            for($i=0; $i<$jmlClm; $i++){
                for($j=0; $j<$colspan; $j++){
                    $sheet  ->setCellValue ($clmName[$clmStart]."5", 'Masuk');
                    $clmStart++;
                    $sheet  ->setCellValue ($clmName[$clmStart]."5", 'Keluar');
                    $clmStart++;
                }
            }  
            
            #Get list tanggal di inventory detail
            $listTanggal = $this->Model_laporan->get_tanggal($produk, $m_cv_id)->result();
            $rowStart=6;
            $no = 1;
            foreach ($listTanggal as $value){
                $sheet  ->setCellValue ("A".$rowStart, $no)
                        ->setCellValue ("B".$rowStart, $value->tanggal);
                
                $clmStart=3;                
                for($i=0; $i<$jmlClm; $i++){
                    for($j=0; $j<$colspan; $j++){
                        #Cek Stok per tanggal
                        $stok = $this->Model_laporan->cek_inventory_detail($produk, $cekDetail[$i]->type_produk, $value->tanggal, $cekSak[$j]->sak, $m_cv_id)->row_array();
                        if($stok){
                            $masuk  = $stok['jumlah_masuk'];
                            $keluar = $stok['jumlah_keluar'];
                        }else{
                            $masuk  = 0;
                            $keluar = 0;
                        }
                        $sheet->setCellValue ($clmName[$clmStart].$rowStart, $masuk);
                        $clmStart++;
                        $sheet->setCellValue ($clmName[$clmStart].$rowStart, $keluar);
                        $clmStart++;
                    }

                }  
                $rowStart++;
                $no++;
            }
        }

        

        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="List-Detail-Inventory.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }
    
    function detail_giling(){
        $module_name = $this->uri->segment(1);
        $id = $this->uri->segment(3);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        
        $data['judul']  = "Laporan/giling_harian";
        $data['content']= "laporan/detail_giling";
        $this->load->model('Model_t_giling');
        $data['list_data'] = $this->Model_t_giling->view_dt_giling($id)->result();
        $data['header'] = $this->Model_t_giling->header_dt_giling($id)->row_array();

        $this->load->view('layout', $data);
    }
    
    function print_detail_giling(){
        $id = $this->uri->segment(3);
        $this->load->model('Model_t_giling');
        
        require_once ("excel/PHPExcel.php");
        $judul   = "Detail Giling Harian";
        $creator = "Taruna Aang";

        $file = new PHPExcel();
        $file->getProperties()->setCreator ($creator);
        $file->getProperties()->setLastModifiedBy ($creator);
        $file->getProperties()->setTitle ($judul);
        $file->getProperties()->setSubject ($judul);
        $file->getProperties()->setDescription ($judul);
        $file->getProperties()->setKeywords ($judul);
        $file->getProperties()->setCategory ($judul);

        $file->createSheet (NULL,0);
        $file->setActiveSheetIndex (0);
        $sheet = $file->getActiveSheet(0);
        $sheet->setTitle($judul);
        
        $list_data = $this->Model_t_giling->view_dt_giling($id)->result();
        $header = $this->Model_t_giling->header_dt_giling($id)->row_array();
        
        $sheet->mergeCells('A1:B1');
        $sheet->mergeCells('A2:B2');
        $sheet->mergeCells('C1:E1');
        $sheet->mergeCells('C2:E2');

        $sheet  ->setCellValue("A1", "No. Giling")
                ->setCellValue("A2", "Tanggal")
                ->setCellValue("C1", $header['no_giling'])
                ->setCellValue("C2", date('d-m-Y', strtotime($header['tanggal'])));
        
        $sheet  ->setCellValue("A3", "NO")
                ->setCellValue("B3", "TGL PEMBELIAN")
                ->setCellValue("C3", "JAM MASUK")
                ->setCellValue("D3", "NAMA AGEN")
                ->setCellValue("E3", "NOMOR POLISI")
                ->setCellValue("F3", "NAMA SUPIR")
                ->setCellValue("G3", "BERAT (KG)")
                ->setCellValue("H3", "PASIR")
                ->setCellValue("I3", "TANAH")
                ->setCellValue("J3", "KADAR ACI (%)")
                ->setCellValue("K3", "UKURAN")
                ->setCellValue("L3", "BONGGOL");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(12);
        $sheet->getColumnDimension('L')->setWidth(12);

        $sheet->getStyle('A3:L3')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099'))));
        $no  = 4;
        $num = 1;
        foreach ($list_data as $index=>$value){            
            $sheet  ->setCellValue ("A".$no, $num)
                    ->setCellValue ("B".$no, date('d-m-Y', strtotime($value->time_in)))
                    ->setCellValue ("C".$no, date('h:m', strtotime($value->time_in)))
                    ->setCellValue ("D".$no, $value->nama_agen)
                    ->setCellValue ("E".$no, $value->no_kendaraan)
                    ->setCellValue ("F".$no, $value->supir)
                    ->setCellValue ("G".$no, $value->berat_bersih)
                    ->setCellValue ("H".$no, $value->qc01)
                    ->setCellValue ("I".$no, $value->qc02)
                    ->setCellValue ("J".$no, $value->qc03)
                    ->setCellValue ("K".$no, $value->qc04)
                    ->setCellValue ("L".$no, $value->qc05);  
            $no++;
            $num++;
        }
        $sheet->mergeCells('A'.$no.':F'.$no);
        $sheet->setCellValue ("A".$no, 'TOTAL DIPROSES (KG)');
        $sheet->getStyle('A'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));

        $sheet->setCellValue ("G".$no, $header['berat_diproses']);
        $sheet->getStyle('G'.$no)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000099')),
            'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'faf8b4'))));

        header ('Content-Type: application/vnd.ms-excel');
        header ('Content-Disposition: attachment;filename="Detail-Giling-Harian.xls"'); 
        header ('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter ($file, 'Excel5');
        $writer->save ('php://output');
    }
    
    function update_giling(){
        $user_id = $this->session->userdata('user_id');
        $tanggal = date('Y-m-d h:m:s');
        
        $details = $this->input->post('mydata');        
        foreach ($details as $value){
            if(isset($value['check']) && $value['check']==1){
                $this->db->where('id', $value['giling_id']);
                $this->db->update('t_giling', array(
                    'm_cv_id'=>$this->input->post('m_cv_id'),
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id
                ));
            }
        }
        $this->session->set_flashdata('flash_msg', 'Data giling berhasil diupdate');
        redirect('index.php/Laporan/giling_harian');
    }
}