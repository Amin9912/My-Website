<?php
session_start();
function validateOpaqueToken($token) {
    include 'dbConn.php';
    $stmt = $conn->prepare("SELECT p.users as id,users.role,users.username,p.expires_at FROM user_tokens as p LEFT JOIN users as users ON users.id = p.users WHERE token = ? LIMIT 1");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_object();
        if (new DateTime() < new DateTime($row->expires_at)) {
            return $row;
        }
    }
    return false;
}

if(!empty($_SESSION['opaqueToken'])){
  $user = validateOpaqueToken($_SESSION['opaqueToken']);
  if ($user) {
      return $user;
  } else {
      header("Location: ".BASE_URL."token-expired");
      exit();
  }
}else {
      header("Location: ".BASE_URL."token-expired");
      exit();
  }
