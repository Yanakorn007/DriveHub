<?php
session_start();
require 'config.php'; // เชื่อมต่อกับไฟล์ config.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // ตรวจสอบว่า input ไม่ว่าง
    if (!empty($name) && !empty($email) && !empty($message)) {
        // เตรียมคำสั่ง SQL
        $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";

        // เตรียมคำสั่ง
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $name, $email, $message); // "sss" คือการบอกชนิดของข้อมูล (string)
            // Execute the query
            if ($stmt->execute()) {
                echo "ข้อความของคุณถูกส่งเรียบร้อยแล้ว";
            } else {
                echo "เกิดข้อผิดพลาดในการส่งข้อความ";
            }
            $stmt->close();
        } else {
            echo "ไม่สามารถเตรียมคำสั่ง SQL ได้";
        }
    } else {
        echo "กรุณากรอกข้อมูลให้ครบถ้วน";
    }
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ติดต่อเรา - DriveHub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="all.css">
</head>
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
                <a class="nav-link active" href="contact.php">ติดต่อเรา</a>
                <a class="nav-link" href="help.php">ช่วยเหลือ</a>
            </div>
        </div>
    </header>

    <section class="contact-section">
        <div class="container">
            <h2 class="section-title">ติดต่อเรา</h2>
            <div class="row">
                <div class="col-md-6">
                    <form action="contact.php" method="POST">
                        <div class="form-group">
                            <label for="name">ชื่อ</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">อีเมล</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="message">ข้อความ</label>
                            <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">ส่งข้อความ</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <h4>ที่อยู่ของเรา</h4>
                    <p>DriveHub Co., Ltd.</p>
                    <p>123 ถนนสุขุมวิท กรุงเทพมหานคร, ไทย</p>
                    <h4>โทรศัพท์</h4>
                    <p>+66 123 456 789</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>© 2025 DriveHub. All rights reserved.</p>
    </footer>
</body>
</html>
