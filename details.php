<?php
session_start();
require 'config.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่ามีการส่ง car_id หรือไม่
if (isset($_GET['id'])) {
    $car_id = $_GET['id'];

    // ดึงข้อมูลรายละเอียดของรถจากฐานข้อมูล
    $sql = "SELECT * FROM cars WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // ถ้ามีข้อมูลรถในฐานข้อมูล
    if ($result->num_rows > 0) {
        $car = $result->fetch_assoc();
    } else {
        // หากไม่มีข้อมูลรถ
        echo "<script>alert('ไม่พบข้อมูลรถที่คุณต้องการ'); window.location.href='index.php';</script>";
        exit();
    }
} else {
    // หากไม่ได้รับ car_id จาก URL
    echo "<script>alert('ไม่พบข้อมูลรถที่คุณต้องการ'); window.location.href='index.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดรถ - CarRentHub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="all.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
        <a class="navbar-brand" href="/">
    <img src="images/logo1.png" alt="UsedCarHub Logo" height="60"> <!-- ปรับ height ให้ใหญ่ขึ้น -->
</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">หน้าแรก</a></li>
                    <li class="nav-item"><a class="nav-link" href="category.php">ข้อมูลรถยนต์</a></li>
                    <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                        <!-- ถ้าผู้ใช้ล็อกอินแล้ว -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> <?php echo $_SESSION['username']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="profile.php">ข้อมูลผู้ใช้</a></li>
                                <li><a class="dropdown-item" href="logout.php">ออกจากระบบ</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- ถ้ายังไม่ได้ล็อกอิน -->
                        <li class="nav-item"><a class="nav-link" href="login.php">เข้าสู่ระบบ</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">สมัครสมาชิก</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Car Details -->
    <div class="container mt-5">
        <h2 class="text-center">รายละเอียดรถ</h2>
        
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <!-- แสดงภาพจากฐานข้อมูล -->
                    <img src="get_image.php?car_id=<?php echo $car['id']; ?>" class="card-img-top" alt="<?php echo $car['brand']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $car['brand'] . ' ' . $car['model']; ?></h5>
                        <p class="card-text">ปี: <?php echo $car['year']; ?></p>
                        <p class="card-text">ป้ายทะเบียน: <?php echo $car['license_plate']; ?></p>
                        <p class="card-text">ราคาเริ่มต้น: ฿<?php echo number_format($car['price_per'], 2); ?></p>
                        <p class="card-text">สถานะ: <?php echo ucfirst($car['status']); ?></p>
                        <p class="card-text">รายละเอียดเพิ่มเติม: <?php echo $car['description']; ?></p>
                        <a href="book.php?car_id=<?php echo $car['id']; ?>" class="btn btn-success w-100">จองรถ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 mt-5 bg-dark text-white">
        <p>&copy; 2025 CarRentHub | All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
