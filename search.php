<?php
session_start();
require 'config.php'; // เชื่อมต่อฐานข้อมูล

// รับค่าจากฟอร์ม
$pickup_date = isset($_GET['pickup_date']) ? $_GET['pickup_date'] : '';
$pickup_location = isset($_GET['pickup_location']) ? $_GET['pickup_location'] : '';
$car_type = isset($_GET['car_type']) ? $_GET['car_type'] : '';
$car_model = isset($_GET['car_model']) ? $_GET['car_model'] : '';
$car_brand = isset($_GET['car_brand']) ? $_GET['car_brand'] : ''; // แบรนด์รถ

// สร้างคำสั่ง SQL
$sql = "SELECT * FROM cars WHERE status = 'available'";

// เพิ่มเงื่อนไขการค้นหาจากฟอร์ม
$params = [];
if (!empty($pickup_location)) {
    $sql .= " AND location LIKE ?";
    $params[] = "%$pickup_location%";
}
if (!empty($car_type)) {
    $sql .= " AND type = ?";
    $params[] = $car_type;
}
if (!empty($car_model)) {
    $sql .= " AND model LIKE ?";
    $params[] = "%$car_model%";
}
if (!empty($car_brand)) { // ค้นหาจากแบรนด์
    $sql .= " AND brand LIKE ?";
    $params[] = "%$car_brand%";
}

// เตรียมคำสั่ง SQL
$stmt = $conn->prepare($sql);

// ผูกค่าพารามิเตอร์ (ตรวจสอบว่ามีค่าที่ต้องใช้หรือไม่)
if (!empty($params)) {
    $types = str_repeat('s', count($params)); // กำหนดชนิดของข้อมูล (ทั้งหมดเป็น string)
    $stmt->bind_param($types, ...$params);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ผลการค้นหา - CarRentHub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="all.css">
    <style>
        .card {
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* เพิ่มเงาเพื่อให้กรอบดูมีมิติ */
            border-radius: 10px; /* มุมโค้งมน */
            margin-bottom: 30px; /* ให้ระยะห่างระหว่างการ์ด */
            overflow: hidden; /* ป้องกันเนื้อหาที่เกินออกจากขอบการ์ด */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* เพิ่มการเคลื่อนไหวเมื่อเลื่อนเมาส์ */
        }

        .card:hover {
            transform: translateY(-5px); /* เมื่อเลื่อนเมาส์การ์ดจะเลื่อนขึ้น */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* เพิ่มเงาเมื่อมีการ hover */
        }

        .card-body {
            padding: 20px; /* เพิ่มระยะห่างภายในการ์ด */
        }

        .card-title {
            font-size: 1.25rem; /* ขนาดตัวอักษรของชื่อรถ */
            font-weight: bold;
            margin-bottom: 15px; /* เพิ่มระยะห่างใต้ชื่อรถ */
        }

        .card-text {
            font-size: 1rem; /* ขนาดตัวอักษร */
            margin-bottom: 10px; /* ระยะห่างระหว่างบรรทัด */
        }

        .card-img-top {
            width: 100%;
            height: 200px; /* ลดความสูงของรูป */
            object-fit: cover; /* ทำให้รูปเต็มพื้นที่โดยไม่ผิดสัดส่วน */
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .card-body .btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }

        /* ปรับให้การ์ดในแต่ละคอลัมน์เท่ากัน */
        .row .col-md-4 {
            display: flex;
            justify-content: center;
        }

        .search-box {
            max-width: 600px;
            margin: auto;
            border-radius: 50px;
            background: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">🔍 ผลการค้นหา</h2>
        <div class="text-end mt-3">
            <a href="category.php" class="btn btn-secondary">กลับไป</a>
        </div>
        <!-- ฟอร์มการค้นหา -->
        <form method="GET" action="search.php">
            <div class="mb-3">
                <label for="car_brand" class="form-label">แบรนด์ของรถ</label>
                <input type="text" class="form-control" id="car_brand" name="car_brand" value="<?php echo htmlspecialchars($car_brand); ?>">
            </div>
            <button type="submit" class="btn btn-primary">ค้นหา</button>
        </form>

        <hr>

        <?php if ($result->num_rows > 0): ?>
            <div class="row">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="show_image.php?car_id=<?php echo $row['id']; ?>" class="card-img-top" alt="<?php echo $row['brand']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['brand'] . ' ' . $row['model']; ?></h5>
                                <p class="card-text">ราคาเริ่มต้น <?php echo $row['price_per']; ?> บาท/วัน</p>
                                <a href="details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">รายละเอียด</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-danger text-center">ไม่พบรถที่ตรงกับเงื่อนไขของคุณ</div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
