<script type="text/javascript">
function startMatch(){
    var pseudoUser = $('#pseudoUser').val();
    if(pseudoUser == ""){
        return;
    }
    var matchUrl = "<?php echo base_url().'/index.php/match/joueurPseudoValidation/';?>";
    
    matchUrl= matchUrl.concat(pseudoUser);
    var matchCode = location.href.substr(location.href.lastIndexOf('/') + 1);

    $.ajax({

        url: matchUrl,
        type: 'POST',
        data: { 
        'pseudoJoueur': pseudoUser,
        'matchCode':matchCode
        },

        error: function() {
            alert('error');
        },

        success: function(data) {
            if(data == 0){
                alert("pseudo déjà utilisé !!");
            }else if(data == 1){
                location.href =  "<?php echo base_url().'/index.php/match/startMatch';?>";
            }else{
                alert("oooopss something just happend!!");
            }
        }

    });

}
</script>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>Gh Quiz</title>
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
            <a class="navbar-brand js-scroll-trigger" href="<?php echo base_url();?>">Gh Quiz</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
               <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                     <a class="nav-link js-scroll-trigger" href="<?php echo base_url();?>">Accueil</a>
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
                    
                    <?php
                        echo "<div class='row justify-content-md-center '>";
                        echo "<div class = col-md-6>";
                        echo form_input(array(
                            'type' => 'text',
                            'name' => 'pseudoJoueur',
                            'class'=>"form-control col-md-12 center_input" ,
                            'placeholder'=>"Pseudo Joueur",
                             'id'=>"pseudoUser"
                        ));
                        
                        echo '</div>';
                        echo '</div>';
                        echo "<div class='row justify-content-md-center '>";
                        echo "<div class = col-md-4>";

                        echo form_button(array(
                            'class' =>'btn btn-primary custum-btn col-md-6 margin_top_btn',
                            'content' => 'Commencer',
                            'onClick' => 'startMatch();'
                        ));
                        echo '</div>';
                        echo '</div>';

                    ?>
                </div>
                <div class="form-group container ">
                </div>
                <hr>
            </div>
            <div class="col-lg-8 mx-auto">
                <p class="text-faded mb-5">
                    La simplicité d’utilisation associée aux puissantes fonctionnalités de Gh Quiz permet à l’ensemble des professionnels, étudiants et particuliers de réaliser et diffuser des questionnaires formatifs en quelques clics.
                </p>
            </div>
        </div>
    </div>
</header>

<!-- Bootstrap core JavaScript -->
<script src="<?php echo base_url();?>style/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>style/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Plugin JavaScript -->
<script src="<?php echo base_url();?>style/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?php echo base_url();?>style/vendor/scrollreveal/scrollreveal.min.js"></script>
<script src="<?php echo base_url();?>style/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<!-- Custom scripts for this template -->
<script src="<?php echo base_url();?>style/js/creative.min.js"></script>