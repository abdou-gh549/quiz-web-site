

 <!-- Page Content Holder -->
<div id="content" class = "container-fluid">
<nav class="navbar navbar-default">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                <i class="glyphicon glyphicon-align-left"></i>
                <span>Toggle Sidebar</span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Page</a></li>
                <li><a href="#">Page</a></li>
                <li><a href="#">Page</a></li>
                <li><a href="#">Page</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <?php
        
        $data = array(
            'value'         => 'disconnect',
           // 'onClick'       => base_url()."index.php/formateur/disconect"
        );
        echo form_submit(['class'=>"btn btn-primary custum-btn col-md-12 margin_top_btn",
                                                'value'=>"disconnect",
                                                'type'=>"submit",
                                                'onClick'       =>"location.href='".base_url()."index.php/formateur/disconect'"
                                                ]
                                            );

    ?>

</div>


<div class="container-fluid">
    <?php
      echo "pseudo : ".$compte_information->cpt_pseudo."<br>";
      echo "mdp : ".$compte_information->cpt_mdp."<br>";
      echo "nom : ".$compte_information->cpt_nom."<br>";
      echo "prenom : ".$compte_information->cpt_prenom."<br>";
      ?>

</div>

<!---
<div class="line"></div>

<h2>Lorem Ipsum Dolor</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
-->
<div class="line "></div>

</div>
</div>
