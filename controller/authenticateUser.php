<?php include '../config.php'; ?>
<?php
session_start();

include(__DIR__.'/../model/dbConn.php');

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        session_regenerate_id(true);   

        $expiresAt = date('Y-m-d H:i:s', strtotime('+5 hour'));
        $userId = $user['id'];
        $opaqueToken = generateOpaqueToken();
        
        $stmt_token = $conn->prepare("INSERT INTO user_tokens (token, users, expires_at) VALUES (?, ?, ?)");
        $stmt_token->bind_param("sis", $opaqueToken, $userId, $expiresAt);
        if($stmt_token->execute()){

            setcookie("auth_token", $opaqueToken, [
                'expires' => strtotime('+5 hour'),
                'path' => '/',
                'domain' => '', // Use '' for localhost
                'secure' => false, // False for HTTP
                'httponly' => true, // Prevents access via JavaScript
                'samesite' => 'Lax', // Controls cross-site request sharing
            ]);
            $_SESSION['opaqueToken'] = $opaqueToken;
            $_SESSION['success'] = "Login Successfully!";

            header("Location: ".BASE_URL."home");
            exit();
        }else{
            $_SESSION['error'] = "Token Failed Generate";
            header("Location: ".BASE_URL."login");
        }
        
        
    } else {
        $_SESSION['error'] = "User not found";
        header("Location: ".BASE_URL."login");
    }
} else {

    $_SESSION['error'] = "User not found";
    header("Location: ".BASE_URL."login");
}

$stmt->close();
$conn->close();

function generateOpaqueToken($length = 32) {
    return bin2hex(random_bytes($length));
}
?>