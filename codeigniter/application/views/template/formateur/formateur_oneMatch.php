
<div class="container">
      <div class="row">
         <div class="col-lg-12 ">
            <a href="#tableOfMatch">
                <button class = "btn btn-primary">tables des matchs</button>
            </a>
             <?php
               if(isset($match)){
                    $question = -1;
                    $matchFound = false;

                    foreach ($match as $row) {
                            // nv match a imprimer
                            if( !$matchFound){
                                echo "<h3> match : ".$row['match_intitule']."</h3>";
                                echo "<h4> match code : ".$row['match_code']."</h4>";
                                echo "<h4> quiz : ".$row['quiz_intitule']."</h4>";
                                echo "<h4> score moyenne de match : ".$row['match_score']."</h4>";
                                $matchFound = true;
                            }
                                           
                            $question = -1;
                            foreach($match as $row2){
                                    if($question != $row2['qst_id']){
                                        echo "</ul>";
                                        echo "<h6>". $row2['qst_libelle']."</h6>";
                                        echo "<ul>";
                                        $question = $row2['qst_id'];
                                    }
                                    
                                    echo "<li>".$row2['rep_libelle'];
                                    
                                    if(  $row2['rep_valeur'] == 0){
                                        echo "<font color='#f30e5c'> ( faux ) </font>.";
                                    }else{
                                        echo "<font color='#228c7b'> ( vrais ) </font>.";
                                    }
                                    echo "</li>";
                                
                            }

                            if($matchFound)
                                break;      
                        }
                        
                }
                    if( ! $matchFound )
                         redirect( base_url().'index.php/formateur/match');
                  ?>
            
         </div>
      </div>
   </div>