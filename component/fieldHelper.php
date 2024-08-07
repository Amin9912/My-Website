<?php
function showTextarea($title=null,$var_name=null,$data=null){?>
<div class="col-lg-12 p-4 edu-col">
    <div class="<?php echo $var_name; ?>-row">
        <div class="row" id="parent-<?php echo $var_name; ?>">
            <?php 
                if(!empty($data->$var_name)){
                    $total = 1;
                    foreach($data->$var_name as $item){ ?>

                        <div class=" col-lg-6" id="<?php echo $var_name; ?><?= $total ?>">
                            <Label for="<?php echo $var_name; ?>"><?=$title?> <?= $total ?></Label>
                            <textarea name="<?php echo $var_name; ?>[<?= $total ?>]"
                                id="tiny"><?php echo $item??''; ?></textarea>
                        </div>
        <?php           $total++;
                    }
                }else{ ?>
                    <div class=" col-lg-6">
                        <Label for="<?php echo $var_name; ?>"><?=$title?></Label>
                        <textarea name="<?php echo $var_name; ?>[0]"
                            id="tiny"><?php echo $data->$var_name??''; ?></textarea>
                    </div>
        <?php   } ?>
        </div>
    </div>
    <button class="btn btn-danger mt-3" type="button" id="removeEduRowBtn" target="#parent-<?php echo $var_name; ?>"
        remove-target="<?php echo $var_name; ?>">Remove</button>
    <button class="btn btn-success mt-3" type="button" id="addRowBtn" target="<?php echo '#parent-'.$var_name; ?>"
        data-name="<?php echo $var_name; ?>" data-title="<?=$title?>">Add</button>
    <hr class="mt-5">
</div>
<?php }