<div class="row">                            
    <div class="col-md-12">  
        <?php
            if( ($group_id==1)||($hak_akses['index']==1) ){
        ?>    
        <div class="row">                            
            <div class="col-md-12" style="text-align:right; margin-bottom:6px"> 
                <a href="<?php echo base_url(); ?>index.php/Modules/export" 
                    class="btn btn-success">
                    <i class="fa fa-download"></i> Export</a>
                <a href="<?php echo base_url(); ?>index.php/Modules/import" 
                    class="btn btn-success">
                    <i class="fa fa-upload"></i> Import</a>
            </div>
        </div>
        
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                    <div class="caption">
                            <i class="fa fa-cube"></i>Modules
                    </div>
            </div>
            <div class="portlet-body">
                <table class="table table-bordered table-stripped table-hover">
                    <thead>
                        <th>Alias</th>
                        <th>Administrator</th>
                        <?php 
                            foreach ($groups as $value){
                                echo "<th>".$value->group_name."</th>";
                            }
                        ?>
                    </thead>
                    <tbody>
                        <?php
                            echo $konten;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>  
        <?php
            }else{
        ?>
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span id="message">You are not authorized to access that location!</span>
        </div>
        <?php
            }
        ?>
    </div>
</div>  

<script>  
function update_roles(id){
    dt = id.split("_");
    aros_acos = dt[1].split("-");
    module_id = aros_acos[0];
    group_id = aros_acos[1];
    
    if($('#'+id).attr("checked")){
        nilai = 1;
    }else{
        nilai = 0;
    }   
    console.log('module id', module_id);
    console.log('group id', group_id);
    console.log('nilai', nilai);
    $.ajax({
        type:"POST",
        url:"<?php echo base_url('index.php/Modules/update'); ?>",
        data:"data="+module_id + "^" + group_id + "^" + nilai,
        success:function(){
            console.log("Sukses");
        },
        error:function(){
            console.log("Gagal");
        },
    });
}

</script>
        