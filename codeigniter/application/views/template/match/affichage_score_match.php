<?php
    if(!isset($joueurPseudo)){
        redirect(base_url());
    }
?>
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
               <div class="col-lg-6 mx-auto" style='box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);'>
                  <div class="container justify-content-md-center">
                      <br>
                     <table class="table text-white  text-center">
                        <tbody>
                           <tr>
                              <td>
                                 <h4>Nom du joueur</h4>
                              </td>
                              <td>
                                <h4><?php echo $joueurPseudo;?> </h4>
                              </td>
                           </tr>
                           <tr>
                              <td>
                                 <h4>Nombre total des questions</h4>
                              </td>
                              <td>
                                <h4><?php echo $nombreDesQuestion;?> </h4>
                              </td>
                           </tr>
                           <tr>
                              <td>
                                 <h4>Nombre Des Bonnes réponses</h4>
                              </td>
                              <td>
                                 <h4><?php echo $nombreDesBonnesReponse;?> </h4>
                              </td>
                           </tr>
                           <tr>
                              <td>
                                 <h4>Pourcentage des bonnes réponses</h4>
                              </td>
                              <td>
                                 <h4><?php echo $pourcentageDesReponse;?>%</h4>
                              </td>
                           </tr>
                           <tr>
                              <td>
                                 <h4>Score Total</h4>
                              </td>
                              <td>
                              <h4><?php echo $scoreFinalDesQustion;?></h4>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#matchReponseModel">
                            Voir les bonnes réponses
                        </button>
                        <br>
                        <br>

                  </div>
                 
               </div>
            </div>
         </div>
      </header>
      
    
<!-- Modal -->
<div class="modal fade" id="matchReponseModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Les réponses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <?php
            if( !isset($match['0'])){
               echo "Vous ne pouvez pas voir les réponses de ce match car vous n’avez pas l'autorisation !";
            }else{
                  echo "<p> match : ".$match[0]['match_intitule']."</p>";
                  echo "<p> quiz : ".$match[0]['quiz_intitule']."<br> les question : </p>";
                  $question = -1;
                  foreach ($match as $row) {
                      if($question != $row['qst_id']){
                          echo "</ul>";
                          echo "<p>".$row['qst_libelle']."</p><br>";
                          echo "<ul>";
                          $question = $row['qst_id'];
                      }

                      echo '<li style="color:green">'.$row['rep_libelle']."</li>";
                  }     
            }
                    
      ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
        
      <!-- Bootstrap core JavaScript -->
      <script src="<?php echo base_url();?>style/vendor/jquery/jquery.min.js"></script>
      <script src="<?php echo base_url();?>style/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- Plugin JavaScript -->
      <script src="<?php echo base_url();?>style/vendor/jquery-easing/jquery.easing.min.js"></script>
      <script src="<?php echo base_url();?>style/vendor/scrollreveal/scrollreveal.min.js"></script>
      <script src="<?php echo base_url();?>style/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
      <!-- Custom scripts for this template -->
      <script src="<?php echo base_url();?>style/js/creative.min.js"></script>

