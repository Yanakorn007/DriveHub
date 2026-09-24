<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบสิทธิ์การเข้าถึง
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php"); // ถ้าไม่ได้ล็อกอินจะให้ไปที่หน้าเข้าสู่ระบบ
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $owner_id = $_SESSION['user_id']; // สมมติว่า user_id เก็บใน session
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $license_plate = $_POST['license_plate'];
    $price_per = $_POST['price_per'];
    $status = $_POST['status'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    
    // อัปโหลดรูปภาพ
    $image_data = null;
    $image_type = null;
    if (!empty($_FILES['image']['tmp_name'])) {
        $image_data = file_get_contents($_FILES['image']['tmp_name']);
        $image_type = $_FILES['image']['type'];
    }
    
    // SQL Insert Query
    $sql = "INSERT INTO cars (owner_id, brand, model, year, license_plate, price_per, status, type, location, description, image, image_type) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ississssssss", $owner_id, $brand, $model, $year, $license_plate, $price_per, $status, $type, $location, $description, $image_data, $image_type);
    
    if ($stmt->execute()) {
        echo "<script>alert('เพิ่มรถสำเร็จ'); window.location.href='manage_cars.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการเพิ่มรถ');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มรถใหม่ - CarRentHub</title>
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
                <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">แดชบอร์ด</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_cars.php">จัดการรถ</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_car.php">เพิ่มข้อมูลรถ</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php">หน้าแรก</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="text-center">เพิ่มรถใหม่</h2>
        <form action="add_car.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="brand" class="form-label">แบรนด์</label>
                <input type="text" class="form-control" id="brand" name="brand" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">รุ่น</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">ปี</label>
                <input type="number" class="form-control" id="year" name="year" required>
            </div>
            <div class="mb-3">
                <label for="license_plate" class="form-label">ป้ายทะเบียน</label>
                <input type="text" class="form-control" id="license_plate" name="license_plate" required>
            </div>
            <div class="mb-3">
                <label for="price_per" class="form-label">ราคา</label>
                <input type="number" class="form-control" id="price_per" name="price_per" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">สถานะ</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="available">พร้อมขาย</option>
                    <option value="rented">ขายแล้ว</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">ประเภทรถ</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="sedan">รถเก๋ง</option>
                    <option value="suv">รถกระบะ</option>
                    
                </select>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">สถานที่</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">รายละเอียด</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">อัปโหลดรูปภาพ</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-success">เพิ่มรถ</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
