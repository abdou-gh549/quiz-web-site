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

<section>
   <div class="container">
      <div class="row justify-content-md-center">
         <div class="col-lg-8" style='box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);'>
               <?php
               echo form_open( base_url().'/index.php/match/matchTerminier');

               if(isset($match) && $match){
                    echo "<h1> match : ".$match[0]['match_intitule']."</h1>";
                    echo "<h3> quiz : ".$match[0]['quiz_intitule']."</h3>";
                    $question = -1;
                    foreach ($match as $row) {
                        if($question != $row['qst_id']){
                            echo"</fieldset>";
                            echo "</ul>";
                            echo "<h4>-". $row['qst_libelle']."</h4><br>";
                            echo "<ul>";
                            echo "<fieldset>";
                            $question = $row['qst_id'];
                        }

                        echo '<li style = "list-style-type: none;"><input type="checkbox" name="'.$row['rep_id'].'"';
                        echo '/>  '.$row['rep_libelle'];
                        echo "</li>";
                    }
               }      
               ?>
               <br>
               <div class="row  justify-content-md-center">
               <?php  
               $data = array(
                  'class'         => 'btn btn-primary ',
                  'name'          => 'button',
                  'id'            => 'button',
                  'value'       => 'Terminer');
               
               echo form_submit($data);
               echo form_close();
               ?>
               </div>
         </div>
      </div>
   </div>
</section>