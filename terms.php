<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อตกลงและเงื่อนไข - CarHub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> 
    <link rel="stylesheet" href="all.css">
    <style>
        /* CSS สำหรับ Sticky Footer */
        body {
            margin-bottom: 80px; /* ให้มีพื้นที่ระหว่างฟุตเตอร์กับเนื้อหาหลัก */
        }

        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 20px 0;
            background-color: #343a40; /* สีพื้นหลังของฟุตเตอร์ */
            color: white; /* สีตัวหนังสือในฟุตเตอร์ */
            text-align: center; /* จัดตำแหน่งตัวหนังสือให้อยู่กลาง */
            font-size: 14px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 15px;
            padding-right: 15px;
        }
    </style>
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
                    <li class="nav-item"><a class="nav-link" href="review.php">รีวิว</a></li>
                    <li class="nav-item"><a class="nav-link" href="category.php">ข้อมูลรถยนต์</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">เกี่ยวกับเรา</a></li>
                    <li class="nav-item"><a class="nav-link" href="terms.php">ข้อตกลงและเงื่อนไข</a></li>
                    <li class="nav-item"><a class="nav-link" href="privacy.php">นโยบายความเป็นส่วนตัว</a></li>
                    <!-- เพิ่มการตรวจสอบสถานะผู้ใช้ที่นี่ -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- ข้อตกลงและเงื่อนไข -->
    <div class="container mt-5">
        <h2 class="text-center">ข้อตกลงและเงื่อนไข</h2>
        <h4>1. การใช้บริการ</h4>
        <p>การใช้บริการของ CarHub ถือว่าผู้ใช้ยอมรับข้อตกลงและเงื่อนไขทั้งหมดที่ระบุไว้ในที่นี้.</p>

        <h4>2. ความรับผิดชอบ</h4>
        <p>ผู้ใช้บริการต้องรับผิดชอบต่อข้อมูลที่ให้ไว้ในเว็บไซต์ โดยต้องให้ข้อมูลที่ถูกต้องและเป็นจริง.</p>

        <h4>3. การเปลี่ยนแปลง</h4>
        <p>CarHub ขอสงวนสิทธิ์ในการเปลี่ยนแปลงข้อตกลงและเงื่อนไขโดยไม่ต้องแจ้งให้ทราบล่วงหน้า.</p>
    </div>

    <!-- Footer -->
    <footer class="footer bg-dark text-white py-5">
        <div class="container text-center">
            <p>&copy; 2025 CarHub | All Rights Reserved</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
