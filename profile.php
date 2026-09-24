<?php
session_start();

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือยัง
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    // ถ้ายังไม่ได้ล็อกอิน ให้ไปที่หน้าเข้าสู่ระบบ
    header('Location: all.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรไฟล์ผู้ใช้</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <!-- Profile Section -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">โปรไฟล์ผู้ใช้</h2>
                <div class="card p-4">
                    <h4>ข้อมูลบัญชี</h4>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>ชื่อผู้ใช้:</strong> <?php echo $_SESSION['username']; ?></li>
                        <li class="list-group-item"><strong>อีเมล:</strong> <?php echo $_SESSION['email']; ?></li>
                        <li class="list-group-item"><strong>เบอร์โทร:</strong> <?php echo $_SESSION['phone']; ?></li>
                    </ul>
                </div>
                <div class="text-center mt-3">
                <a href="edit_profile.php" class="btn btn-warning w-75 mb-2">แก้ไขข้อมูลโปรไฟล์</a>
                <a href="index.php" class="btn btn-warning w-75">หน้าแรก</a>
                </div>
            </div>
        </div>
    </div>

   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
