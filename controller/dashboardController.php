<?php
session_start();
include 'config.php';
include('dbConn.php');

if(isset($_GET['task']) && isset($_GET['target'])){
    $task = $_GET['task'];
    $target = $_GET['target'];
}else{
    $task = $_POST['task'];
    $target = $_POST['target'];
}


if($target == 'dashboard'){
    if($task == 'create'){

        if(empty($_POST['user_id'])){
            $conn->close();

            if(empty($_SESSION['error'])){$_SESSION['error'] = "Data submit Failed.";}
            header("Location: ".BASE_URL."dashboard-config");
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO `dashboard` (name, header, created) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $header, $created);

        $name = $_POST['name']??'0';
        $header = json_encode($_POST['header']??'');
        $created        = date('ymdHis');

        if ($stmt->execute()) {

            $stmt->close();
            $conn->close();

            if(empty($_SESSION['success'])){$_SESSION['success'] = "Data submit successfully.";}
            header("Location: ".BASE_URL."dashboard-config");
            exit();
        } else {
            
            $stmt->close();
            $conn->close();

            if(empty($_SESSION['error'])){$_SESSION['error'] = $stmt->error;}
            header("Location: ".BASE_URL."dashboard-config");
            exit();
        }

    }elseif($task == 'update'){  

        if(empty($_POST['user_id'])){
            $conn->close();

            if(empty($_SESSION['error'])){$_SESSION['error'] = "Data submit Failed.";}
            header("Location: ".BASE_URL."dashboard-config");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(!empty($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT) !== false){

                $dir_path        = '/images/dashboard/';
                $store_img       = store_file($_FILES['image']??null, $dir_path);
                if(empty($store_img->err_msg)){
                    $image = $store_img->dest_path;
                }else{
                    $_SESSION['error'] = $store_img->err_msg;
                }
                $id = $_POST['id']??'0';
                $name = $_POST['name']??'0';
                $header = json_encode($_POST['header']??'');
            
                /*$curriculum      = json_encode($_POST['curriculum']??'');
                $skillset        = htmlspecialchars($_POST['skillset']??'', ENT_QUOTES, 'UTF-8');*/
                $modified        = date('ymdHis');

                if(empty($image)){
                    $stmt = $conn->prepare('UPDATE `dashboard` SET name=?, header=?, modified=? WHERE id=?');
                    $stmt->bind_param("sssi", $name, $header, $modified, $id);
                }else{
                    //$stmt = $conn->prepare('UPDATE `resume` SET linkedIn_qr=?, image_size=?,contact_details=?, summary=?, education=?, work_experience=?, curriculum=?, skillset=?, reference=?, modified=? WHERE users=?');
                    //$stmt->bind_param("sissssssssi", $linkedIn_qr, $image_size, $contact_details, $summary, $education, $work_experience, $curriculum, $skillset, $reference, $modified, $users);
                }

                if ($stmt->execute()) {
                    $_SESSION['success'] = "Dashboard updated successfully.";
                } else {
                    $_SESSION['error'] = "Dashboard updating record: " . $stmt->error;
                }

                $stmt->close();
                $conn->close();
                header("Location: ".BASE_URL."dashboard-config");
                exit();

            }else {

                $conn->close();
                $_SESSION['error'] = "Error: Invalid ID parameter";
                header("Location: ".BASE_URL."dashboard-config");
                exit();
            }
        }
    }/*elseif($task == 'delete'){
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
    }*/else{
        $conn->close();
        $_SESSION['error'] = "Error: Invalid request ";
        header("Location: ".BASE_URL."dashboard-config");
        exit();
    }
}
elseif($target == 'portfolio')
{
    if($task == 'create'){

        if(empty($_POST['user_id'])){
            $conn->close();

            if(empty($_SESSION['error'])){$_SESSION['error'] = "Data submit Failed.";}
            header("Location: ".BASE_URL."dashboard-config");
            exit();
        }   

        $dir_path        = '/images/dashboard/portfolio/';

        if(!empty($_FILES['addImage'])){
            $store_img       = store_file($_FILES['addImage']??null, $dir_path);
            if(empty($store_img->err_msg)){
                $addImage = $store_img->dest_path;
            }else{
                $_SESSION['error'] = $store_img->err_msg;
            }
        }

        $stmt = $conn->prepare("INSERT INTO `dashboard_portfolio` (name, dashboard, description, image, ordering, created) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssis", $name, $dashboard, $description, $image, $ordering, $created);

        $name           = $_POST['name']??'';
        $dashboard      = $_POST['dashboard']??'0';
        $description    = json_encode($_POST['description']??'');
        $image          = json_encode($_POST['image']??'');
        $created        = date('ymdHis');
        $ordering       = $_POST['ordering']?? 0;

        if ($stmt->execute()) {

            $stmt->close();
            $conn->close();

            if(empty($_SESSION['success'])){$_SESSION['success'] = "Data submit successfully.";}
            header("Location: ".BASE_URL."dashboard-config");
            exit();
        } else {
            
            $stmt->close();
            $conn->close();

            if(empty($_SESSION['error'])){$_SESSION['error'] = $stmt->error;}
            header("Location: ".BASE_URL."dashboard-config");
            exit();
        }

    }
    elseif($task == 'update'){  

        if(empty($_POST['user_id'])){
            $conn->close();

            if(empty($_SESSION['error'])){$_SESSION['error'] = "Data submit Failed.";}
            header("Location: ".BASE_URL."dashboard-config");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(!empty($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT) !== false){

                $dir_path        = '/images/dashboard/portfolio/';

                if(!empty($_FILES['addImage'])){
                    $store_img       = store_file($_FILES['addImage']??null, $dir_path);
                    if(empty($store_img->err_msg)){
                        $addImage = $store_img->dest_path;
                    }else{
                        $_SESSION['error'] = $store_img->err_msg;
                    }
                }
                $id           = $_POST['id']??'';
                $name           = $_POST['name']??'';
                $dashboard      = $_POST['dashboard']??'0';
                $description    = json_encode($_POST['description']??'');
                $image          = json_encode($_POST['image']??'');
                $modified        = date('ymdHis');
                $ordering       = $_POST['ordering']?? 0;


                $stmt = $conn->prepare('UPDATE `dashboard_portfolio` SET name=?, dashboard=?, description=?, image=?, modified=?, ordering=? WHERE id=?');
                $stmt->bind_param("sssssii", $name, $dashboard, $description, $image, $modified, $ordering, $id);

                if ($stmt->execute()) {
                    $_SESSION['success'] = "Portfolio updated successfully.";
                } else {
                    $_SESSION['error'] = "Portfolio updating record: " . $stmt->error;
                }

                $stmt->close();
                $conn->close();
                header("Location: ".BASE_URL."dashboard-portfolio?id=".$dashboard."&p=".$id."");
                exit();

            }else {

                $conn->close();
                $_SESSION['error'] = "Update Failed: Invalid ID parameter";
                header("Location: ".BASE_URL."dashboard-portfolio?id=".$dashboard."&p=".$id."");
                exit();
            }
        }
    }
    elseif($task == 'delete'){
        if (!isset($_GET['id'])) {

            $conn->close();
            $_SESSION['error'] = "Error: ID parameter missing.";
            header("Location: ".BASE_URL."dashboard-config");
            exit();
        }
        
        $stmt = $conn->prepare("DELETE FROM `dashboard_portfolio` WHERE id = ?");
        $stmt->bind_param("i", $id); 
        
        $id = $_GET['id'];
        if ($stmt->execute()) {
            $_SESSION['success'] = "Success: Record deleted successfully.";
        } else {
            $_SESSION['error'] = "Error: Failed deleting record " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();
        
        header("Location: ".BASE_URL."dashboard-config");
        exit();
    }
}
elseif($target == 'timeline')
{
    if($task == 'create'){

        if(empty($_POST['user_id'])){
            $conn->close();

            if(empty($_SESSION['error'])){$_SESSION['error'] = "Data submit Failed.";}
            header("Location: ".BASE_URL."dashboard-config");
            exit();
        }   

        $dir_path        = '/images/dashboard/timeline/';

        if(!empty($_FILES['addImage'])){
            $store_img       = store_file($_FILES['addImage']??null, $dir_path);
            if(empty($store_img->err_msg)){
                $addImage = $store_img->dest_path;
            }else{
                $_SESSION['error'] = $store_img->err_msg;
            }
        }

        $stmt = $conn->prepare("INSERT INTO `dashboard_timeline` (name, dashboard, description, image, created, ordering) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $name, $dashboard, $description, $image, $created, $ordering);

        $name           = $_POST['name']??'';
        $dashboard      = $_POST['dashboard']??'0';
        $description    = json_encode($_POST['description']??'');
        $image          = json_encode($_POST['image']??'');
        $created        = date('ymdHis');
        $ordering       = $_POST['ordering']?? 0;

        if ($stmt->execute()) {

            $stmt->close();
            $conn->close();

            if(empty($_SESSION['success'])){$_SESSION['success'] = "Data submit successfully.";}
            header("Location: ".BASE_URL."dashboard-config");
            exit();
        } else {
            
            $stmt->close();
            $conn->close();

            if(empty($_SESSION['error'])){$_SESSION['error'] = $stmt->error;}
            header("Location: ".BASE_URL."dashboard-config");
            exit();
        }

    }
    elseif($task == 'update'){  

        if(empty($_POST['user_id'])){
            $conn->close();

            if(empty($_SESSION['error'])){$_SESSION['error'] = "Data submit Failed.";}
            header("Location: ".BASE_URL."dashboard-config");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(!empty($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT) !== false){

                $dir_path        = '/images/dashboard/timeline/';

                if(!empty($_FILES['addImage'])){
                    $store_img       = store_file($_FILES['addImage']??null, $dir_path);
                    if(empty($store_img->err_msg)){
                        $addImage = $store_img->dest_path;
                    }else{
                        $_SESSION['error'] = $store_img->err_msg;
                    }
                }
                $id           = $_POST['id']??'';
                $name           = $_POST['name']??'';
                $dashboard      = $_POST['dashboard']??'0';
                $description    = json_encode($_POST['description']??'');
                $image          = json_encode($_POST['image']??'');
                $modified        = date('ymdHis');
                $ordering           = $_POST['ordering'];

                $stmt = $conn->prepare('UPDATE `dashboard_timeline` SET name=?, dashboard=?, description=?, image=?, modified=?, ordering=? WHERE id=?');
                $stmt->bind_param("sssssii", $name, $dashboard, $description, $image, $modified, $ordering, $id);

                if ($stmt->execute()) {
                    $_SESSION['success'] = "Timeline updated successfully.";
                } else {
                    $_SESSION['error'] = "Timeline updating record: " . $stmt->error;
                }

                $stmt->close();
                $conn->close();
                header("Location: ".BASE_URL."dashboard-timeline?id=".$dashboard."&p=".$id."");
                exit();

            }else {

                $conn->close();
                $_SESSION['error'] = "Update Failed: Invalid ID parameter";
                header("Location: ".BASE_URL."dashboard-timeline?id=".$dashboard."&p=".$id."");
                exit();
            }
        }
    }
    elseif($task == 'delete')
    {
        if (!isset($_GET['id'])) {

            $conn->close();
            $_SESSION['error'] = "Error: ID parameter missing.";
            header("Location: ".BASE_URL."dashboard-config");
            exit();
        }
        
        $stmt = $conn->prepare("DELETE FROM `dashboard_timeline` WHERE id = ?");
        $stmt->bind_param("i", $id); 
        
        $id = $_GET['id'];
        if ($stmt->execute()) {
            $_SESSION['success'] = "Success: Record deleted successfully.";
        } else {
            $_SESSION['error'] = "Error: Failed deleting record " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();
        
        header("Location: ".BASE_URL."dashboard-config");
        exit();
    }
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
?>