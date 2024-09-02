<?php
namespace UTM\Helper;

class HomeHelper{
    public static function displayPortfolio($data=null){
        if(!empty($data)){

            ?>

            <style>
                .portfolio_img {
                    width: auto;
                    height: 200px;
                    overflow: hidden; 
                    position: relative; 
                }

                .portfolio_img img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover; 
                    transition: transform 0.7s ease, filter 1s ease;
                    position: absolute; 
                    top: 0;
                    left: 0;
                    filter: grayscale(100%);
                }

                .portfolio_img img:hover  {
                    transform: scale(1.1); 
                    filter: grayscale(0%);
                }
            </style>

            <?php
            echo '<div class="row py-5 my-5">';
            foreach($data as $item){ 
                ?>
                <div class="col-sm-12 col-md-6 col-lg-4 animate__animated xfadeIn animate__fadeIn">
                    <div class="card mb-3" style="background-color: #121417; ">
                        <div class="portfolio_img">
                            <img src="<?= $item->image[0] ?>" alt="" class="d-block user-select-none rounded-2" width="100%" height="200" aria-label="Placeholder: Image cap" focusable="false" role="img" preserveAspectRatio="xMidYMid slice" viewBox="0 0 318 180" style="font-size:1.125rem;text-anchor:middle;object-fit: contain;">
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title text-white"><?= $item->name ?></h5>
                        </div>
                        <div class="card-body">
                            <?php echo $item->description[0]; ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            echo '</div>';
        }
    }

    public static function displayPortfolio2($data=null){
        if(!empty($data)){
            ?>
            
            <style>
                .cardCustom {
                border-radius: 16px;
                margin: 0 auto;
                max-width: 100%;
                min-height: 200px;
                box-shadow: 0px 3px 5px -1px rgba(0, 0, 0, 0.2),
                    0px 5px 8px 0px rgba(0, 0, 0, 0.14),
                    0px 1px 14px 0px rgba(0, 0, 0, 0.12);
                overflow: hidden;
                background-size: cover;
                background-repeat: no-repeat;
                }

                .infoCustom {
                position: relative;
                width: 100%;
                height: 300px;
                background-color: #fff;
                transform: translateY(100%)
                    translateY(-88px)
                    translateZ(0);
                transition: transform 0.5s ease-out;
                }

                .infoCustom:before {
                z-index: -1;
                display: block;
                position: absolute;
                content: ' ';
                width: 100%;
                height: 100%;
                overflow: hidden;
                filter: blur(10px);
                background-size: cover;
                opacity: 0.25;
                transform: translateY(-100%)
                    translateY(88px)
                    translateZ(0);
                transition: transform 0.5s ease-out;
                }

                .cardCustom:hover .infoCustom,
                .cardCustom:hover .infoCustom:before {
                transform: translateY(0) translateZ(0);
                }

                .title {
                margin: 0;
                padding: 24px;
                font-size: 40px;
                line-height: 1;
                color: rgba(0, 0, 0, 0.87);
                }
            </style>
            
            <?php
            echo '<div class="row py-5 my-5">';
            foreach($data as $item){ 
                ?>
                <div class="col-sm-12 col-md-6 col-lg-4">

                    <div class='cardCustom m-3' style="background-image: url(<?= $item->image[0] ?>); ">
                        <div class='infoCustom px-4'>
                            <h1 class='title px-0'><?= $item->name ?></h1>
                            <?php echo $item->description[0]; ?>
                        </div>
                    </div>

                </div>
            <?php
            }
            echo '</div>';
        }
    }

    public static function displayTimeline($data=null){
        if(!empty($data)){
            ?>
            
            <style>
                .carousel-inner > .carousel-item > img {
                    width: 100%; 
                    height: 400px; 
                    object-fit: cover; 
                }
            </style>
            
            <?php
            $position = 'left'; 
            $num = 0;
            foreach($data as $item){ 
                
                if($position == "left"){ $num++;?>
                    <div class="row my-4">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div id="carouselslide<?= $num ?>" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                        if(!empty($item->image)){
                                            $active = "active";
                                            foreach($item->image as $image_name=>$image_url){?>

                                                <div class="carousel-item <?= $active ?>" data-bs-interval="10000">
                                                    <img class="rounded" src="<?= $image_url ?>" alt="<?= $image_name ?>">
                                                </div>

                                            <?php $active = '';
                                            }
                                        }
                                    ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselslide<?= $num ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselslide<?= $num ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="p-5">
                                <h2 class="text-white"><?= $item->name ?></h2>
                                <?= $item->description[0] ?>
                            </div>
                        </div>
                    </div>

                <?php $position = "right";
                }
                elseif($position == "right"){ $num++;?>

                    <div class="row my-4">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="p-5">
                                <h2 class="text-white"><?= $item->name ?></h2>
                                <?= $item->description[0] ?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div id="carouselslide<?= $num ?>" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                        if(!empty($item->image)){
                                            $active = "active";
                                            foreach($item->image as $image_name=>$image_url){?>

                                                <div class="carousel-item <?= $active ?>" data-bs-interval="10000">
                                                    <img class="rounded" src="<?= $image_url ?>" alt="<?= $image_name ?>">
                                                </div>

                                            <?php $active = '';
                                            }
                                        }
                                    ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselslide<?= $num ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselslide<?= $num ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>

                <?php $position = "left"; 
                }
            }
        }
    }

