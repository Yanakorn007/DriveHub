<?php
session_start();
require 'config.php'; // เชื่อมต่อฐานข้อมูล
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php"); // ถ้าไม่ได้ล็อกอินจะให้ไปที่หน้าเข้าสู่ระบบ
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการรถยนต์ - CarRentHub</title>
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
        <h2 class="text-center">รายการรถยนต์ทั้งหมด</h2>

        <!-- ปุ่มสำหรับเพิ่มรถใหม่ -->
        <a href="add_car.php" class="btn btn-primary mb-4">เพิ่มรถใหม่</a>

        <!-- ตารางแสดงรายการรถ -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>หมายเลข</th>
                    <th>แบรนด์</th>
                    <th>รุ่น</th>
                    <th>ปี</th>
                    <th>ป้ายทะเบียน</th>
                    <th>ราคา</th>
                    <th>สถานะ</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // ดึงข้อมูลจากฐานข้อมูล
                $sql = "SELECT * FROM cars";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['brand'] . "</td>";
                        echo "<td>" . $row['model'] . "</td>";
                        echo "<td>" . $row['year'] . "</td>";
                        echo "<td>" . $row['license_plate'] . "</td>";
                        echo "<td>฿" . number_format($row['price_per'], 2) . "</td>";
                        echo "<td>" . ucfirst($row['status']) . "</td>";
                        echo "<td>
                                <a href='edit_car.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>แก้ไข</a>
                                <a href='delete_car.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"คุณต้องการลบรถนี้จริงหรือไม่?\")'>ลบ</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>ไม่มีข้อมูลรถยนต์</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
