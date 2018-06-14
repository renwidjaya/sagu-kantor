<div class="row">                            
    <div class="col-md-12">       
        <?php
            if( ($group_id==1)||($hak_akses['detail_inventory']==1) ){
        ?>
        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-5">Nama CV</div>
                    <div class="col-md-7">
                        <input type="text" id="nama_cv" name="nama_cv" readonly="readonly" class="form-control myline"
                               value="<?php echo $nama_cv; ?>" 
                               style="margin-bottom:5px">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">Barang/ Produk</div>
                    <div class="col-md-7">
                        <input type="text" id="nama_produk" name="nama_produk" readonly="readonly"
                            value="<?php echo $produk; ?>" class="form-control myline" 
                            style="margin-bottom:5px">
                    </div>
                </div>
            </div>            
        </div>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-file-o"></i>List Detail Inventory
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover">
                        <?php echo $myTable; ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo base_url('index.php/Laporan/inventory'); ?>" class="btn blue-ebonyclay">
                    Kembali</a>
                
                <?php
                    if( ($group_id==1)||($hak_akses['print_detail_inventory']==1) ){
                        echo '<a href="'.base_url().'index.php/Laporan/print_detail_inventory2/'.$type_produk.'/'.$produk.'/'.$m_cv_id.'" 
                            class="btn green" style="margin-right:0">
                                <i class="fa fa-print"></i> Export to Excel </a>';
                    }
                ?>
            </div>
        </div>
        <?php
            }else{
        ?>
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span id="message">Anda tidak memiliki hak akses ke halaman ini!</span>
        </div>
        <?php
            }
        ?>
    </div>
</div>                       	
