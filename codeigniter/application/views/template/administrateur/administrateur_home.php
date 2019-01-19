<div class="container">
        <div class="row">
            <div class="col-lg-12 mx-auto text-center mar">
                <div class="row justify-content-md-center justify-content-sm-center">
                    <?php

                      foreach ($actu as $value)
                      {
                        echo '<div class="card m-1" style="width: 18rem;" >
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