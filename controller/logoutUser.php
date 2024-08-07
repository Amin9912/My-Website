<?php include 'config.php'; ?>
<?php
session_start();
function revokeToken($token) {
    include 'dbConn.php';
    $stmt = $conn->prepare("DELETE FROM user_tokens WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
}

// Example usage
revokeToken($_SESSION['opaqueToken']);

session_destroy();
session_start();
$_SESSION['error'] = 'Logout Success!';

header("Location: ".BASE_URL."login");
?>