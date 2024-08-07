<?php include 'config.php'; ?>
<?php
$title = 'View Record';
ob_start();
?>
<?php
include(__DIR__.'/../controller/validate_token.php');

if(!empty($user)&&$user->role != '1'){
$_SESSION['error'] = "Warning: Request denied!";
header("Location: ".BASE_URL."home");
exit();
}

include(__DIR__.'/../model/view_recordModel.php');
$data = items();
?>
<div class="edit-form mb-5 mt-1">
    <div class="text-right">
        <a href="utm-travel-record" class="btn btn-danger">X</a>
    </div>
    <h2 class="text-center mb-4">View Record</h2>

    <?php include(__DIR__.'/../component/pop_up_message.php'); ?>

    <label>Username: <?php echo $data->username; ?></label><br>
    <label>Created: <?php echo $data->created; ?></label>
    <form action="action?task=update" method="POST">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">From</th>
                        <th scope="col">To</th>
                        <th scope="col">Purpose</th>
                        <th scope="col">Mileage</th>
                        <th scope="col">Parking</th>
                        <th scope="col">Toll</th>
                        <th scope="col">Flights</th>
                        <th scope="col">Taxi Fare</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id='travel-data'>
                    <?php
                    if(!empty($data->date)){
                        for ($i=0;$i<count($data->date);$i++) {
                            echo "<tr id='row-".$i."'>";
                            echo '<td><input type="date" class="form-control" name="date[]" id="date" value='.$data->date[$i].' required></td>
                            <td><input type="text" class="form-control" name="location_from[]" id="location_from" value='.$data->location_from[$i].' required></td>
                            <td><input type="text" class="form-control" name="location_to[]" id="location_to" value='.$data->location_to[$i].' required></td>
                            <td><input type="text" class="form-control" name="purpose[]" id="purpose" value='.$data->purpose[$i].' required></td>
                            <td><input type="number" step="0.01" min="0" max="1000" class="form-control" name="mileage[]" id="mileage" value='.$data->mileage[$i].' required></td>
                            <td><input type="number" step="0.01" min="0" max="1000" class="form-control" name="parking[]" id="parking" value='.$data->parking[$i].' required></td>
                            <td><input type="number" step="0.01" min="0" max="1000" class="form-control" name="toll[]" id="toll" value='.$data->toll[$i].' required></td>
                            <td><input type="number" step="0.01" min="0" max="1000" class="form-control" name="flights[]" id="flights" value='.$data->flights[$i].' required></td>
                            <td><input type="number" step="0.01" min="0" max="1000" class="form-control" name="taxi_fare[]" id="taxi_fare" value='.$data->taxi_fare[$i].' required></td>
                            <td><input type="button" class="btn btn-sm btn-danger removeRowBtn" id="removeRowBtn-'.$i.'" value="Delete" data-rownum="'.$i.'"></td>';
                            echo "</tr>";
                        }
                    }
                    ?>

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-center">TOTAL</td>
                        <td><?=$data->ttl_mileage ?></td>
                        <td><?=$data->ttl_parking ?></td>
                        <td><?=$data->ttl_toll ?></td>
                        <td><?=$data->ttl_flights ?></td>
                        <td><?=$data->ttl_taxi_fare ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <input type="hidden" id="id" name="id" value="<?php echo $data->id ?>">
        <button type="button" class="btn btn-secondary btn-sm" id="adminAddRowBtn">Add Row</button>
        <input type="submit" class="btn btn-primary btn-sm" name="Update" value="Update">
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
</div>
<?php
$content = ob_get_clean();
include(__DIR__.'/../template/default.php');
?>