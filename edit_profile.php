<?php
session_start();

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือยัง
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: all.php');
    exit();
}

// หากมีการส่งข้อมูลจากฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phone'] = $_POST['phone'];

    // คุณสามารถบันทึกข้อมูลใหม่ลงในฐานข้อมูลได้ที่นี่ (หากต้องการ)
    // ถ้าไม่บันทึกข้อมูลในฐานข้อมูล แค่บันทึกไว้ใน session ก็พอ
    echo "<script>alert('ข้อมูลโปรไฟล์ของคุณได้รับการอัปเดต'); window.location.href='profile.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขโปรไฟล์ - CarRentHub</title>
    <link rel="stylesheet" href="edit_profile.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">แก้ไขโปรไฟล์ของคุณ</h2>
                <div class="profile-box">
                    <form method="POST" action="edit_profile.php">
                        <div class="form-group">
                            <label for="username" class="form-label">ชื่อผู้ใช้</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $_SESSION['username']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">อีเมล์</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label">เบอร์โทร</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $_SESSION['phone']; ?>" required>
                        </div>
                        </div>
                    <button type="submit" class="btn btn-warning w-75">อัปเดตข้อมูล</button>
                    <button type="button" class="btn btn-warning w-75" onclick="window.location.href='profile.php';">กลับไปที่โปรไฟล์</button>
                </form>
            </div>
            </div>
        </div>
    </div>
</body>
</html>
