
<div class="modal fade" id="FormateurLoginModel" tabindex="-1" role="dialog" aria-hidden="true">
    
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container" style="margin-top:30px">
                    <div class="col-md-12">
                        <div class="login-panel panel panel-default">
                            <div class="panel-heading justify-content-md-center">
                                <h3 class="login_title">Formateur</h3>
                            </div>
                            <div class="panel-body">
                            <?php
                                echo form_open('index.php/compte/connecterFormateur');
                                echo form_fieldset();
                            ?>

                            <div class="form-group">
                            
                                <?php
                                
                                if(isset($errorMessageFormateur)){
                                    echo "<div class='alert alert-danger' role='alert'>";
                                    echo "<p>".$errorMessageFormateur."</p>";
                                    echo "</div>";   
                                }
                            
                                echo form_input(['class'=>"form-control",
                                                'placeholder'=>'Pseudo',
                                                'name' => "userPseudo",
                                                'type'=>"Text"]
                                                );
                                ?>
                                                        

                            </div>

                            <div class="form-group">
                                <?php
                                echo form_input(['class'=>"form-control",
                                                'placeholder'=>'Password',
                                                'name' => "userPassword",
                                                'type'=>"Password"]
                                                );
                                ?>
                            </div>

                            

                            <?php 
                                echo form_submit(['class'=>"btn btn-primary custum-btn col-md-5 margin_top_btn",
                                                'value'=>"s'identifier",
                                                'type'=>"submit"]
                                                );
                                    
                                echo form_fieldset_close();
                                echo form_close();

                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
    if(isset($isVisibleFormateur)){
        
        if($isVisibleFormateur){
             echo"<script type='text/javascript'>
                            $('#FormateurLoginModel').modal({
                            show: true
                            })
                    </script>";
     }
     
    }

?>
