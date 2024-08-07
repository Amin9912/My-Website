<?php include '../config.php'; ?>
<?php
session_start();
include('dbConn.php');

$checkEmailStmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
$checkEmailStmt->bind_param("s", $_POST['email']);
$checkEmailStmt->execute();
$checkEmailStmt->store_result();

if ($checkEmailStmt->num_rows == 0) {
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?) ");
    $stmt->bind_param("sss", $username, $email, $password);

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    if ($stmt->execute()) {
        $_SESSION['success'] = "Register successfully!";
        $stmt->close();
        header("Location:".BASE_URL.'register');
        exit();
    } else {
        $_SESSION['error'] = $stmt->error;
        $stmt->close();
    }
} else {
    $_SESSION['error'] = "This email has been used";
    header("Location:".BASE_URL.'register');
    exit();
}

$checkEmailStmt->close();
$conn->close();
?>