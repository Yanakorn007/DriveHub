<?php
require 'config.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าได้ส่ง ID ของรถที่ต้องการแสดงภาพมา
if (isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    // ดึงข้อมูลรูปภาพจากฐานข้อมูล
    $sql = "SELECT image, image_type FROM cars WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($image_data, $image_type);

    // ถ้าพบข้อมูลรูปภาพ
    if ($stmt->fetch()) {
        // กำหนด header type ให้ตรงกับรูปภาพ
        if ($image_type == 'image/jpeg') {
            header("Content-Type: image/jpeg");
        } elseif ($image_type == 'image/png') {
            header("Content-Type: image/png");
        } elseif ($image_type == 'image/gif') {
            header("Content-Type: image/gif");
        } else {
            header("Content-Type: application/octet-stream"); // กรณีที่ไฟล์ไม่ใช่ภาพที่รองรับ
        }
        echo $image_data;  // ส่งข้อมูลรูปภาพไปที่เบราว์เซอร์
    } else {
        echo "ไม่พบรูปภาพ!";
    }
    $stmt->close();
} else {
    echo "ไม่พบ car_id!";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
