
<!------ Include the above in your HEAD tag ---------->
<?php
   if(isset($errorMessage)){
       echo "<div class='alert alert-danger' role='alert'>";
       echo "<p>".$errorMessage."</p>";
       echo "</div>";   
   } else if(isset($editSuccess)){
      echo '<div class="alert alert-success" role="alert">';
      echo '<p>change avec Succès<p>';
      echo '</div>';
  } 
   
   echo form_open('index.php/administrateur/modifierData');
   echo form_fieldset();
   ?>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   <div class="panel panel-info">
      <div class="panel-body">
         <div class="row">
            <table class="table table-user-information">
               <tbody>
                  <tr>
                     <td>pseudo</td>
                     <td><?php echo $compte_information->cpt_pseudo;?></td>
                  </tr>
                  <tr>
                     <td>Compte Type</td>
                     <td>
                        Administrateur
                     </td>
                  </tr>
                  <tr>
                     <td>Nom</td>
                     <td>
                        <?php
                            echo form_input(['class'=>"form-control",
                                           'placeholder'=>'Nom',
                                           'name' => "nom",
                                           'type'=>"Text",
                                           'value'=>$compte_information->cpt_nom]
                                           );
                        ?>
                     </td>
                  </tr>
                  <tr>
                     <td>Prénome</td>
                     <td>
                        <?php
                           echo form_input(['class'=>"form-control",
                                           'placeholder'=>'Prénom',
                                           'name' => "prenom",
                                           'type'=>"Text",
                                           'value'=>$compte_information->cpt_prenom]
                                           );
                           ?> 
                     </td>
                  </tr>

                  <tr>
                     <td>Nouveau mot de passe</td>
                     <td>
                        <?php
                           echo form_input(['class'=>"form-control",
                                           'name' => "new_password",
                                           'type'=>"password",
                                           'placeholder' => 'Nouveau mot de passe']
                                           );
                           ?>
                     </td>
                  </tr>

                  <tr>
                     <td>Confirmation de mot de passe</td>
                     <td>
                        <?php
                           echo form_input(['class'=>"form-control",
                                           'name' => "confirmation_password",
                                           'type'=>"password",
                                           'placeholder' => 'Confirmation Mot de passe']
                                           );
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
                           echo form_open( base_url().'/index.php/administrateur/profile/');
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

