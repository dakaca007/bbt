<?php
session_start();

function registerUser($username, $email, $password) {
    $db = new Database();
    $conn = $db->connect();
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $data = [
        'username' => $username,
        'email' => $email,
        'password' => $hashed_password
    ];
    
    try {
        return $db->insert('blog_users', $data);
    } catch (PDOException $e) {
        return false;
    }
}

function loginUser($username, $password) {
    $db = new Database();
    $conn = $db->connect();
    
    $user = $db->select('blog_users', ["username = '$username'"]);
    if ($user && password_verify($password, $user[0]['password'])) {
        $_SESSION['user_id'] = $user[0]['id'];
        $_SESSION['username'] = $user[0]['username'];
        return true;
    }
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
?>
