<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start(); 
include('config.php');

// รับข้อมูลจากฟอร์ม
$fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : ''; // รับข้อมูล username
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

// ตรวจสอบว่ารหัสผ่านและยืนยันรหัสผ่านตรงกันหรือไม่
if ($password !== $confirm_password) {
    $_SESSION['error_message'] = "รหัสผ่านไม่ตรงกัน";
    header("Location: register.php"); // กลับไปที่หน้าแบบฟอร์มสมัครสมาชิก
    exit();
}

// ป้องกัน SQL Injection
$fullname = $conn->real_escape_string($fullname);
$email = $conn->real_escape_string($email);
$phone = $conn->real_escape_string($phone);
$username = $conn->real_escape_string($username); // ป้องกัน SQL Injection ใน username

// แฮชรหัสผ่านก่อนเก็บลงฐานข้อมูล
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// ตรวจสอบว่าอีเมลซ้ำในฐานข้อมูลหรือไม่
$sql_check_email = "SELECT * FROM users WHERE email = ?";
$stmt_check = $conn->prepare($sql_check_email);
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // ถ้าอีเมลซ้ำ
    $_SESSION['error_message'] = "อีเมลนี้ถูกใช้งานแล้ว";
    header("Location: register.php"); // กลับไปที่หน้าแบบฟอร์มสมัครสมาชิก
    exit();
}

// ถ้าอีเมลไม่ซ้ำ เพิ่มข้อมูลลงในฐานข้อมูล
$sql_insert = "INSERT INTO users (username, fullname, email, phone, password_hash, role) VALUES (?, ?, ?, ?, ?, 'customer')";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("sssss", $username, $fullname, $email, $phone, $password_hash);

// ตรวจสอบว่าการเพิ่มข้อมูลสำเร็จหรือไม่
if ($stmt_insert->execute()) {
    // ถ้าสำเร็จ
    $_SESSION['success_message'] = "สมัครสมาชิกสำเร็จ! กรุณาล็อกอิน";
    header("Location: login.php"); // เปลี่ยนเส้นทางไปหน้าล็อกอิน
} else {
    // ถ้าไม่สำเร็จ
    $_SESSION['error_message'] = "เกิดข้อผิดพลาดในการสมัครสมาชิก: " . $stmt_insert->error;
    header("Location: register.php"); // กลับไปที่หน้าแบบฟอร์มสมัครสมาชิก
}

// ปิดการเชื่อมต่อฐานข้อมูล
$stmt_insert->close();
$stmt_check->close();
$conn->close();
?>
