<?php
function items(){

    include('dbConn.php');
    $data = new stdClass();

    if(!empty($_GET['id'])){
        
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT td.*,user.username FROM travelling_details as td LEFT JOIN users as user ON user.id = td.users WHERE td.id = ?");
        $stmt->bind_param("i", $id); 

        if ($stmt->execute()) {
            $item = $stmt->get_result();
            $data = $item->fetch_object();
            if(empty($_SESSION['success'])){$_SESSION['success'] = "Record retrieve successfully.";}
        } else {
            $_SESSION['error'] = "Error retrieve record: " . $stmt->error;
        }

        $stmt->close();

        if(!empty($data)){

            function getTotal($data=null){
                $total = 0;
                if(!empty($data)){
                    foreach( $data as $value){
                        $total += $value;
                    }
                }
                return $total;
            }
        
            if(!empty($data)){

                $data->date = json_decode($data->date);
                $data->location_from = json_decode($data->location_from);
                $data->location_to = json_decode($data->location_to);
                $data->purpose = json_decode($data->purpose);

                $data->mileage = json_decode($data->mileage);
                $data->parking = json_decode($data->parking);
                $data->toll = json_decode($data->toll);
                $data->flights = json_decode($data->flights);
                $data->taxi_fare = json_decode($data->taxi_fare);
    
                $data->ttl_mileage = getTotal($data->mileage);
                $data->ttl_parking = getTotal($data->parking);
                $data->ttl_toll = getTotal($data->toll);
                $data->ttl_flights = getTotal($data->flights);
                $data->ttl_taxi_fare = getTotal($data->taxi_fare);
                $ttl_milage = 0;
                $mileage_tmp = $data->ttl_mileage;
                do{
                    $ttl_milage += 200*0.65;
                    $mileage_tmp -= 200;
                }while($mileage_tmp>=200);
                $ttl_milage += $mileage_tmp*0.65;
                $data->total = $ttl_milage+$data->ttl_parking+$data->ttl_toll+$data->ttl_flights+$data->ttl_taxi_fare;
            }
        }
    }else{

        $conn->close();
        $_SESSION['error'] = "ID parameter missing.";
        header("Location: ../index.php");
        exit();
    }
    $conn->close();

    return $data;
}
?>
