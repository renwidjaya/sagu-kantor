<!-- CONTAINER -->
<div class="page-container">
    <!-- SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <!-- SIDEBAR MENU -->
            <?php
            $module_name = $this->uri->segment(1);
            $function_name = $this->uri->segment(2);
            ?>
            <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">				
                <li class="sidebar-toggler-wrapper">
                    <!-- SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler"></div>
                </li>                
                <li class="sidebar-search-wrapper">
                    <!-- RESPONSIVE QUICK SEARCH FORM -->                        
                    <form class="sidebar-search " action="extra_search.html" method="POST">
                        <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                        </a>
                        <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
                                </span>
                        </div>
                    </form>
                </li>
                <!--li>
                    <a href="<?php echo base_url(); ?>index.php/Otorisasi/list_otorisasi">
                    <i class="fa fa-truck"></i>
                        <span class="title">KENDARAAN MASUK DAN KELUAR</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>index.php/Giling/list_hasil_giling">
                    <i class="fa fa-cog"></i>
                        <span class="title">HASIL GILING</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>index.php/Oven">
                    <i class="fa fa-coffee"></i>
                        <span class="title">HASIL OVEN</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>index.php/SisaProduksi">
                    <i class="fa fa-trash"></i>
                        <span class="title">SISA PRODUKSI</span>
                    </a>
                </li>
                
                <li <?php echo ($module_name=="Kapasitas")? 'class="start active open"': ''; ?>>
                    <a href="javascript:;">
                    <i class="fa fa-archive"></i>
                    <span class="title">KAPASITAS MESIN</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Kapasitas/kapasitas_mesin">
                            <i class="fa fa-sun-o"></i>
                            Kapasitas Mesin </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Kapasitas/kapasitas_oven">
                            <i class="fa fa-tint"></i>
                            Kapasitas Oven </a>
                        </li>
                    </ul>
                </li-->               

                <li <?php echo ($module_name=="Kas")? 'class="start active open"': ''; ?>>
                    <a href="javascript:;">
                    <i class="fa fa-pied-piper "></i>
                    <span class="title">KASIR</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Kas/list_nota_jual">
                            <i class="fa fa-files-o"></i>
                            Terima Kas </a>
                        </li>
                        <!--li>
                            <a href="<?php echo base_url(); ?>index.php/Kas/terima_kas_gelondongan">
                            <i class="fa  fa-file-text-o"></i>
                            Terima Kas Parsial </a>
                        </li-->
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Kas/list_nota_bayar">
                            <i class="fa fa-file-o"></i>
                            Pembayaran Nota </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Kas/pembayaran_nota_gelondongan">
                            <i class="fa fa-clipboard"></i>
                            Pembayaran Nota Gelondongan </a>
                        </li>                        
                    </ul>
                </li>
                
                <li <?php echo ($module_name=="Piutang")? 'class="start active open"': ''; ?>>
                    <a href="javascript:;">
                    <i class="fa fa-files-o"></i>
                    <span class="title">PIUTANG CUSTOMER</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Piutang/list_invoice">
                            <i class="fa fa-file-text-o"></i>
                            List Invoice </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Piutang/pembayaran">
                            <i class="fa fa-file-text-o"></i>
                            Terima Kas/Bank </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Piutang/proses_pembayaran">
                            <i class="fa fa-file-text-o"></i>
                            Settle Pembayaran </a>
                        </li>
                    </ul>
                </li>
                
                <li <?php echo ($module_name=="Laporan")? 'class="start active open"': ''; ?>>
                    <a href="javascript:;">
                    <i class="fa fa-files-o"></i>
                    <span class="title">LAPORAN</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Laporan/pembelian_harian">
                            <i class="fa fa-file-text-o"></i>
                            Pembelian Harian </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Laporan/pembelian_bulanan">
                            <i class="fa fa-file-text-o"></i>
                            Pembelian Singkong Bulanan </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Laporan/penjualan_harian">
                            <i class="fa fa-file-text-o"></i>
                            Penjualan Harian </a>
                        </li>                                               
                        <li <?php echo ($function_name=="arus_kas" || $function_name=="arus_kas_cv" 
                                || $function_name=="arus_kas_limbah" || $function_name=="arus_kas_pabrik")? 'class="start active open"': ''; ?>>
                            <a href="javascript:;">
                            <i class="fa fa-files-o"></i>
                            <span class="title">Laporan Arus Kas</span>
                            <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Laporan/arus_kas_kantor">
                                    <i class="fa fa-briefcase"></i>
                                    Kas Kantor </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Laporan/arus_kas">
                                    <i class="fa fa-briefcase"></i>
                                    Kas Pabrik</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Laporan/arus_kas_cv">
                                    <i class="fa fa-briefcase"></i>
                                    Kas Pembelian</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Laporan/arus_kas_limbah">
                                    <i class="fa fa-briefcase"></i>
                                    Kas Limbah/ Onggok </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Laporan/transaksi_kantor">
                            <i class="fa fa-file-text-o"></i>
                            Transaksi Dibayar Kantor </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Laporan/transaksi_dibatalkan">
                            <i class="fa fa-file-text-o"></i>
                            Transaksi Dibatalkan </a>
                        </li>                        
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Laporan/inventory">
                            <i class="fa fa-cubes"></i>
                            Inventory </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Laporan/otorisasi">
                            <i class="fa fa-truck"></i>
                            Kendaraan Masuk/ Keluar </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Laporan/giling_harian">
                            <i class="fa fa-cog"></i>
                            Giling Harian </a>
                        </li> 
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Laporan/hasil_oven">
                            <i class="fa fa-coffee"></i>
                            Hasil Oven </a>
                        </li> 
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Laporan/sisa_produksi">
                            <i class="fa fa-trash"></i>
                            Sisa Produksi </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Laporan/kapasitas_mesin">
                            <i class="fa fa-sun-o"></i>
                            Kapasitas Mesin </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Laporan/kapasitas_oven">
                            <i class="fa fa-tint"></i>
                            Kapasitas Oven </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Laporan/rendemen">
                            <i class="fa fa-stumbleupon"></i>
                            Rendemen </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Laporan/limbah_harian">
                            <i class="fa fa-trash"></i>
                            Limbah Harian </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Laporan/tagihan_ekspedisi">
                            <i class="fa fa-file-text-o"></i>
                            Tagihan Ekspedisi CV </a>
                        </li>
                    </ul>
                </li>
                
                
                
                
                
                <li <?php echo ($module_name=="BackOffice")? 'class="start active open"': ''; ?>>
                    <a href="javascript:;">
                    <i class="fa fa-fax"></i>
                    <span class="title">BACK OFFICE</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/BackOffice/list_cv">
                            <i class="fa fa-bank"></i>
                            List CV </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/BackOffice/register_customer">
                            <i class="fa fa-user"></i>
                            Register Customer </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/BackOffice/sales_order">
                            <i class="fa fa-file-o"></i>
                            Sales Order </a>
                        </li>
                        <li <?php echo ($function_name=="delivery_order" || $function_name=="pecah_do" || $function_name=="list_do_cv")? 'class="start active open"': ''; ?>>
                            <a href="javascript:;">
                            <i class="fa fa-car"></i>
                            <span class="title">Delivery Order</span>
                            <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BackOffice/delivery_order">
                                    <i class="fa fa-truck"></i>
                                    List DO Pabrik </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BackOffice/pecah_do">
                                    <i class="fa fa-crosshairs"></i>
                                    Pecah DO </a>
                                </li>
                                <!--li>
                                    <a href="<?php echo base_url(); ?>index.php/BackOffice/list_do_cv">
                                    <i class="fa fa-crosshairs"></i>
                                    List DO CV</a>
                                </li-->
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/BackOffice/list_ekspedisi">
                            <i class="fa fa-truck"></i>
                            Ekspedisi </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>index.php/SinkronisasiByEmail">
                    <i class="fa fa-desktop"></i>
                        <span class="title">SINKRONISASI DATA</span>
                    </a>
                </li>
                <li <?php if(substr($module_name,0,1)=="M" && $module_name!="Modules") echo 'class="start active open"'; ?>>
                    <a href="javascript:;">
                    <i class="icon-folder"></i>
                    <span class="title">MASTER</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/MAgen">
                            <i class="fa fa-user"></i>
                            Daftar Agen </a>
                        </li>
                        
                        <li>
                            <a href="javascript:;">
                            <i class="fa fa-car"></i> Kendaraan <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">                              
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/MTypeKendaraan">
                                        <i class="fa fa-car"></i> Type Kendaraan</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/MKendaraan">
                                        <i class="fa fa-taxi"></i> Daftar Kendaraan</a>
                                </li>                                
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/MBiaya">
                                <i class="fa fa-pied-piper"></i> Biaya</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/MMuatan">
                                <i class="fa fa-cube"></i> Muatan</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/MNumberings">
                                <i class="fa fa-sort-numeric-asc"></i> Numberings</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/MProvinces">
                                <i class="fa fa-globe"></i> Provinsi</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/MCities">
                                <i class="fa fa-globe"></i> Kota</a>
                        </li>
                    </ul>
                </li>
                <li <?php if($module_name=="Groups" || $module_name=="Users" || $module_name=="Modules") echo 'class="start active open"'; ?>>
                    <a href="javascript:;">
                    <i class="icon-settings"></i>
                    <span class="title">System and Utility</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Groups">
                            Group Management</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Users">
                            User Management</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Modules">
                            Module Management</a>
                        </li>                                             
                    </ul>
                </li>
                
                <li class="last ">
                    &nbsp;
                </li>
            </ul>
        </div>
    </div>
    <!-- CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- STYLE CUSTOMIZER -->
            <div class="theme-panel hidden-xs hidden-sm">
                <div class="toggler">
                </div>
                <div class="toggler-close">
                </div>
                <div class="theme-options">
                    <div class="theme-option theme-colors clearfix">
                        <span>
                        THEME COLOR </span>
                        <ul>
                            <li class="color-default current tooltips" data-style="default" data-container="body" data-original-title="Default">
                            </li>
                            <li class="color-darkblue tooltips" data-style="darkblue" data-container="body" data-original-title="Dark Blue">
                            </li>
                            <li class="color-blue tooltips" data-style="blue" data-container="body" data-original-title="Blue">
                            </li>
                            <li class="color-grey tooltips" data-style="grey" data-container="body" data-original-title="Grey">
                            </li>
                            <li class="color-light tooltips" data-style="light" data-container="body" data-original-title="Light">
                            </li>
                            <li class="color-light2 tooltips" data-style="light2" data-container="body" data-html="true" data-original-title="Light 2">
                            </li>
                        </ul>
                    </div>
                    <div class="theme-option">
                        <span>
                        Theme Style </span>
                        <select class="layout-style-option form-control input-sm">
                            <option value="square" selected="selected">Square corners</option>
                            <option value="rounded">Rounded corners</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span>
                        Layout </span>
                        <select class="layout-option form-control input-sm">
                            <option value="fluid" selected="selected">Fluid</option>
                            <option value="boxed">Boxed</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span>
                        Header </span>
                        <select class="page-header-option form-control input-sm">
                            <option value="fixed" selected="selected">Fixed</option>
                            <option value="default">Default</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span>
                        Top Menu Dropdown</span>
                        <select class="page-header-top-dropdown-style-option form-control input-sm">
                            <option value="light" selected="selected">Light</option>
                            <option value="dark">Dark</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span>
                        Sidebar Mode</span>
                        <select class="sidebar-option form-control input-sm">
                            <option value="fixed">Fixed</option>
                            <option value="default" selected="selected">Default</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span>
                        Sidebar Menu </span>
                        <select class="sidebar-menu-option form-control input-sm">
                            <option value="accordion" selected="selected">Accordion</option>
                            <option value="hover">Hover</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span>
                        Sidebar Style </span>
                        <select class="sidebar-style-option form-control input-sm">
                            <option value="default" selected="selected">Default</option>
                            <option value="light">Light</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span>
                        Sidebar Position </span>
                        <select class="sidebar-pos-option form-control input-sm">
                            <option value="left" selected="selected">Left</option>
                            <option value="right">Right</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span>
                        Footer </span>
                        <select class="page-footer-option form-control input-sm">
                            <option value="fixed">Fixed</option>
                            <option value="default" selected="selected">Default</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- PAGE HEADER-->
            <h3 class="page-title">
            Welcome
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo base_url(); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/<?php echo $judul; ?>"><?php echo $judul; ?></a>
                    </li>
                </ul>
                <div class="page-toolbar">
                    <div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height grey-salt">
                        <i class="icon-calendar"></i>&nbsp;
                        <?php echo date('d F Y'); ?>

                    </div>
                </div>
            </div>