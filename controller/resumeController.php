<?php
session_start();
include 'config.php';
include('dbConn.php');

$task = $_POST['task'];

if($task == 'create'){

    if(empty($_POST['id'])){
        $conn->close();

        if(empty($_SESSION['error'])){$_SESSION['error'] = "Resume submit Failed.";}
        header("Location: ".BASE_URL."resume-setup");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO `resume` (users, linkedIn_qr, contact_details, summary, education, work_experience, curriculum, skillset, reference) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $users, $linkedIn_qr, $contact_details, $summary, $education, $work_experience, $curriculum, $skillset, $reference);

    $users = $_POST['id']??'0';
    $linkedIn_qr = json_encode($_POST['linkedIn_qr'])??'';
    $contact_details = $_POST['contact_details']??'';
    $summary = $_POST['summary']??'';
    $education = json_encode($_POST['education'])??'';
    $work_experience = json_encode($_POST['work_experience'])??'';
    $curriculum = json_encode($_POST['curriculum'])??'';
    $skillset = $_POST['skillset']??'';
    $reference = $_POST['reference']??'';

    if ($stmt->execute()) {

        $stmt->close();
        $conn->close();

        if(empty($_SESSION['success'])){$_SESSION['success'] = "Record submit successfully.";}
        header("Location: ".BASE_URL."resume-setup");
        exit();
    } else {
        
        $stmt->close();
        $conn->close();

        if(empty($_SESSION['error'])){$_SESSION['error'] = $stmt->error;}
        header("Location: ".BASE_URL."resume-setup");
        exit();
    }

}elseif($task == 'update'){

    $users = $contact_details = $summary = $education = $work_experience = $curriculum = $skillset = $reference = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(!empty($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT) !== false){

            $users           = $_POST['id']??'0';
            $dir_path        = '/images/resume/';
            $store_img       = store_file($_FILES['linkedIn_qr']??null, $dir_path);
            if(empty($store_img->err_msg)){
                $linkedIn_qr = $store_img->dest_path;
            }else{
                $_SESSION['error'] = $store_img->err_msg;
            }
            $contact_details = htmlspecialchars($_POST['contact_details']??'', ENT_QUOTES, 'UTF-8');
            $image_size      = $_POST['image_size']??'';
            $summary         = htmlspecialchars($_POST['summary']??'', ENT_QUOTES, 'UTF-8');
            $education       = json_encode($_POST['education']??'');
            $work_experience = json_encode($_POST['work_experience']??'');
            $curriculum      = json_encode($_POST['curriculum']??'');
            $skillset        = htmlspecialchars($_POST['skillset']??'', ENT_QUOTES, 'UTF-8');
            $reference       = htmlspecialchars($_POST['reference']??'', ENT_QUOTES, 'UTF-8');
            $modified        = date('ymdHis');

            if(empty($linkedIn_qr)){
                $stmt = $conn->prepare('UPDATE `resume` SET contact_details=?, image_size=?, summary=?, education=?, work_experience=?, curriculum=?, skillset=?, reference=?, modified=? WHERE users=?');
                $stmt->bind_param("sisssssssi", $contact_details, $image_size,$summary, $education, $work_experience, $curriculum, $skillset, $reference, $modified, $users);
            }else{
                $stmt = $conn->prepare('UPDATE `resume` SET linkedIn_qr=?, image_size=?,contact_details=?, summary=?, education=?, work_experience=?, curriculum=?, skillset=?, reference=?, modified=? WHERE users=?');
                $stmt->bind_param("sissssssssi", $linkedIn_qr, $image_size, $contact_details, $summary, $education, $work_experience, $curriculum, $skillset, $reference, $modified, $users);
            }

            if ($stmt->execute()) {
                $_SESSION['success'] = "Resume updated successfully.";
            } else {
                $_SESSION['error'] = "Resume updating record: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
            header("Location: ".BASE_URL."resume-setup?id=".$users);
            exit();

        }else {

            $conn->close();
            $_SESSION['error'] = "Error: Invalid ID parameter";
            header("Location: ".BASE_URL."resume-setup?id=".$users);
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
    header("Location: ".BASE_URL."resume-setup");
    exit();
}

function store_file($file=null,$file_dir=null){
    
    $response = new stdClass();
    $response->err_msg = '';
    $response->dest_path = '';
    
    $_FILES['image'] = $file;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
        $response->err_msg = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = $_FILES['image']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            
            $allowedfileExtensions = array('jpg', 'gif', 'png');
            if (in_array($fileExtension, $allowedfileExtensions)) {

                $newFileName = $fileName;
                $uploadFileDir = '.'.$file_dir;
                $dest_path = $uploadFileDir . $newFileName;
                if (file_exists($dest_path)) {
                    $response->err_msg = 'Failed upload file: file already exists.';
                    return $response;
                }
                
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $response->dest_path = $dest_path;
                    return $response;
                } else {
                    $response->err_msg = 'There was an error moving the file.';
                }
            } else {
                $response->err_msg = 'Upload failed. Allowed file types: ' . implode(', ', $allowedfileExtensions);
            }
        } else {
            //$response->err_msg = "No file uploaded or file upload error.";
        }
        
       return $response;
    }

}
