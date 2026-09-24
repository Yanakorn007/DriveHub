<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php"); // ถ้าไม่ได้ล็อกอินจะให้ไปที่หน้าเข้าสู่ระบบ
    exit();
}

// ตรวจสอบว่ามีการส่ง car_id มาหรือไม่
if (isset($_GET['id'])) {
    $car_id = $_GET['id'];

    // ดึงข้อมูลรถจากฐานข้อมูล
    $sql = "SELECT * FROM cars WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // ถ้าพบข้อมูลรถ
    if ($result->num_rows > 0) {
        $car = $result->fetch_assoc();
    } else {
        echo "<script>alert('ไม่พบข้อมูลรถที่คุณต้องการ'); window.location.href='manage_cars.php';</script>";
        exit();
    }
} else {
    // ถ้าไม่ได้ส่ง car_id มาหรือไม่พบรถ
    echo "<script>alert('ไม่พบข้อมูลรถที่คุณต้องการ'); window.location.href='manage_cars.php';</script>";
    exit();
}

// ถ้าผู้ใช้ส่งข้อมูลมาแล้วให้ทำการอัปเดตข้อมูลรถ
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $license_plate = $_POST['license_plate'];
    $price_per = $_POST['price_per'];
    $status = $_POST['status'];
    $description = $_POST['description'];

    // SQL สำหรับอัปเดตข้อมูลรถ
    $sql = "UPDATE cars SET brand = ?, model = ?, year = ?, license_plate = ?, price_per = ?, status = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissssi", $brand, $model, $year, $license_plate, $price_per, $status, $description, $car_id);

    if ($stmt->execute()) {
        echo "<script>alert('อัปเดตข้อมูลรถสำเร็จ'); window.location.href='manage_cars.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลรถ - CarRentHub</title>
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
                    <li class="nav-item"><a class="nav-link" href="manage_cars.php">จัดการรถยนต์</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">แก้ไขข้อมูลรถ</h2>
        
        <!-- ฟอร์มแก้ไขข้อมูลรถ -->
        <form action="edit_car.php?id=<?php echo $car['id']; ?>" method="POST">
            <div class="mb-3">
                <label for="brand" class="form-label">แบรนด์</label>
                <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $car['brand']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">รุ่น</label>
                <input type="text" class="form-control" id="model" name="model" value="<?php echo $car['model']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">ปี</label>
                <input type="number" class="form-control" id="year" name="year" value="<?php echo $car['year']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="license_plate" class="form-label">ป้ายทะเบียน</label>
                <input type="text" class="form-control" id="license_plate" name="license_plate" value="<?php echo $car['license_plate']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="price_per" class="form-label">ราคา</label>
                <input type="number" class="form-control" id="price_per" name="price_per" value="<?php echo $car['price_per']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">สถานะ</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="available" <?php echo ($car['status'] == 'available') ? 'selected' : ''; ?>>พร้อมจอง</option>
                    <option value="rented" <?php echo ($car['status'] == 'rented') ? 'selected' : ''; ?>>จองแล้ว</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">รายละเอียด</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo $car['description']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-success">อัปเดตข้อมูลรถ</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
