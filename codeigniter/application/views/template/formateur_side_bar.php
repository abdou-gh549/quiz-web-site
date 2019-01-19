<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Formateur</title>

         <!-- Bootstrap CSS CDN -->
         <link href="<?php echo base_url();?>style/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
         <link href="<?php echo base_url();?>style//css/bootstrap.min.css" rel="stylesheet">


        <!-- Our Custom CSS -->
        <link href="<?php echo base_url();?>style/css/style4.css" rel="stylesheet">

    </head>
    <body>

        <div class="wrapper">
            <!-- Sidebar Holder -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>Bootstrap Sidebar</h3>
                    <strong>BS</strong>
                </div>

                <ul class="list-unstyled components">
                    <li class="active">
                        <a href="#homeSubmenu">
                            <i class="glyphicon glyphicon-home"></i>
                            Home
                        </a>
                        
                    </li>
                    <li >
                        <a href="#">
                            <i class="glyphicon glyphicon-briefcase"></i>
                            Matches
                        </a>
                      
                    </li>

                    <li >
                        <a href="#">
                            <i class="glyphicon glyphicon-briefcase"></i>
                            Profile
                        </a>
                      
                    </li>

                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-link"></i>
                            Portfolio
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-paperclip"></i>
                            FAQ
                        </a>
                    </li>
                    <li>
                        

                        <a href= "<?php echo base_url();?>index.php/formateur/disconect">
                            <i class="glyphicon glyphicon-send"></i>
                            Déconnexion
                        </a>
                    </li>
                </ul>

               
            </nav>
