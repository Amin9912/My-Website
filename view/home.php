<?php
$title = 'Home Page';
ob_start();
?>
<?php 
include 'config.php';
require 'vendor/autoload.php';
include(__DIR__ . '/../model/indexModel.php');
include(__DIR__ .'/../component/graph.php');
include(__DIR__.'/../controller/validate_token.php');
$data = items();
$col_names = $data->col_names;

if(!empty($user)&&$user->role == '2'){ ?>
<?php include(__DIR__ .'/../component/pop_up_message.php'); ?>
<div class="row"><div class="col"></div></div>
<?php }

if(!empty($user)&&$user->role == '1'){?>
<?php include(__DIR__ .'/../component/pop_up_message.php'); 
?>
    <div class="row"><div class="col-12"><?php include(__DIR__ .'/../component/glass.php'); ?></div></div>
    <div class="row my-5">
        <div class="col-lg-6 col-md-12">
            <?php //generateGraph2($data_name = "Line Graph",$id = "line_graph",$stack = "false",$label_list = ['label_1'=>'Label 1','label_2'=>'Label 2'],$frequency_list = ['frequency_1'=>[50,40,60],'frequency_2'=>[90,20,70]],$key = [10,20,30],$chart_type = "scatter",$display_horizontal = 'false',$max_height = 100); ?>
        </div>
        <div class="col-lg-6 col-md-12">
            <?php //generateGraph2($data_name = "Bar Graph",$id = "bar_graph",$stack = "false",$label_list = ['label_1'=>'Label 1','label_2'=>'Label 2'],$frequency_list = ['frequency_1'=>[50,40,60],'frequency_2'=>[90,20,70]],$key = [10,20,30],$chart_type = "bar",$display_horizontal = 'false',$max_height = 100); ?>
        </div>
    </div>
<?php } ?>

<?php
$content = ob_get_clean();
include(__DIR__.'/../template/landing.php');
?>