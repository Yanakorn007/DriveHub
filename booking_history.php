<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// เชื่อมต่อฐานข้อมูล
$mysqli = new mysqli("localhost", "root", "", "DriveHub");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

session_start();

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// เตรียมคำสั่ง SQL
$sql = "SELECT b.id AS booking_id, b.start_date, b.total_price, b.status AS booking_status, 
               c.brand, c.model, c.license_plate, c.status AS car_status
        FROM bookings b
        JOIN cars c ON b.car_id = c.id
        WHERE b.user_id = ? 
        ORDER BY b.start_date DESC LIMIT 25";

// เตรียม statement
$stmt = $mysqli->prepare($sql);

if ($stmt === false) {
    die('Error preparing statement: ' . $mysqli->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการจอง</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="all.css">
</head>
<body>


<!-- Header -->
<header class="bg-primary text-white text-center py-4">
    <h1>ประวัติการจองของคุณ</h1>
</header>

<!-- ปุ่มกลับไปหน้าแรก -->
<div class="container mt-3">
    <a href="index.php" class="btn btn-primary">กลับไปหน้าแรก</a>
</div>

<!-- เนื้อหาหลัก -->
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">รายการจองของคุณ</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>แบรนด์</th>
                        <th>รุ่น</th>
                        <th>ทะเบียนรถ</th>
                        <th>วันที่จอง</th>
                        <th>สถานะการจอง</th>
                        <th>สถานะรถ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 1;
                    while ($row = $result->fetch_assoc()):
                        $brand = $row['brand'] ?? 'ไม่ระบุ';
                        $car_model = $row['model'] ?? 'ไม่ระบุ';
                        $license_plate = $row['license_plate'] ?? 'ไม่ระบุ';
                        $status = $row['booking_status'] ?? 'ไม่ระบุ';
                        $car_status = $row['car_status'] ?? 'ไม่ระบุ';
                    ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td><?php echo $brand; ?></td>
                            <td><?php echo $car_model; ?></td>
                            <td><?php echo $license_plate; ?></td>
                            <td><?php echo $row['start_date']; ?></td>
                            <td><?php echo $status; ?></td>
                            <td><?php echo $car_status; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 fixed-bottom">
    <p class="mb-0">&copy; <?php echo date("Y"); ?> DriveHub. All rights reserved.</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$mysqli->close();
?>
