<?php
function items($user_id = null){

    include('dbConn.php');
    $data = new stdClass();

    if(!empty($user_id)){
        
        $stmt = $conn->prepare("SELECT * FROM `resume` WHERE users = ?");
        $stmt->bind_param("i", $user_id); 

        if ($stmt->execute()) {
            $item = $stmt->get_result();
            $data = $item->fetch_object();
            if(empty($_SESSION['success'])&&!empty($data)){$_SESSION['success'] = "Record retrieve successfully.";}
        } else {
            $_SESSION['error'] = "Error retrieve record: " . $stmt->error;
        }

        $stmt->close();

        if(!empty($data->contact_details)){ $data->contact_details = htmlspecialchars_decode($data->contact_details??'', ENT_QUOTES); }
        if(!empty($data->summary)){ $data->summary = htmlspecialchars_decode($data->summary??'', ENT_QUOTES); }
        if(!empty($data->education)){ $data->education = json_decode($data->education); }
        if(!empty($data->work_experience)){ $data->work_experience = json_decode($data->work_experience); }
        if(!empty($data->curriculum)){ $data->curriculum = json_decode($data->curriculum); }
        if(!empty($data->skillset)){ $data->skillset = htmlspecialchars_decode($data->skillset??'', ENT_QUOTES); }
        if(!empty($data->reference)){ $data->reference = htmlspecialchars_decode($data->reference??'', ENT_QUOTES); }
    }
    $conn->close();

    return $data;
}
?>