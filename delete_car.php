<?php
session_start();
require 'config.php'; // เชื่อมต่อฐานข้อมูล

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php"); // ถ้าไม่ได้ล็อกอินจะให้ไปที่หน้าเข้าสู่ระบบ
    exit();
}

if (isset($_GET['id'])) {
    $car_id = $_GET['id'];

    // SQL ลบรถ
    $sql = "DELETE FROM cars WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);

    if ($stmt->execute()) {
        echo "<script>alert('ลบรถสำเร็จ'); window.location.href='manage_cars.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการลบรถ');</script>";
    }
}

$conn->close();
?>
