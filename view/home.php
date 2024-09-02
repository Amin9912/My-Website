<?php
//test
$title = 'Home Page';
ob_start();
?>
<?php 
include 'config.php';
require 'vendor/autoload.php';
include(__DIR__ . '/../model/dashboardModel.php');
include(__DIR__ .'/../component/graph.php');
include(__DIR__.'/../controller/validate_token.php');
use UTM\Helper\HomeHelper;
use UTM\Helper\FieldHelper;
$data = items(1);

if(isset($_SESSION['success'])){unset($_SESSION['success']);}
//if(!empty($user)&&$user->role == '1'){?>

    <div class="row"><div class="col-12"><?php include(__DIR__ .'/../component/glass.php'); ?></div></div>
    <div class="row">
        <div class="col-12 animate__animated xfadeIn animate__fadeIn" style="height: 200px;"><?= HomeHelper::showLogoScroll(); ?></div>
    </div>
    <div class="row py-5 my-5">
        <div class="col text-center p-5">
            <h2 class="text-white fw-bold fs-1">Biodata</h2>
            <p class="px-5" style="text-wrap:balance;">An overview of my academic achievements and personal details, reflecting the experiences and milestones that have shaped my educational journey and professional growth.</p>
        </div>
        <div class="col-lg-12"><?php HomeHelper::displayEducation(); ?></div>
    </div>
    <div class="row py-5 my-5">
        <div class="col text-center p-5">
            <h2 class="text-white fw-bold fs-1">Timeline</h2>
            <p class="px-5" style="text-wrap:balance;">A journey through my academic milestones: from starting my Bachelor of Science in Computer Science (Hons) at the University of Selangor to officially graduating on November 21 & 22, 2024. Each step marks the experiences and achievements that have shaped my path in the tech industry.</p>
        </div>
        <div class="col-lg-12 rounded p-5" style="background-color: #121417; " ><?php HomeHelper::displayTimeline($data->timeline); ?></div>
    </div>
    <div class="row py-5 my-5">
        <div class="col text-center p-5">
            <h2 class="text-white fw-bold fs-1">Portfolio</h2>
            <p class="px-5" style="text-wrap:balance;">A showcase of my projects and accomplishments, highlighting the skills and experiences that define my journey in the field of Web Developer</p>
        </div>
        <div class="col-lg-12"><?php HomeHelper::displayPortfolio($data->portfolio); ?></div>
    </div>
    <div class="row py-5 my-5">
        <div class="col fs-1 fw-bold text-center text-white">Contact Me</div>
        <div class="col-lg-12"><?php include(__DIR__ .'/../component/contact.php'); ?></div>
    </div>
    <div class="row py-5 my-5 d-none">
        <div class="col text-center p-5">
            <h2 class="text-white fw-bold fs-1">FAQ</h2>
            <p class="px-5" style="text-wrap:balance;">A journey through my academic milestones: from starting my Bachelor of Science in Computer Science (Hons) at the University of Selangor to officially graduating on November 21 & 22, 2024. Each step marks the experiences and achievements that have shaped my path in the tech industry.</p>
        </div>
        <div class="col-lg-12 rounded p-5"><?php HomeHelper::displayFaq(); ?></div>
    </div>
    <div class="row my-5 py-5 my-5 d-none">
        <div class="col-lg-6 col-md-12 animate__animated xfadeIn animate__fadeIn">
            <?php generateGraph2($data_name = "Line Graph",$id = "line_graph",$stack = "false",$label_list = ['label_1'=>'Label 1','label_2'=>'Label 2'],$frequency_list = ['frequency_1'=>[50,40,60],'frequency_2'=>[90,20,70]],$key = [10,20,30],$chart_type = "scatter",$display_horizontal = 'false',$max_height = 100); ?>
        </div>
        <div class="col-lg-6 col-md-12 animate__animated xfadeIn animate__fadeIn">
            <?php generateGraph2($data_name = "Bar Graph",$id = "bar_graph",$stack = "false",$label_list = ['label_1'=>'Label 1','label_2'=>'Label 2'],$frequency_list = ['frequency_1'=>[50,40,60],'frequency_2'=>[90,20,70]],$key = [10,20,30],$chart_type = "bar",$display_horizontal = 'false',$max_height = 100); ?>
        </div>
    </div>
<?php //} ?>

<?php
$content = ob_get_clean();
include(__DIR__.'/../template/landing.php');
?>