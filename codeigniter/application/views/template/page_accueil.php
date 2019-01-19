
<script type="text/javascript">
function startMatch(){
    var codeMatch = $('#codeMatch').val();
    if(codeMatch == ""){
        return;
    }
    var matchUrl = "<?php echo base_url().'/index.php/match/verifierExistanceDeMatch/';?>";
    
    matchUrl= matchUrl.concat(codeMatch);

    $.ajax({

        url: matchUrl,
        
        error: function() {
            alert('error');
        },

        success: function(data) {
            if(data == 1){
                var joueurUrl = '<?php echo base_url().'/index.php/match/choixNomJoueur/'?>';
                joueurUrl = joueurUrl.concat(codeMatch);
                location.href = joueurUrl;
            }else {
                alert(data);  
            }
        }

    });

}
</script>




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
                            'name' => 'matchCode',
                            'maxlength'=>"8",
                            'class'=>"form-control col-md-12 center_input" ,
                            'placeholder'=>"Code De Match",
                             'id'=>"codeMatch"
                        ));
                        
                        echo '</div>';
                        echo '</div>';
                        echo "<div class='row justify-content-md-center '>";
                        echo "<div class = col-md-4>";

                        echo form_button(array(
                            'class' =>'btn btn-primary custum-btn col-md-6 margin_top_btn',
                            'content' => 'trouver',
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
                <a class="btn btn-primary btn-xl js-scroll-trigger" href="#signIn_Up">SignIn / SignUp</a>
            </div>
        </div>
    </div>
</header>
<section id="signIn_Up">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Chose Your Account</h2>
                <hr class="my-4">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fas fa-4x fa-gem text-primary mb-3 sr-icon-1"></i>
                    <div class="row justify-content-md-center">
                        <button type="button" class="btn btn-primary custum-btn col-md-5 margin_top_btn" data-toggle="modal" data-target="#AdminLoginModel">Admin</button>
                    
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fas fa-4x fa-user text-primary mb-3 sr-icon-2"></i>
                    <div class="row justify-content-md-center">
                        <button type="button" class="btn btn-primary custum-btn col-md-5 margin_top_btn" data-toggle="modal" data-target="#FormateurLoginModel">Formateur</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="news" style="background-color:#212529" >
<div class="container-fluid ">
        <div class="row">
            <div class="col-lg-12 mx-auto text-center mar">
                <div class="row justify-content-md-center justify-content-sm-center">
                    <?php
                      foreach ($actu as $value)
                      {
                        echo '<div class="card m-3" style="width: 18rem;" >
                        <div class="card-body">
                          <h5 class="card-title">'.$value['cpt_pseudo'].'</h5>
                          <h6 class="card-subtitle mb-2 text-muted">'.$value['act_date_debut'].'</h6>
                          <p class="card-text">'.$value['act_descriptif'].'</p>
                        </div>
                      </div>';
                      }
                    ?>

                </div>
            </div>

        </div>
</section>

<!-- Bootstrap core JavaScript -->
<script src="<?php echo base_url();?>style/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>style/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Plugin JavaScript -->
<script src="<?php echo base_url();?>style/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?php echo base_url();?>style/vendor/scrollreveal/scrollreveal.min.js"></script>
<script src="<?php echo base_url();?>style/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<!-- Custom scripts for this template -->
<script src="<?php echo base_url();?>style/js/creative.min.js"></script>