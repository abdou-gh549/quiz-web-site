

<!------ Include the above in your HEAD tag ---------->
<?php 
   if(!isset($match['0'])){
      redirect(base_url());
   }
   // access not allowed case !!
   if( strcmp($_SESSION['userPseudo'],$match['0']['cpt_pseudo']) ){
      echo "<div class='alert alert-danger' role='alert'>";
      echo "<p>Vous ne pouvez pas modifier ce match car vous n’en êtes pas l’auteur !</p>";
      echo "</div>";   
      echo form_open( base_url().'/index.php/formateur/viewMatchOfQuiz/'.$match[0]['quiz_id']);
      $data = array(
         'class'         => 'btn btn-primary',
         'name'          => 'button',
         'id'            => 'button',
         'value'       => 'annuler');
      echo form_submit($data);
      echo form_close();
      return;
   }
   if(isset($errorMessage)){
       echo "<div class='alert alert-danger' role='alert'>";
       echo "<p>".$errorMessage."</p>";
       echo "</div>";   
   }else if(isset($editSuccess)){
       echo '<div class="alert alert-success" role="alert">';
       echo '<p>change avec Succès<p>';
       echo '</div>';
   }
   
   echo form_open('index.php/formateur/editMatchValidation/'.$match[0]['match_code']);
   echo form_fieldset();
   
   ?>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   <div class="panel panel-info">
      <div class="panel-body">
         <div class="row">
            <table class="table table-user-information">
               <tbody>
                <tr>
                     <td>Match Code</td>
                     <td>
                        <?php echo $match[0]['match_code'];?>
                     </td>
                  </tr>
                  <tr>
                     <td>Intitul</td>
                     <td>
                     <?php
                        echo form_input(['class'=>"form-control",
                        'placeholder'=>'intitule',
                        'name' => "intitule",
                        'type'=>"text",
                        'value'=>$match[0]['match_intitule']
                     ]);
                     ?>
                     </td>
                  </tr>
                  
                  <tr>
                     <td>Date Debut</td>
                     <td>
                        <?php
                            echo form_input(['class'=>"form-control",
                                           'placeholder'=>'20/02/2085',
                                           'name' => "dateDebut",
                                           'type'=>"date",
                                           'value'=> substr($match[0]['match_date_debut'],0,10)
                                           ]);
                        ?>
                     </td>
                  </tr>
                  <tr>
                     <td>Heur Debut</td>
                     <td>
                        <?php
                            echo form_input(['class'=>"form-control",
                                           'placeholder'=>'20/02/2085',
                                           'name' => "heurDebut",
                                           'type'=>"time",
                                           'value' => substr($match[0]['match_date_debut'],11,19)
                                        ]);
                        ?>
                     </td>
                  </tr>
                  <tr>
                     <td>Date Fin</td>
                     <td>
                        <?php
                           echo form_input(['class'=>"form-control",
                                           'placeholder'=>'30/12/1997',
                                           'name' => "dateFin",
                                           'type'=>"date",
                                           'value'=> substr($match[0]['match_date_fin'],0,10)
                                          ] );
                           ?> 
                     </td>
                  </tr>
                  <tr>
                     <td>Heur Fin</td>
                     <td>
                        <?php
                           echo form_input(['class'=>"form-control",
                                           'placeholder'=>'30/12/1997',
                                           'name' => "heurFin",
                                           'type'=>"time",
                                           'value' => substr($match[0]['match_date_fin'],11,19)
                                          ]);
                           ?> 
                     </td>
                  </tr>
                 
                  <tr>
                     <td>
                        Consulation des reponses autorisée 
                     </td>
                     <td>
                        <?php
                        echo   '<input class = "form-control" type="checkbox" name="matchVisibility" value="Car" ';
                        if($match[0]['match_visibility'] == 1)
                           echo "checked";
                        echo "/>";
                        ?>
                     </td>

                  </tr>
                 
                  <tr>
                     <td>
                 
                    <?php 

                                       
                        echo form_submit(['class'=>"btn btn-primary custum-btn col-md-12 margin_top_btn",
                        'value'=>"valider",
                        'type'=>"submit"]
                        );
                              
                        echo form_fieldset_close();
                        echo form_close();              
                        
                        echo "</td><td>";
                        echo form_open( base_url().'/index.php/formateur/viewMatchOfQuiz/'.$match[0]['quiz_id']);
                        $data = array(
                           'class'         => 'btn btn-primary',
                           'name'          => 'button',
                           'id'            => 'button',
                           'value'       => 'annuler');
                        echo form_submit($data);
                        echo form_close();
                        
                           ?>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
</div>
</div>
</div>
