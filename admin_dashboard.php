<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าเป็นผู้ดูแลระบบ
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// ดึงจำนวนข้อมูลจากฐานข้อมูล
$total_users = $conn->query("SELECT COUNT(id) FROM users")->fetch_row()[0];
$total_cars = $conn->query("SELECT COUNT(id) FROM cars")->fetch_row()[0];
$total_bookings = $conn->query("SELECT COUNT(id) FROM bookings")->fetch_row()[0];

// ดึงรายการจองล่าสุด
$sql = "SELECT bookings.id, COALESCE(users.username, 'ไม่พบข้อมูล') AS username, 
               cars.brand, cars.model
        FROM bookings
        LEFT JOIN users ON bookings.user_id = users.id
        JOIN cars ON bookings.car_id = cars.id";
        
$bookings = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แดชบอร์ดผู้ดูแลระบบ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="all.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="images/logo1.png" alt="UsedCarHub Logo" height="60">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
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
    <h2 class="text-center">แดชบอร์ดผู้ดูแลระบบ</h2>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card" onclick="showDetails('users')">
                <div class="card-body">
                    <h5 class="card-title">จำนวนผู้ใช้</h5>
                    <p class="card-text"><?php echo $total_users; ?> คน</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" onclick="showDetails('cars')">
                <div class="card-body">
                    <h5 class="card-title">จำนวนรถ</h5>
                    <p class="card-text"><?php echo $total_cars; ?> คัน</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" onclick="showDetails('bookings')">
                <div class="card-body">
                    <h5 class="card-title">จำนวนการจอง</h5>
                    <p class="card-text"><?php echo $total_bookings; ?> รายการ</p>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-5">รายการจองล่าสุด</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>รหัสจอง</th>
                <th>ผู้ใช้</th>
                <th>รถ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $bookings->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['brand'] . ' ' . $row['model']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal แสดงรายละเอียด -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายละเอียด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
                กำลังโหลด...
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function showDetails(type) {
        let content = "";
        switch (type) {
            case 'users':
                content = "จำนวนผู้ใช้: <?php echo $total_users; ?> คน";
                break;
            case 'cars':
                content = "จำนวนรถทั้งหมด: <?php echo $total_cars; ?> คัน";
                break;
            case 'bookings':
                content = "จำนวนการจองทั้งหมด: <?php echo $total_bookings; ?> รายการ";
                break;
        }
        document.getElementById("modalContent").innerHTML = content;
        new bootstrap.Modal(document.getElementById('detailsModal')).show();
    }
</script>
</body>
</html>
