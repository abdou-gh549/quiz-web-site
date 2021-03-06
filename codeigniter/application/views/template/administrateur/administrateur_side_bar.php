<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>administrateur</title>

         <!-- Bootstrap CSS CDN -->
       <link href="<?php echo base_url();?>style/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


        <!-- Our Custom CSS -->
        <link href="<?php echo base_url();?>style/css/style4.css" rel="stylesheet">

    </head>
    <body>

        <div class="wrapper">
            <!-- Sidebar Holder -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>Administrateur</h3>
                    <strong>AD</strong>
                </div>

                <ul class="list-unstyled components">
                    <li <?php if( isset($selectedOption) && !strcmp($selectedOption,'home')) echo 'class="active"'; ?>>
                        <a href="<?php echo base_url();?>index.php/administrateur/home" >
                            <i class="glyphicon glyphicon-home"></i>
                            Actualités
                        </a>
                    </li>
                    <li <?php if( isset($selectedOption) && !strcmp($selectedOption,'comptes')) echo 'class="active"'; ?>>
                        <a href="<?php echo base_url();?>index.php/administrateur/comptes" >
                            <i class="glyphicon glyphicon-briefcase"></i>
                            Comptes
                        </a>
                    </i>
                    <li <?php if( isset($selectedOption) && !strcmp($selectedOption,'profile')) echo 'class="active"'; ?>>
                    <a href="<?php echo base_url();?>index.php/administrateur/profile" >
                            <i class="glyphicon glyphicon-duplicate"></i>
                            Profile
                        </a>
                    </li>
                
                    <li>
                        

                        <a href= "<?php echo base_url();?>index.php/administrateur/disconect">
                            <i class="glyphicon glyphicon-send"></i>
                            Déconnexion
                        </a>
                    </li>
                </ul>

            </nav>
            <div id="content" class = "container-fluid">

<nav class="navbar navbar-default">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                <i class="glyphicon glyphicon-align-left"></i>
                <span>Toggle Sidebar</span>
            </button>
        </div>
    </div>
</nav>
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
         <!-- Bootstrap Js CDN -->
         <script src="<?php echo base_url();?>style/vendor/bootstrap/js/bootstrap.min.js"></script>
         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
             });
</script>
