<?php
session_start();
require 'config.php';  // เชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['username'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['user_role'] = $user['role']; 

            // เช็คบทบาทของผู้ใช้แล้วส่งไปยังหน้าที่เหมาะสม
            if ($user['role'] === 'admin') {
                header('Location: admin_dashboard.php'); // ถ้าเป็น admin ไปหน้าผู้ดูแล
            } else {
                header('Location: index.php'); // ถ้าเป็น user ปกติไปหน้าแรก
            }
            exit();
        } else {
            $_SESSION['error_message'] = "รหัสผ่านไม่ถูกต้อง";
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['error_message'] = "อีเมลไม่ถูกต้อง";
        header('Location: login.php');
        exit();
    }
}
?>
