<?php include 'config.php'; ?>
<?php
$title = 'Travel Record';
ob_start();
?>
<?php 
include(__DIR__ . '/../model/indexModel.php');
include(__DIR__ .'/../component/graph.php');
include(__DIR__.'/../controller/validate_token.php');
$data = items();
$col_names = $data->col_names;

if(!empty($user)&&$user->role == '2'){?>
<?php include(__DIR__ .'/../component/pop_up_message.php'); ?>
<form action="action?task=create" method="POST">
    <div class="table-responsive">
        <table class="table table-hover" id="travelTable">
            <thead class="table-info">
                <tr>
                    <?php 
                        if(!empty($col_names)){
                            foreach($col_names as $colname) { ?>
                    <th scope="col"><?= $colname ?></th>
                    <?php }} ?>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id='travel-data'>
                <tr id="row-0">
                    <td><input type="date" class="form-control" name="date[]" value="<?php echo date('Y-m-d'); ?>"
                            required></td>
                    <td><input type="text" class="form-control" name="location_from[]"
                            value="<?php echo rand(100, 999); ?>" required></td>
                    <td><input type="text" class="form-control" name="location_to[]"
                            value="<?php echo rand(100, 999); ?>" required></td>
                    <td><input type="text" class="form-control" name="purpose[]" value="<?php echo rand(100, 999); ?>"
                            required></td>
                    <td><input type="number" step="0.01" min="0" max="1000" class="form-control" name="mileage[]"
                            value="<?php echo rand(100, 999); ?>" required></td>
                    <td><input type="number" step="0.01" min="0" max="1000" class="form-control" name="parking[]"
                            value="<?php echo rand(100, 999); ?>" required></td>
                    <td><input type="number" step="0.01" min="0" max="1000" class="form-control" name="toll[]"
                            value="<?php echo rand(100, 999); ?>" required></td>
                    <td><input type="number" step="0.01" min="0" max="1000" class="form-control" name="flights[]"
                            value="<?php echo rand(100, 999); ?>" required></td>
                    <td><input type="number" step="0.01" min="0" max="1000" class="form-control" name="taxi_fare[]"
                            value="<?php echo rand(100, 999); ?>" required></td>
                    <td><input type="button" class="btn btn-sm btn-danger removeRowBtn" id="removeRowBtn-0"
                            value="Delete" data-rownum="0"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <input type="hidden" class="form-control" name="id" value="<?php echo $user->id??''; ?>">
    <button type="button" class="btn btn-sm btn-secondary" id="addRowBtn">Add Row</button>
    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
</form>
<?php }

if(!empty($user)&&$user->role == '1'){?>
<?php include(__DIR__ .'/../component/pop_up_message.php'); ?>
<form action="" method="">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-info">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th class='text-center' scope="col">Created</th>
                    <th class="text-center" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 1;
                    foreach ($data->items as $row) {
                        echo "<tr>";
                        echo "<td>".$i."</td>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td class='text-center'>".$row['created']."</td>";
                        echo "<td class='text-center'><a href='action?task=delete&id=" . $row['id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                        <a href='view-record?id=" . $row['id'] . "' class='btn btn-sm btn-success'>View</a></td>";
                        echo "</tr>";
                        $i++;
                    }
                    ?>
            </tbody>
        </table>
    </div>
</form>

<div class="table-responsive mt-5">
    <table class="table table-hover">
        <thead class="table-info">
            <tr>
                <th scope="col" colspan="2"></th>
                <th scope="col">RM/km</th>
                <th scope="col">RM</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>MILEAGE</th>
                <td>1-200KM</td>
                <td>RM0.65</td>
                <td><?= $data->ttl_mileage*0.65 ?></td>
            </tr>
            <tr>
                <th colspan="3">PARKING</th>
                <td><?=$data->ttl_parking ?></td>
            </tr>
            <tr>
                <th colspan="3">TOLLS</th>
                <td><?=$data->ttl_toll ?></td>
            </tr>
            <tr>
                <th colspan="3">FLIGHTS</th>
                <td><?=$data->ttl_flights ?></td>
            </tr>
            <tr>
                <th colspan="3">TAXI FARE/GRAB</th>
                <td><?=$data->ttl_taxi_fare ?></td>
            </tr>
            <tr>
                <th colspan="3" class="text-center">TOTAL</th>
                <td><?=$data->total ?></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="p-5">
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <?php generateGraph2($data_name = "Line Graph",$id = "line_graph",$stack = "false",$label_list = ['label_1'=>'Label 1','label_2'=>'Label 2'],$frequency_list = ['frequency_1'=>[50,40,60],'frequency_2'=>[90,20,70]],$key = [10,20,30],$chart_type = "scatter",$display_horizontal = 'false',$max_height = 100); ?>
        </div>
        <div class="col-lg-6 col-md-12">
            <?php generateGraph2($data_name = "Bar Graph",$id = "bar_graph",$stack = "false",$label_list = ['label_1'=>'Label 1','label_2'=>'Label 2'],$frequency_list = ['frequency_1'=>[50,40,60],'frequency_2'=>[90,20,70]],$key = [10,20,30],$chart_type = "bar",$display_horizontal = 'false',$max_height = 100); ?>
        </div>
    </div>
</div>
<?php } ?>

<?php
$content = ob_get_clean();
include(__DIR__.'/../template/default.php');
?>