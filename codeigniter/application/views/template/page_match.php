
<section>
   <div class="container">
      <div class="row">
         <div class="col-lg-12 ">
            <h3 class="section-heading">
               <?php

               if(isset($match) && $match){
                    echo "<h1> match : ".$match[0]['match_intitule']."</h1>";
                    echo "<h3> quiz : ".$match[0]['quiz_intitule']."</h3>";
                    $question = -1;
                    //strcmp 
                    
                    foreach ($match as $row) {
                        if($question != $row['qst_id']){
                            echo "</ul>";
                            echo "<h4>". $row['qst_libelle']."</h4><br>";
                            echo "<ul>";
                            $question = $row['qst_id'];
                        }
                        echo "<li>".$row['rep_libelle'];
                        if($row['rep_valeur'] == 0){
                            echo "<font color='#f30e5c'> ( faux ) </font>.";
                        }else{
                            echo "<font color='#228c7b'> ( vrais ) </font>.";
                        }
                        
                        echo "</li>";
                        
                    }
               }
                  
                  
                  ?>
            </h3 >
            <hr class="my-4">
         </div>
      </div>
   </div>
</section>