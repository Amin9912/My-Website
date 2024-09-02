<?php
function items($id = null){

    include('dbConn.php');
    $data = new stdClass();

    if(!empty($id)){
        
        $stmt = $conn->prepare("SELECT * FROM `dashboard` WHERE id = ?");
        $stmt->bind_param("i", $id); 

        if ($stmt->execute()) {
            $item = $stmt->get_result();
            $data = $item->fetch_object();
            if(empty($_SESSION['success'])&&!empty($data)){$_SESSION['success'] = "Record retrieve successfully.";}
        } else {
            $_SESSION['error'] = "Error retrieve record: " . $stmt->error;
        }

        $stmt->close();

        if(!empty($data->header)){ $data->header = json_decode($data->header); }
        $data->portfolio = getPortfolio(null,$data->id)??'';
        $data->timeline = getTimeline(null,$data->id)??'';
    }
    $conn->close();

    return $data;
}

function getPortfolio($id = null, $dashboard = null){

    include('dbConn.php');
    $data = [];

    if(!empty($dashboard)){
        
        if(!empty($id)){
            $stmt = $conn->prepare("SELECT * FROM `dashboard_portfolio` WHERE dashboard = ? AND id = ?  ORDER BY ordering ASC");
             $stmt->bind_param("ii", $dashboard, $id); 
        }else{
            $stmt = $conn->prepare("SELECT * FROM `dashboard_portfolio` WHERE dashboard = ?  ORDER BY ordering ASC");
            $stmt->bind_param("i", $dashboard); 
        }

        if ($stmt->execute()) {
            $item = $stmt->get_result();
            while($getItem = $item->fetch_object()){

                if(!empty($getItem->description)){ $getItem->description = json_decode($getItem->description); }
                if(!empty($getItem->image)){ $getItem->image = json_decode($getItem->image); }
                $data[] = $getItem;
            }
            if(empty($_SESSION['success'])&&!empty($data)){$_SESSION['success'] = "Record retrieve successfully.";}
        } else {
            $_SESSION['error'] = "Error retrieve record: " . $stmt->error;
        }

        $stmt->close();
        
    }
    $conn->close();

    return $data;
}

function getTimeline($id = null, $dashboard = null){

    include('dbConn.php');
    $data = [];

    if(!empty($dashboard)){
        
        if(!empty($id)){
            $stmt = $conn->prepare("SELECT * FROM `dashboard_timeline` WHERE dashboard = ? AND id = ? ORDER BY ordering ASC");
             $stmt->bind_param("ii", $dashboard, $id); 
        }else{
            $stmt = $conn->prepare("SELECT * FROM `dashboard_timeline` WHERE dashboard = ? ORDER BY ordering ASC");
            $stmt->bind_param("i", $dashboard); 
        }

        if ($stmt->execute()) {
            $item = $stmt->get_result();
            while($getItem = $item->fetch_object()){

                if(!empty($getItem->description)){ $getItem->description = json_decode($getItem->description); }
                if(!empty($getItem->image)){ $getItem->image = json_decode($getItem->image); }
                $data[] = $getItem;
            }
            if(empty($_SESSION['success'])&&!empty($data)){$_SESSION['success'] = "Record retrieve successfully.";}
        } else {
            $_SESSION['error'] = "Error retrieve record: " . $stmt->error;
        }

        $stmt->close();
        
    }
    $conn->close();

    return $data;
}