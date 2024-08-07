<?php
session_start();
include 'config.php';
include('dbConn.php');

$task = $_GET['task'];

if($task == 'create'){

    if(empty($_POST['date'])&&empty($_POST['location_from'])&&empty($_POST['location_to'])&&empty($_POST['purpose'])&&empty($_POST['mileage'])&&empty($_POST['parking'])&&empty($_POST['toll'])&&empty($_POST['flights'])&&empty($_POST['taxi_fare'])){
        $conn->close();

        if(empty($_SESSION['error'])){$_SESSION['error'] = "Record submit Failed.";}
        header("Location: ".BASE_URL."utm-travel-record");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO travelling_details (users, date, location_from, location_to, purpose, mileage, parking, toll, flights, taxi_fare, created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $users, $date, $location_from, $location_to, $purpose, $mileage, $parking, $toll, $flights, $taxi_fare, $created);

    $users = $_POST['id '];
    $date = json_encode($_POST['date']);
    $location_from = json_encode($_POST['location_from']);
    $location_to = json_encode($_POST['location_to']);
    $purpose = json_encode($_POST['purpose']);
    $mileage = json_encode($_POST['mileage']);
    $parking = json_encode($_POST['parking']);
    $toll = json_encode($_POST['toll']);
    $flights = json_encode($_POST['flights']);
    $taxi_fare = json_encode($_POST['taxi_fare']);
    $created = date('ymdHis');

    if ($stmt->execute()) {

        $stmt->close();
        $conn->close();

        if(empty($_SESSION['success'])){$_SESSION['success'] = "Record submit successfully.";}
        header("Location: ".BASE_URL."utm-travel-record");
        exit();
    } else {
        
        $stmt->close();
        $conn->close();

        if(empty($_SESSION['error'])){$_SESSION['error'] = $stmt->error;}
        header("Location: ".BASE_URL."utm-travel-record");
        exit();
    }

}elseif($task == 'update'){

    $id = $date = $location_from = $location_to = $purpose = $mileage = $parking = $toll = $flights = $taxi_fare = "";
    $id_err = $date_err = $location_from_err = $location_to_err = $purpose_err = $mileage_err = $parking_err = $toll_err = $flights_err = $taxi_fare_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(!empty($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT) !== false){

            $id = $_POST['id'];
            $date = json_encode($_POST['date']);
            $location_from = json_encode($_POST['location_from']);
            $location_to = json_encode($_POST['location_to']);
            $purpose = json_encode($_POST['purpose']);
            $mileage = json_encode($_POST['mileage']);
            $parking = json_encode($_POST['parking']);
            $toll = json_encode($_POST['toll']);
            $flights = json_encode($_POST['flights']);
            $taxi_fare = json_encode($_POST['taxi_fare']);

            $stmt = $conn->prepare("UPDATE travelling_details SET date=?, location_from=?, location_to=?, purpose=?, mileage=?, parking=?, toll=?, flights=?, taxi_fare=? WHERE id=?");
            $stmt->bind_param("sssssssssi", $date, $location_from, $location_to, $purpose, $mileage, $parking, $toll, $flights, $taxi_fare, $id);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Record updated successfully.";
            } else {
                $_SESSION['error'] = "Error updating record: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
            header("Location: ".BASE_URL."view-record?id=".$id);
            exit();

        }else {

            $conn->close();
            $_SESSION['error'] = "Error: Invalid ID parameter";
            header("Location: ".BASE_URL."view-record?id=".$id);
            //header("Location: ../view_record.php?id=".$id);
            exit();
        }
        
    } else {
        if (isset($_GET['id']) && !empty(trim($_GET['id']))) {

            $id = trim($_GET['id']);
            $sql = "SELECT * FROM travelling_details WHERE id = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();
                        $date = $row['date'];
                        $location_from = $row['location_from'];
                        $location_to = $row['location_to'];
                        $purpose = $row['purpose'];
                        $mileage = $row['mileage'];
                        $parking = $row['parking'];
                        $toll = $row['toll'];
                        $flights = $row['flights'];
                        $taxi_fare = $row['taxi_fare'];
                    } else {
                        $_SESSION['error'] = "No record found with ID = $id.";
                    }
                } else {
                    $_SESSION['error'] = "Error retrieving record: " . $stmt->error;
                }

                $stmt->close();
                $conn->close();
                header("Location: ".BASE_URL."home");
                exit();
            } else {

                $stmt->close();
                $conn->close();
                
                $_SESSION['error'] = "Database error: unable to prepare statement.";
                header("Location: ".BASE_URL."home");
                exit();
            }
        } else {

            $conn->close();      
            $_SESSION['error'] = "Error: Invalid ID parameter";
            header("Location: ".BASE_URL."home");
            exit();
        }
    }
}elseif($task == 'delete'){
    if (!isset($_GET['id'])) {

        $conn->close();
        $_SESSION['error'] = "Error: ID parameter missing.";
        header("Location: ".BASE_URL."home");
        exit();
    }
    
    $stmt = $conn->prepare("DELETE FROM travelling_details WHERE id = ?");
    $stmt->bind_param("i", $id); 
    
    $id = $_GET['id'];
    if ($stmt->execute()) {
        $_SESSION['success'] = "Success: Record deleted successfully.";
    } else {
        $_SESSION['error'] = "Error: Failed deleting record " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    
    header("Location: ".BASE_URL."utm-travel-record");
    exit();
}else{
    $conn->close();
    $_SESSION['error'] = "Error: Invalid request ";
    header("Location: ".BASE_URL."utm-travel-record");
    exit();
}
?>