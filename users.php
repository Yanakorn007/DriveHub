<?php
// รวมไฟล์ที่เชื่อมต่อฐานข้อมูล
include('config.php');

// ตรวจสอบการเข้าสู่ระบบ
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // ถ้ายังไม่ได้เข้าสู่ระบบ ให้นำไปหน้า login
    exit();
}

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// ปิดการเชื่อมต่อฐานข้อมูล
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลผู้ใช้</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>ข้อมูลผู้ใช้</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($user['fullname']); ?></h5>
                <p class="card-text"><strong>อีเมล:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p class="card-text"><strong>เบอร์โทร:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                <p class="card-text"><strong>ประเภทผู้ใช้:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
                <a href="edit_user.php" class="btn btn-warning">แก้ไขข้อมูล</a>
                <a href="logout.php" class="btn btn-danger">ออกจากระบบ</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
