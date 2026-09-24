<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เกี่ยวกับเรา - CarHub</title>
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

    <header class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">DriveHub</a>
            <div class="navbar-nav">
                <a class="nav-link" href="index.php">หน้าแรก</a>
                <a class="nav-link" href="review.php">รีวิว</a>
                <a class="nav-link" href="category.php">ข้อมูลรถยนต์</a>
                <a class="nav-link" href="about.php">เกี่ยวกับเรา</a>
                <a class="nav-link" href="contact.php">ติดต่อเรา</a>
                <a class="nav-link active" href="help.php">ช่วยเหลือ</a>
            </div>
        </div>
    </header>

    <section class="help-section">
        <div class="container">
            <h2 class="section-title">คำถามที่พบบ่อย (FAQ)</h2>
            <div class="faq">
                <h3>การเลือกซื้อรถยนต์</h3>
                <p><strong>ถาม:</strong> ทำไมต้องซื้อรถจาก DriveHub?</p>
                <p><strong>ตอบ:</strong> เรามีรถยนต์คุณภาพจากแบรนด์ดังพร้อมการรับประกัน และบริการหลังการขายที่ดีเยี่ยม</p>
            </div>
            <div class="faq">
                <h3>การบริการลูกค้า</h3>
                <p><strong>ถาม:</strong> ฉันสามารถติดต่อฝ่ายบริการลูกค้าได้อย่างไร?</p>
                <p><strong>ตอบ:</strong> คุณสามารถติดต่อเราได้ที่โทรศัพท์ 123-456-789 หรือผ่านทางอีเมล support@drivehub.com</p>
            </div>
            <div class="faq">
                <h3>การชำระเงินและการจัดส่ง</h3>
                <p><strong>ถาม:</strong> DriveHub รองรับช่องทางการชำระเงินใดบ้าง?</p>
                <p><strong>ตอบ:</strong> เรารองรับการชำระเงินผ่านบัตรเครดิต, โอนเงินผ่านธนาคาร, และชำระเงินปลายทาง</p>
            </div>
        </div>
    </section>

    <footer>
        <p>© 2025 DriveHub. All rights reserved.</p>
    </footer>
</body>
</html>
