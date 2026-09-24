<?php
session_start();  // เริ่มต้น session

// ลบข้อมูลใน session
session_unset();  // ลบข้อมูลใน session
session_destroy();  // ทำลาย session

// เปลี่ยนเส้นทางไปยังหน้าเข้าสู่ระบบหลังจากออกจากระบบ
header('Location:index.php');
exit();
?>
