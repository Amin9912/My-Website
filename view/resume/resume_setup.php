<?php
use UTM\Helper\FieldHelper;

include 'config.php';
require 'vendor/autoload.php';
include(__DIR__.'/../../controller/validate_token.php');
include(__DIR__.'/../../model/resumeModel.php');
$title = 'Home Page';
$data = items($user->id);
/*echo '<pre>';
print_r($data);
echo '</pre>';*/
ob_start();
?>
<?php 
if(!empty($user)){?>
<?php include(__DIR__ .'/../../component/pop_up_message.php');?>
<form action="resume-controller" method="POST" enctype="multipart/form-data">
    <div class="card bg-light border-light mb-3">
        <div class="card-header text-right p-3" style="display: flex; justify-content: space-between;">
            <div>
                <h4 class="card-title">Resume Setup</h4>
            </div>
            <div>
                <input type="hidden" id="id" name="id" value="<?php echo $user->id ?>">
                <input type="hidden" id="task" name="task" value="<?= $data?'update':'create' ?>">
                <input type="submit" class="btn btn-primary" name="Apply" value="Apply">
                <?php 
                    if(!empty($data)){echo'<a href="view-resume-tcpdf" class="btn btn-info">Download TCPDF</a>'; }
                ?>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 pt-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <Label for="contact_details">Contact</Label>
                            <textarea class="form-control" name="contact_details" id="tiny"><?php echo $data->contact_details??''; ?></textarea>
                        </div>
                        <div class="col-lg-6">
                            <Label for="linkedIn_qr">LinkedIn Qr</Label>
                            <input type="file" class="form-control" id="linkedIn_qr" name="linkedIn_qr" accept="image/*" />
                            <Label for="image_size">Image Size (dpi)</Label>
                            <input type="number" class="form-control" id="image_size" name="image_size" value="<?= $data->image_size??300 ?>"/>
                            <div class="text-center mt-4">
                                <img src="<?php echo $data->linkedIn_qr??''; ?>" class="image" alt="image_resume" style="object-fit: contain; max-width: 30%;">
                            </div>
                            <label class=" d-block text-center mt-2"><?= $data->linkedIn_qr??'' ?></label>
                        </div>
                    </div>
                    <hr class="mt-5">
                </div>

                <div class="col-lg-6 p-4">
                    <Label for="summary">Summary</Label>
                    <textarea name="summary" id="tiny"><?php echo $data->summary??''; ?></textarea>
                </div>

                <?php
                FieldHelper::getHTMLField($title='Education',$var_name='education',$data);
                FieldHelper::getHTMLField($title='Work Experience',$var_name='work_experience',$data);
                FieldHelper::getHTMLField($title='Curriculum',$var_name='curriculum',$data);
                ?>

                <div class="col-lg-6 p-4">
                    <Label for="skillset">Skillset</Label>
                    <textarea name="skillset" id="tiny"><?php echo $data->skillset??''; ?></textarea>
                </div>
                <div class="col-lg-6 p-4">
                    <Label for="reference">Reference</Label>
                    <textarea name="reference" id="tiny"><?php echo $data->reference??''; ?></textarea>
                </div>
            </div>
        </div>
    </div>
</form>
<?php } ?>

<?php
$content = ob_get_clean();
include(__DIR__.'/../../template/default.php');
?>
<script src="/UTM/assets/app/resume/resume.js"></script>