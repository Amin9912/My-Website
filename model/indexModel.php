<?php
function items(){

    include('dbConn.php');
    $tableName = "travelling_details";

    $data = new stdClass();
    $item = array();
    $sql = "SELECT p.*, users.username FROM $tableName as p LEFT JOIN users as users ON users.id = p.users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $item[] = $row;
        }
        $data->items = $item;
    }

    $col_names = array(); 
    $sql = "SHOW COLUMNS FROM $tableName";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $col_names[] = $row['Field'];
        }
        unset($col_names[0]);
        unset($col_names[1]);
        unset($col_names[11]);

        $data->col_names = array_values($col_names);
    }

    function getTotal($data){
        $total = 0;
        if(!empty($data)){
            foreach( $data as $value){
                $total += $value;
            }
        }
        return $total;
    }

    if(!empty($data)){
        foreach ($data->items as $row) {
            $mileage = json_decode($row['mileage']);
            $parking = json_decode($row['parking']);
            $toll = json_decode($row['toll']);
            $flights = json_decode($row['flights']);
            $taxi_fare = json_decode($row['taxi_fare']);

            $data->ttl_mileage = getTotal($mileage);
            $data->ttl_parking = getTotal($parking);
            $data->ttl_toll = getTotal($toll);
            $data->ttl_flights = getTotal($flights);
            $data->ttl_taxi_fare = getTotal($taxi_fare);
        }
        $data->total = ($data->ttl_mileage*0.65)+$data->ttl_parking+$data->ttl_toll+$data->ttl_flights+$data->ttl_taxi_fare;
    }

    return $data;
}
?>