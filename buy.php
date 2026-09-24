<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบสิทธิ์การเข้าถึง
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// รับค่า car_id จาก URL
if (!isset($_GET['car_id'])) {
    die("ไม่พบข้อมูลรถ");
}

$car_id = intval($_GET['car_id']);

// ดึงข้อมูลรถจากฐานข้อมูล
$sql = "SELECT * FROM cars WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();

if (!$car) {
    die("ไม่พบรถที่ต้องการจอง");
}

// ตรวจสอบว่ารถถูกจองไปแล้วหรือไม่
if ($car['status'] === 'booked') {
    die("<script>alert('รถคันนี้ถูกจองไปแล้ว'); window.location.href='index.php';</script>");
}

// บันทึกข้อมูลการจอง
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $status = 'booked'; // ตั้งสถานะจอง

    // อัปเดตสถานะรถในฐานข้อมูล
    $sql = "UPDATE cars SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $car_id);

    if ($stmt->execute()) {
        echo "<script>alert('จองรถสำเร็จ! กรุณารอการติดต่อจากทีมงาน'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการจอง');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จองรถ - DriveHub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">🚗 DriveHub</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">หน้าแรก</a></li>
                    <li class="nav-item"><a class="nav-link" href="my_reservations.php">การจองของฉัน</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">จองรถเพื่อซื้อ</h2>
        <div class="card">
            <div class="card-body">
                <h4><?= htmlspecialchars($car['brand'] . " " . $car['model']) ?></h4>
                <p>ปี: <?= htmlspecialchars($car['year']) ?></p>
                <p>ทะเบียน: <?= htmlspecialchars($car['license_plate']) ?></p>
                <p>ราคา: <?= number_format($car['price']) ?> บาท</p>
                <img src="data:<?= $car['image_type'] ?>;base64,<?= base64_encode($car['image']) ?>" width="300px">
            </div>
        </div>

        <form action="buy.php?car_id=<?= $car_id ?>" method="POST" class="mt-4">
            <button type="submit" class="btn btn-success">ยืนยันการจอง</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
