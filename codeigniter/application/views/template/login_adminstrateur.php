
<div class="modal fade" id="AdminLoginModel" tabindex="-1" role="dialog" aria-hidden="<?php if(isset($isHidding)) echo $isHidding; else echo "true"?>">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container" style="margin-top:30px">
                    <div class="col-md-12">
                        <div class="login-panel panel panel-default">
                            <div class="panel-heading justify-content-md-center">
                                <h3 class="login_title">Admin</h3>
                            </div>
                            <div class="panel-body">
                            <?php
                                echo form_open('index.php/compte/connecterAdministrateur');
                                echo form_fieldset();
                            ?>

                            <div class="form-group">
                            <?php
                                if(isset($errorMessageAdmin)){
                                    echo "<div class='alert alert-danger' role='alert'>";
                                    echo "<p>".$errorMessageAdmin."</p>";
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
    if(isset($isVisibleAdmin)){
        if($isVisibleAdmin){
             echo"<script type='text/javascript'>
                            $('#AdminLoginModel').modal({
                            show: true
                            })
                    </script>";
     }
    }

?>
