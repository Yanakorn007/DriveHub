<?php
require 'config.php'; // เชื่อมต่อฐานข้อมูล

if (isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    // ดึงข้อมูลรูปภาพจากฐานข้อมูล
    $sql = "SELECT image, image_type FROM cars WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($image_data, $image_type);
    
    if ($stmt->fetch()) {
        header("Content-Type: " . $image_type);
        echo $image_data;
    } else {
        // ถ้าไม่มีรูป ใช้รูป default
        header("Content-Type: image/jpeg");
        readfile("images/default_car.jpg");
    }
    $stmt->close();
}
?>
