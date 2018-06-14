<html lang="en">
<head>
<meta charset="utf-8"/>
<title>Sagu</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>

<!-- PAGE LEVEL STYLES -->
<link href="<?php echo base_url(); ?>assets/admin/pages/css/login.css" rel="stylesheet" type="text/css"/>

<!-- BEGIN THEME STYLES -->
<link href="<?php echo base_url(); ?>assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo base_url(); ?>assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>

<!--link rel="shortcut icon" href="favicon.ico"/-->
</head>
<body class="login">
<div class="menu-toggler sidebar-toggler"></div>

<!-- LOGO -->
<div class="logo">
    <!--a href="index.html">
        <img src="assets/admin/layout/img/logo-big.png" alt=""/>
    </a-->
</div>

<!-- LOGIN -->
<div class="content">
    <!-- LOGIN FORM -->
    <form class="login-form" method="post">
        <h3 class="form-title">Sign In</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span id="message">&nbsp;</span>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Username</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" 
                autocomplete="off" placeholder="Username" id="username" name="username"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" 
                autocomplete="off" placeholder="Password" id="password" name="password"/>
        </div>
        <div class="form-actions">
            <button type="button" class="btn btn-success uppercase" onclick="go_login()">Login</button>            
            <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
        </div>        
        <div class="create-account">
            <p><font color="white">2017 &copy; Funedge. The realm of digital.</font></p>
        </div>
    </form>

    <!-- FORGOT PASSWORD FORM -->
    <form class="forget-form" method="post">
        <h3>Forget Password ?</h3>
        <p>
            Enter your e-mail address below to reset your password.
        </p>
        <div class="form-group">
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn btn-default">Back</button>
            <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
        </div>
    </form>	
</div>

<!-- CORE PLUGINS -->
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>

<!-- PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>

<!-- PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/login.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {     
    Metronic.init();
    Layout.init();
    Login.init();
    Demo.init();
});

function go_login(){    
    if($.trim($("#username").val()) == ""){
        $('#message').html("Username can`t be blank!");
        $('.alert-danger').show();
    }else if($.trim($("#password").val()) == ""){
        $('#message').html("Password can`t be blank!");
        $('.alert-danger').show();
    }else{        
        $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/Login/aksi_login'); ?>',
            data:"data="+$("#username").val()+"^"+$("#password").val(),
            success:function(result){	
                console.log(result);
                if(result=="SALAH"){
                    $('#message').html("Your username or password is invalid!");
                    $('.alert-danger').show();
                }else{
                    $('#message').html("");
                    $('.alert-danger').hide();
                    window.location.href = '<?php echo base_url("index.php"); ?>'; 
                }
            }
        });
    }    
}
</script>
</body>
</html>