<?php
include 'config.php';
require 'vendor/autoload.php';
include(__DIR__.'/../../controller/validate_token.php');
include(__DIR__.'/../../model/dashboardModel.php');
use UTM\Helper\FieldHelper;
$title = 'Edit Timeline';
$id = $_GET['p']??0;
$dashboard = $_GET['id']??'';

$data = '';
if(!empty($id)){
    $data = getTimeline($id, $dashboard);
    $data = $data[0]??'';
}
$imglist = FieldHelper::getListImage('images/dashboard/timeline');
//FieldHelper::dbg($data);
ob_start();

if(!empty($user)&&$user->role != '1'){
$_SESSION['error'] = "Warning: Request denied!";
header("Location: ".BASE_URL."home");
exit();
}
?>
<div class="card bg-light border-light mb-3 pb-5">
    <form action="dashboardController" method="POST" enctype="multipart/form-data">
        <div class="card-header text-right p-3" style="display: flex; justify-content: space-between;">
            <div>
                <h4 class="card-title">Edit Timeline</h4>
            </div>
            <div>
                <?php 
                    if(!empty($_GET['id'])){?>

                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $user->id??'' ?>">
                        <input type="hidden" id="dashboard" name="dashboard" value="<?php echo $dashboard; ?>">
                        <input type="hidden" id="id" name="id" value="<?php echo $_GET['p']??'' ?>">
                        <input type="hidden" id="target" name="target" value="timeline">
                        <input type="hidden" id="task" name="task" value="<?= $id ? 'update' : 'create' ?>">
                        <input type="submit" class="btn btn-primary" name="apply" value="Apply">

                    <?php    
                }
                ?>
                <a href="dashboard-config" class="btn btn-danger">X</a>
            </div>
        </div>

        <?php include(__DIR__.'/../../component/pop_up_message.php'); ?>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="mt-4" for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $data->name??'' ?>" require>
                            <label class="mt-4" for="ordering">Order</label>
                            <input type="number" class="form-control" id="ordering" name="ordering" value="<?= $data->ordering??''?>" min="0" require>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-12">
                            <?= FieldHelper::getHTMLPortfolioField($title='Description',$var_name='description',$data); ?>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <Label class="mt-4" for="addImage">Add Image</Label>
                            <input type="file" class="form-control" id="addImage" name="addImage" accept="image/*" />
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <fieldset>
                                <label class="mt-4" for="name">Select Image</label>
                                <div class="row">
                                    <?php 
                                        if(!empty($imglist)){
                                            foreach($imglist as $key=>$value){?>
                                                <div class="form-check col-lg-6">
                                                    <input class="form-check-input" type="checkbox" value="<?= $value ?>" name="image[]" id="<?= $key ?>" <?php if(!empty($data->image)){echo in_array($value, $data->image)?'checked':'';} ?>>
                                                    <label class="form-check-label" for="<?= $key ?>">
                                                    <?= $key ?>
                                                    </label>
                                                </div>
                                    <?php   }
                                        }
                                    ?>
                                </div>
                                
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 border border-dark-subtle rounded">
                    <div class="row my-4">
                        <div class="col-12">
                            <label class="mt-4" for="created">Created</label>
                            <input type="text" class="form-control" id="created" name="created" value="<?php echo $data->created??"";?>" disabled>
                        </div>
                        <div class="col-12">
                            <label class="mt-4" for="created">Modified</label>
                            <input type="text" class="form-control" id="modified" name="modified" value="<?php echo $data->modified??"";?>" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
$content = ob_get_clean();
include(__DIR__.'/../../template/default.php');
?>