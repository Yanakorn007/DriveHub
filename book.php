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

// ตรวจสอบว่ารถถูกจองแล้วหรือไม่
if ($car['status'] === 'booked' || $car['status'] === 'sold') {
    die("รถคันนี้ถูกจองไปแล้ว");
}

// รับค่าจากฟอร์มเมื่อผู้ใช้ทำการจอง
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $start_date = $_POST['start_date'];

    // คำนวณราคาการจอง (เช่น จำนวนวัน * ราคา)
    $start_date_timestamp = strtotime($start_date);
    $days = 1;  // สมมติว่าจองแค่วันเดียว
    $total_price = $days * $car['price_per'];

    // บันทึกข้อมูลการจอง
    $sql = "INSERT INTO bookings (user_id, car_id, start_date, total_price, created_at) 
            VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisd", $user_id, $car_id, $start_date, $total_price);

    if ($stmt->execute()) {
        // อัปเดตสถานะของรถเป็น 'reserved'
        $status = 'booked';
        $sql = "UPDATE cars SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $car_id);
        $stmt->execute();
    
        $_SESSION['success_message'] = "จองรถสำเร็จ! ทีมงานจะติดต่อกลับภายใน 24 ชม.";
        header('Location: index.php');
        exit();
    } else {
        $_SESSION['error_message'] = "เกิดข้อผิดพลาดในการจอง";
        header('Location: book.php?car_id=' . $car_id);
        exit();
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
    <link rel="stylesheet" href="all.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
        <a class="navbar-brand" href="/">
    <img src="images/logo1.png" alt="UsedCarHub Logo" height="60"> <!-- ปรับ height ให้ใหญ่ขึ้น -->
</a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">หน้าแรก</a></li>
                    <li class="nav-item"><a class="nav-link" href="category.php">การจองของฉัน</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">จองรถ</h2>
        <div class="card">
            <div class="card-body">
                <h4><?= htmlspecialchars($car['brand'] . " " . $car['model']) ?></h4>
                <p>ปี: <?= htmlspecialchars($car['year']) ?></p>
                <p>ทะเบียน: <?= htmlspecialchars($car['license_plate']) ?></p>
                <p>ราคา: <?= number_format($car['price_per']) ?> บาท</p>
                <img src="data:<?= $car['image_type'] ?>;base64,<?= base64_encode($car['image']) ?>" width="300px">
            </div>
        </div>

        <form action="book.php?car_id=<?= $car_id ?>" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="start_date" class="form-label">วันที่เริ่มต้น</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <button type="submit" class="btn btn-primary">ยืนยันการจอง</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
