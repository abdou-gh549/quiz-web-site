<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>Gh Quiz </title>
      <!-- Bootstrap core CSS -->
      <link href="<?php echo base_url();?>style/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom fonts for this template -->
      <link href="<?php echo base_url();?>style/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
      <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
      <!-- Plugin CSS -->
      <link href="<?php echo base_url();?>style/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="<?php echo base_url();?>style/css/creative.min.css" rel="stylesheet">
      <link href="<?php echo base_url();?>style/css/style.css" rel="stylesheet">
   </head>
   <body id="page-top">
      <!-- Navigation -->
      <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
         <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">Gh Quiz</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
               <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                     <a class="nav-link js-scroll-trigger" href="#page-top">Accueil</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link js-scroll-trigger" href="#signIn_Up">Connect</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link js-scroll-trigger" href="#news">Actualités</a>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <header class="masthead text-center text-white d-flex">
         <div class="container my-auto">
            <div class="row ">
               <div class="col-lg-10 mx-auto">
                  <h1 class="text-uppercase">
                     <strong>Testez vos connaissances avec GH QUIZ</strong>
                  </h1>
                  <div class="container">
                     <div class="row justify-content-md-center">
                        <input type="text" maxlength="8" class="form-control col-md-4 center_input" placeholder="Code De Match" id="inputDefault">
                     </div>
                     <div class="row justify-content-md-center">
                        <button type="button" class="btn btn-primary custum-btn col-md-2 margin_top_btn">trouver</button>
                     </div>
                  </div>
                  <div class="form-group container ">
                  </div>
                  <hr>
               </div>
               <div class="col-lg-8 mx-auto">
                  <p class="text-faded mb-5">
                     La simplicité d’utilisation associée aux puissantes fonctionnalités de Gh Quiz permet à l’ensemble des professionnels, étudiants et particuliers de réaliser et diffuser des questionnaires formatifs en quelques clics.
                  </p>
                  <a class="btn btn-primary btn-xl js-scroll-trigger" href="#signIn_Up">SignIn / SignUp</a>
               </div>
            </div>
         </div>
      </header>
      <section id="signIn_Up">
         <div class="container">
            <div class="row">
               <div class="col-lg-12 text-center">
                  <h2 class="section-heading">Chose Your Account</h2>
                  <hr class="my-4">
               </div>
            </div>
         </div>
         <div class="container">
            <div class="row justify-content-md-center">
               <div class="col-lg-3 col-md-6 text-center">
                  <div class="service-box mt-5 mx-auto">
                     <i class="fas fa-4x fa-gem text-primary mb-3 sr-icon-1"></i>
                     <div class = "row justify-content-md-center">
                        <button type="button" class="btn btn-primary custum-btn col-md-5 margin_top_btn" data-toggle="modal" data-target="#AdminLoginModel">Admin</button>
                        <!-- Modal -->
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6 text-center">
                  <div class="service-box mt-5 mx-auto">
                     <i class="fas fa-4x fa-paper-plane text-primary mb-3 sr-icon-2"></i>
                     <div class = "row justify-content-md-center">
                        <button type="button" class="btn btn-primary custum-btn col-md-5 margin_top_btn" data-toggle="modal" data-target="#FormateurLoginModel">Formateur</button>
                        <!-- Modal -->
                        
                    </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <hr/>


      <section id="news">
         <div class="container">
            <div class="row">
               <div class="col-lg-8 mx-auto text-center">
                  <h2 class="section-heading">Actualités</h2>
                  <hr class="my-4">
                  <p class="mb-5">Ready to start your next project with us? That's great! Give us a call or send us an email and we will get back to you as soon as possible!</p>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-4 ml-auto text-center">
                  <i class="fas fa-phone fa-3x mb-3 sr-contact-1"></i>
                  <p>123-456-6789</p>
               </div>
               <div class="col-lg-4 mr-auto text-center">
                  <i class="fas fa-envelope fa-3x mb-3 sr-contact-2"></i>
                  <p>
                     <a href="mailto:your-email@your-domain.com">feedback@startbootstrap.com</a>
                  </p>
               </div>
            </div>
         </div>
      </section>

      <!-- Bootstrap core JavaScript -->
      <script src="<?php echo base_url();?>style/vendor/jquery/jquery.min.js"></script>
      <script src="<?php echo base_url();?>style/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- Plugin JavaScript -->
      <script src="<?php echo base_url();?>style/vendor/jquery-easing/jquery.easing.min.js"></script>
      <script src="<?php echo base_url();?>style/vendor/scrollreveal/scrollreveal.min.js"></script>
      <script src="<?php echo base_url();?>style/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
      <!-- Custom scripts for this template -->
      <script src="<?php echo base_url();?>style/js/creative.min.js"></script>
      <h1> <?php echo base_url();?></h1>
   </body>
</html>