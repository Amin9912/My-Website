<?php
session_start();

if(!empty($_SESSION['userID'])){
include('model/indexModel.php');

$data = items();
$col_names = $data->col_names;
?>
<?php 
include('component/header.php'); 
include('component/graph.php');
?>
<title>Index</title>
<body>
    <?php include('component/nav_shared.php'); ?>
    <div class="container mt-4">
    <?php 
   if($_SESSION['role'] == '2'){ ?>
        <?php include('component/pop_up_message.php'); ?>
        <form action="model/travelling_detailsModel.php?task=create" method="POST">
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
                            <td><input type="date" class="form-control" name="date[]" value="<?php echo date('Y-m-d'); ?>" required></td>
                            <td><input type="text" class="form-control" name="location_from[]" value="<?php echo rand(100, 999); ?>" required></td>
                            <td><input type="text" class="form-control" name="location_to[]" value="<?php echo rand(100, 999); ?>" required></td>
                            <td><input type="text" class="form-control" name="purpose[]" value="<?php echo rand(100, 999); ?>" required></td>
                            <td><input type="number" step="0.01" min="0" max="1000" class="form-control" name="mileage[]" value="<?php echo rand(100, 999); ?>" required></td>
                            <td><input type="number" step="0.01" min="0" max="1000" class="form-control" name="parking[]" value="<?php echo rand(100, 999); ?>" required></td>
                            <td><input type="number" step="0.01" min="0" max="1000" class="form-control" name="toll[]" value="<?php echo rand(100, 999); ?>" required></td>
                            <td><input type="number" step="0.01" min="0" max="1000" class="form-control" name="flights[]" value="<?php echo rand(100, 999); ?>" required></td>
                            <td><input type="number" step="0.01" min="0" max="1000" class="form-control" name="taxi_fare[]" value="<?php echo rand(100, 999); ?>" required></td>
                            <td><input type="button" class="btn btn-sm btn-danger removeRowBtn" id="removeRowBtn-0" value="Delete" data-rownum="0"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <input type="hidden" class="form-control" name="users" value="<?php echo $_SESSION['userID']; ?>">
            <button type="button" class="btn btn-sm btn-secondary" id="addRowBtn">Add Row</button>
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
        </form>
    <?php }
    
    if($_SESSION['role'] == '1'){?>
        <?php include('component/pop_up_message.php'); ?>
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
                            echo "<td class='text-center'><a href='model/travelling_detailsModel.php?task=delete&id=" . $row['id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                            <a href='view_record.php?id=" . $row['id'] . "' class='btn btn-sm btn-success'>View</a></td>";
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
				<div class="col-6">
				<?php generateGraph2($data_name = "Line Graph",$id = "line_graph",$stack = "false",$label_list = ['label_1'=>'Label 1','label_2'=>'Label 2'],$frequency_list = ['frequency_1'=>[50,40,60],'frequency_2'=>[90,20,70]],$key = [10,20,30],$chart_type = "line",$display_horizontal = 'false',$max_height = 100); ?>
				</div>
                <div class="col-6">
				<?php generateGraph2($data_name = "Bar Graph",$id = "bar_graph",$stack = "false",$label_list = ['label_1'=>'Label 1','label_2'=>'Label 2'],$frequency_list = ['frequency_1'=>[50,40,60],'frequency_2'=>[90,20,70]],$key = [10,20,30],$chart_type = "bar",$display_horizontal = 'false',$max_height = 100); ?>
				</div>
			</div>
		</div>

    <?php } ?>

        
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="admin/admin.js"></script>
<?php
}else{
    header("Location: login.php");
}
?>