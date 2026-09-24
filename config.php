<?php
$servername = "localhost";
$username = "root";  // ใช้ชื่อผู้ใช้ของคุณ
$password = "";      // ใช้รหัสผ่านของคุณ
$dbname = "DriveHub";  // ชื่อฐานข้อมูลของคุณ

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}
?>
