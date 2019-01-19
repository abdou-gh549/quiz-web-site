
<style> 
/* FontAwesome for working BootSnippet :> */

        @import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        #team {
            background: #eee !important;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #108d6f;
            border-color: #108d6f;
            box-shadow: none;
            outline: none;
        }

        .btn-primary {
            color: #fff;
            background-color: #7386D5;
            border-color: #7386D5;
        }

        section {
            padding: 40px 0;
        }

        section .section-title {
            text-align: center;
            color: #7386D5;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        #team .card {
            border: none;
            background: #ffffff;
        }

        .image-flip:hover .backside,
        .image-flip.hover .backside {
            -webkit-transform: rotateY(0deg);
            -moz-transform: rotateY(0deg);
            -o-transform: rotateY(0deg);
            -ms-transform: rotateY(0deg);
            transform: rotateY(0deg);
            border-radius: .25rem;
        }

        .image-flip:hover .frontside,
        .image-flip.hover .frontside {
            -webkit-transform: rotateY(180deg);
            -moz-transform: rotateY(180deg);
            -o-transform: rotateY(180deg);
            transform: rotateY(180deg);
        }

        .mainflip {
            -webkit-transition: 1s;
            -webkit-transform-style: preserve-3d;
            -ms-transition: 1s;
            -moz-transition: 1s;
            -moz-transform: perspective(1000px);
            -moz-transform-style: preserve-3d;
            -ms-transform-style: preserve-3d;
            transition: 1s;
            transform-style: preserve-3d;
            position: relative;
        }

        .frontside {
            position: relative;
            -webkit-transform: rotateY(0deg);
            -ms-transform: rotateY(0deg);
            z-index: 2;
            margin-bottom: 70px;
        }

        .backside {
            position: absolute;
            top: 0;
            left: 0;
            background: white;
            -webkit-transform: rotateY(-180deg);
            -moz-transform: rotateY(-180deg);
            -o-transform: rotateY(-180deg);
            -ms-transform: rotateY(-180deg);
            transform: rotateY(-180deg);
            -webkit-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
            -moz-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
            box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
        }

        .frontside,
        .backside {
            -webkit-backface-visibility: hidden;
            -moz-backface-visibility: hidden;
            -ms-backface-visibility: hidden;
            backface-visibility: hidden;
            -webkit-transition: 1s;
            -webkit-transform-style: preserve-3d;
            -moz-transition: 1s;
            -moz-transform-style: preserve-3d;
            -o-transition: 1s;
            -o-transform-style: preserve-3d;
            -ms-transition: 1s;
            -ms-transform-style: preserve-3d;
            transition: 1s;
            transform-style: preserve-3d;
        }

        .frontside .card,
        .backside .card {
            min-height: 250px;
        }

        .backside .card a {
            font-size: 18px;
            color: #17a2b8 !important;
        }

        .frontside .card .card-title,
        .backside .card .card-title {
            color: #17a2b8 !important;
        }

        .frontside .card .card-body img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
        }
</style>
<!------ Include the above in your HEAD tag ---------->

<!-- Team -->
<section id="team" class="pb-5">
    <div class="container">
        <div class="row">
        <?php 
            if(isset($quiz) && $quiz){
                foreach($quiz as $row){
                    $imageUrl = base_url().'style/img/quiz_image/'.$row['quiz_img'];
                    if( !file_exists ($imageUrl)){
                        $imageUrl = base_url().'style/img/quiz_image/quiz_default_image.png';
                    }
                    echo '
                <!-- Team member -->
                <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="image-flip" ontouchstart="this.classList.toggle("hover");">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="'.$imageUrl.'" alt="card image"></p>
                                    <h4 class="card-title">'.$row['quiz_intitule'].'</h4>
                                </div>
                            </div>
                        </div>
                      
                                <div class="backside ">
                                    <div class="card ">
                                        <div class="card-body text-center pagination-centered center-block">
                                            <h4 class="card-title">'.$row['quiz_intitule'].'</h4>
                                            <p class="card-text">'.$row['quiz_descriptif'].'</p>
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <a class="social-icon text-xs-center" target="_blank" href="#">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a class="social-icon text-xs-center" target="_blank" href="#">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a class="social-icon text-xs-center" target="_blank" href="#">
                                                        <i class="fa fa-copy"></i>
                                                    </a>
                                                </li>
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                    </div>
                </div>
                </div>

                ';
            }
                                

        }
    
    
    ?>

        </div>
    </div>
</section>
<!-- Team -->
<pre>
<?php print_r ($quiz);?>
</pre>