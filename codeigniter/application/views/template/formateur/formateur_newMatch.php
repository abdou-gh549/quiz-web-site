

<!------ Include the above in your HEAD tag ---------->

<?php 
   if(isset($errorMessage)){
       echo "<div class='alert alert-danger' role='alert'>";
       echo "<p>".$errorMessage."</p>";
       echo "</div>";   
   }else if(isset($editSuccess)){
      echo '<div class="alert alert-success" role="alert">';
      echo '<p>l\'ajout est terminer avec Succès<p>';
      echo '</div>';
  }
   
   echo form_open('index.php/formateur/newMatchValidation/'.$quizId);
   echo form_fieldset();
   
   ?>
<div class="container col-md-6 justify-content-md-center">
 <div class="row ">
            <table class="table table-user-information">
               <tbody>
                  <tr>
                     <td>Intitul</td>
                     <td>
                     <?php
                      echo form_input(['class'=>"form-control",
                                     'placeholder'=>'match intitule',
                                     'name' => "matchIntitule",
                                     'type'=>"text",
                                  ]);
                        
                     ?>
                     </td>
                  </tr>
                  
                  <tr>
                     <td>Date Debut</td>
                     <td>
                        <?php
                            echo form_input(['class'=>"form-control",
                                           'placeholder'=>'dd/mm/yyyy',
                                           'name' => "dateDebut",
                                           'type'=>"date",
                                       //    'value'=>$compte_information->cpt_nom
                                        ]);
                        ?>
                     </td>
                  </tr>
                  <tr>
                     <td>Date Fin</td>
                     <td>
                        <?php
                           echo form_input(['class'=>"form-control",
                                            'placeholder'=>'dd/mm/yyyy',
                                            'name' => "dateFin",
                                            'type'=>"date",
                                          // 'value'=>$compte_information->cpt_prenom
                                          ] );
                           ?> 
                     </td>
                  </tr>
                  <tr>
                     <td>
                        Consulation des reponses autorisée 
                     </td>
                     <td>
                        <?php
                        echo form_input(['class'=>"form-control",
                                       'name' => "matchVisibility",
                                       'type'=>"checkbox",
                                       'value'=>'0',
                                       // 'value'=>$compte_information->cpt_prenom
                                       ] );
                        ?>
                     </td>

                  </tr>
                 
               </tbody>
            </table> 
            
<div class="row">

<div class="col-md-12">       

        <?php 
        echo form_submit(['class'=>"btn btn-primary custum-btn col-md-12 margin_top_btn",
                        'value'=>"valider",
                        'type'=>"submit"]
                        );
            
        echo form_fieldset_close();
        echo form_close();
        echo form_open( base_url().'index.php/formateur/match/');
        $data = array(
            'class'         => 'btn btn-primary',
            'name'          => 'button',
            'id'            => 'button',
            'value'       => 'annuler');
        echo form_submit($data);
        echo form_close();

        ?>
        </div>
        </div>    

</div>
   </div>
</div>
