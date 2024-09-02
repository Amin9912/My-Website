<?php
namespace UTM\Helper;

class FieldHelper{

    public static function dbg($data,$dieVal=true){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if($dieVal){ die(); }
    }

    public static function getHTMLField($title=null,$var_name=null,$data=null, $showAddbutton=true){?>
        <div class="col-lg-12 p-4">
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
                <?php       $total++;}
                        }else{ ?>
                            <div class=" col-lg-6">
                                <Label for="<?php echo $var_name; ?>"><?=$title?></Label>
                                <textarea name="<?php echo $var_name; ?>[0]"
                                    id="tiny"><?php echo $data->$var_name??''; ?></textarea>
                            </div>
                <?php   } ?>
                </div>
            </div>
            <?php 
            if($showAddbutton == true){ ?>
                <button class="btn btn-danger mt-3" type="button" id="removeHTMLBtn" target="#parent-<?php echo $var_name; ?>"
                remove-target="<?php echo $var_name; ?>">Remove</button>
                <button class="btn btn-success mt-3" type="button" id="addHTMLBtn" target="<?php echo '#parent-'.$var_name; ?>"
                    data-name="<?php echo $var_name; ?>" data-title="<?=$title?>">Add</button>
                <hr class="mt-5">
            <?php } ?>
        </div>
        <?php 
    }

    public static function getHTMLPortfolioField($title=null,$var_name=null,$data=null){?>
            <div class="<?php echo $var_name; ?>-row">
                <div class="row" id="parent-<?php echo $var_name; ?>">
                    <?php 
                        if(!empty($data->$var_name)){
                            $total = 0;
                            foreach($data->$var_name as $item){ ?>

                                <div id="<?php echo $var_name; ?><?= $total ?>">
                                    <Label for="<?php echo $var_name; ?>"><?=$title?></Label>
                                    <textarea name="<?php echo $var_name; ?>[<?= $total ?>]"
                                        id="tiny"><?php echo $item??''; ?></textarea>
                                </div>
                <?php       $total++;}
                        }else{ ?>
                            <div>
                                <Label for="<?php echo $var_name; ?>"><?=$title?></Label>
                                <textarea name="<?php echo $var_name; ?>[0]"
                                    id="tiny"><?php echo $data->$var_name??''; ?></textarea>
                            </div>
                <?php   } ?>
                </div>
            </div>
        <?php 
    }

    public static function getListImage($dir=null){

        $data = [];
        // $base_url = '/UTM/images/resume'; 
        // $directory = __DIR__ . '/../images/resume';
        $base_url = '/UTM/'.$dir; 
        $directory = __DIR__ . '/../'.$dir;
        $files = scandir($directory);
        $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];

        foreach ($files as $file) {

            $file_extension = pathinfo($file, PATHINFO_EXTENSION);

            if (in_array(strtolower($file_extension), $image_extensions)) {

                //$image_url = $base_url . '/' . $file;

                $data[$file] = $base_url . '/' . $file;

                //echo '<img src="' . $image_url . '" alt="' . $file . '" style="max-width: 200px; margin: 10px;" />';
            }
        }

        return $data;
    }
} 