    public static function displayFaq($data=null){
       // if(!empty($data)){
            //foreach($data as $item){ ?>
                <div class="row py-5 my-5">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="my-auto mx-auto w-75">
                             <img class="img-fluid" src="\UTM\images\dashboard\faq.png" alt="">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 p-5"  style="background-color: #121417; " >
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Accordion Item #1
                                </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Accordion Item #2
                                </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php 
            //}
        //}
    }

    public static function showLogoScroll()
    { //https://codepen.io/smashingmag/pen/YzMQMXe ?>
    <link rel="stylesheet" href="assets/app/logo-scroll/logo_scroll.css">
        <div class="marquee marquee--8">
        <img class="marquee__item" src="https://cdn.freebiesupply.com/logos/large/2x/laravel-1-logo-png-transparent.png" width="100" height="100" alt="">
        <img class="marquee__item" src="https://pngimg.com/uploads/php/php_PNG33.png" width="100" height="100" alt="">
        <img class="marquee__item" src="https://cdn-icons-png.flaticon.com/256/3128/3128323.png" width="100" height="100" alt="">
        <img class="marquee__item" src="https://cdn.freebiesupply.com/logos/large/2x/css3-logo-png-transparent.png" width="100" height="100" alt="">
        <img class="marquee__item" src="https://upload.wikimedia.org/wikipedia/commons/b/b2/Bootstrap_logo.svg" width="100" height="100" alt="">
        <img class="marquee__item" src="https://docs.joomla.org/images/5/53/Vertical-logo-light-background-en.png" width="100" height="100" alt="">
        <img class="marquee__item" src="https://static.vecteezy.com/system/resources/previews/027/127/463/original/javascript-logo-javascript-icon-transparent-free-png.png" width="100" height="100" alt="">
        <img class="marquee__item" src="https://cdn.iconscout.com/icon/free/png-256/free-java-60-1174953.png?f=webp&w=256" width="100" height="100" alt="">
        </div>
        <?php 
    } 

    public static function displayEducation(){?>

        <style>
            .gallery img {
                object-fit: cover; /* Ensure the image covers the gallery area */
                margin-bottom: 15px;
                border-radius: 5px; /* Optional: Add slight rounding to images */
                transition: transform 0.3s ease; /* Smooth scaling effect */
            }
            .gallery img:hover {
                transform: scale(1.05); /* Slight zoom on hover */
                cursor: pointer; /* Change cursor to pointer on hover */
            }
            .gallery .col-8 img {
                min-height: 315px; /* Height for the large image */
            }
            .gallery .col-4 img {
                min-height: 150px; /* Height for the smaller images */
            }
        </style>
        <div class="row">
            <!-- Education Information -->
            <div class="col-md-6 mb-4">
                <div class="card text-white"  style="background-color: #121417; " >
                    <div class="card-header">
                        <h4>Education</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="media mb-3">
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1"><b>Bachelor of Computer Science (HONS)</b></h5>
                                    <p><strong>University Name:</strong> University Selangor (UNISEL)</p>
                                    <p><strong>Year:</strong> 2021 - 2023</p>
                                    <p><strong>Relevant Coursework:</strong> Computer Design, Automata Theory & Computation, Software Development, Analysis & Design Algorithm.</p>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1"><b>Diploma in Computer Science</b></h5>
                                    <p><strong>University Name:</strong> University Selangor (UNISEL)</p>
                                    <p><strong>Year:</strong> 2017 - 2020</p>
                                    <p><strong>Relevant Coursework:</strong> Programming Methodology, Database System, Visual Programming, Computer-Aided Design, Object Oriented Programming, Fundamental of Computer Network, Web Development.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Image Gallery -->
            <div class="col-md-6">
                <div class="row gallery">
                    <div class="col-8">
                        <img src="http://localhost/UTM/images/dashboard/education/unisel_gerbang.jpg" class="img-fluid" alt="Large University Image">
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <div class="col-12">
                                <img src="http://localhost/UTM/images/dashboard/education/mob_prog.jpg" class="img-fluid" alt="Small University Image 1">
                            </div>
                            <div class="col-12">
                                <img src="http://localhost/UTM/images/dashboard/education/fyp_unisel.jpg" class="img-fluid" alt="Small University Image 2">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <img src="http://localhost/UTM/images/dashboard/education/hostel.jpg" class="img-fluid" alt="Small University Image 3">
                            </div>
                            <div class="col-6">
                                <img src="http://localhost/UTM/images/dashboard/education/mosque.png" class="img-fluid" alt="Small University Image 4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php

    }
}